<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DebugTransactionLoss extends Command
{
    protected $signature   = 'debug:transaction-loss
                                {--from=2025-11-02 : Tanggal mulai (Y-m-d)}
                                {--to=2026-03-15   : Tanggal akhir (Y-m-d)}';

    protected $description = 'Debug kerugian nyata: bandingkan cart JSON (transaction_data) vs total yang benar-benar tercatat (transaction.total). Hanya transaksi PAID.';

    public function handle(): void
    {
        $from = $this->option('from');
        $to   = $this->option('to');

        $this->info("💸 Debug Kerugian Transaksi (PAID only): $from s/d $to");
        $this->info(str_repeat('=', 80));

        Log::channel('single')->info('');
        Log::channel('single')->info('╔════════════════════════════════════════════════════════════════════════════╗');
        Log::channel('single')->info("║  DEBUG KERUGIAN TRANSAKSI (PAID)  |  $from  s/d  $to");
        Log::channel('single')->info('╚════════════════════════════════════════════════════════════════════════════╝');
        Log::channel('single')->info('');
        Log::channel('single')->info('  Metode: bandingkan SUM(cart.grandTotal) - discount_cart  dari transaction_data.cart');
        Log::channel('single')->info('          vs transaction.total yang benar-benar tercatat di DB');
        Log::channel('single')->info('  Filter: payment_status = paid, transaction_status != canceled');
        Log::channel('single')->info('');

        // Ambil semua transaction PAID beserta transaction_data-nya
        $rows = DB::select("
            SELECT
                t.id,
                t.invoice_number,
                DATE(t.transaction_date)    AS tanggal,
                t.total                     AS total_tercatat,
                t.subtotal                  AS subtotal_tercatat,
                t.discount                  AS discount_tercatat,
                t.qty                       AS qty_tercatat,
                td.cart                     AS cart_json,
                td.discountTransaction      AS discount_json,
                (SELECT COUNT(*) FROM `transaction_detail` WHERE transaction_id = t.id) AS count_detail_db,
                (SELECT COALESCE(SUM(total), 0) FROM `transaction_detail` WHERE transaction_id = t.id) AS sum_detail_db
            FROM `transaction` t
            LEFT JOIN `transaction_data` td ON td.invoice_number = t.invoice_number
            WHERE DATE(t.transaction_date) BETWEEN ? AND ?
              AND t.payment_status = 'paid'
              AND (t.transaction_status IS NULL OR t.transaction_status != 'canceled')
            ORDER BY t.transaction_date ASC
        ", [$from, $to]);

        $totalKerugian         = 0;
        $totalKerugianPerBulan = [];
        $problemList           = [];
        $noCartData            = 0;
        $matched               = 0;

        foreach ($rows as $row) {
            $bulan = substr($row->tanggal, 0, 7);

            if (!isset($totalKerugianPerBulan[$bulan])) {
                $totalKerugianPerBulan[$bulan] = [
                    'kerugian'       => 0,
                    'trx_bermasalah' => 0,
                    'trx_total'      => 0,
                    'total_tercatat' => 0,
                    'total_seharusnya' => 0,
                ];
            }

            $totalKerugianPerBulan[$bulan]['trx_total']++;
            $totalKerugianPerBulan[$bulan]['total_tercatat'] += (float) $row->total_tercatat;

            if (empty($row->cart_json)) {
                $noCartData++;
                $totalKerugianPerBulan[$bulan]['total_seharusnya'] += (float) $row->total_tercatat;
                continue;
            }

            $cart = json_decode($row->cart_json, true);
            if (!is_array($cart)) {
                $noCartData++;
                $totalKerugianPerBulan[$bulan]['total_seharusnya'] += (float) $row->total_tercatat;
                continue;
            }

            // Hitung subtotal dari cart JSON
            $cartSubtotal  = 0;
            $cartQty       = 0;
            $cartItemCount = count($cart);
            $cartDiscountProduct = 0;
            foreach ($cart as $item) {
                $baseAndDelta = ((float) ($item['basePrice'] ?? 0) + (float) ($item['priceDelta'] ?? 0) + (float) ($item['priceAddon'] ?? 0));
                $qty = (int) ($item['qty'] ?? 1);
                $cartSubtotal += $baseAndDelta * $qty;
                $cartDiscountProduct += (float) ($item['priceDiscount'] ?? 0) * $qty;
                $cartQty += $qty;
            }

            // Hitung discount transaksi dari JSON
            $cartDiscountTransaction = 0;
            $discountTransName = '';
            if (!empty($row->discount_json)) {
                $discountTrans = json_decode($row->discount_json, true);
                if (is_array($discountTrans)) {
                    foreach ($discountTrans as $dt) {
                        if (isset($dt['select']) && (int) $dt['select'] === 1) {
                            if (($dt['type'] ?? '') === 'nominal') {
                                $cartDiscountTransaction = (float) ($dt['value'] ?? 0);
                            } else {
                                $afterProductDiscount = $cartSubtotal - $cartDiscountProduct;
                                $cartDiscountTransaction = $afterProductDiscount * ((float) ($dt['value'] ?? 0) / 100);
                            }
                            $discountTransName = $dt['name'] ?? '';
                            break;
                        }
                    }
                }
            }

            $cartGrandTotal = $cartSubtotal - $cartDiscountProduct - $cartDiscountTransaction;
            $totalTercatat  = (float) $row->total_tercatat;
            $selisih        = $cartGrandTotal - $totalTercatat;

            $totalKerugianPerBulan[$bulan]['total_seharusnya'] += $cartGrandTotal;

            if (abs($selisih) >= 1) {  // toleransi pembulatan < 1
                $totalKerugian += $selisih;
                $totalKerugianPerBulan[$bulan]['kerugian']       += $selisih;
                $totalKerugianPerBulan[$bulan]['trx_bermasalah']++;

                $problemList[] = [
                    'tanggal'         => $row->tanggal,
                    'invoice'         => $row->invoice_number,
                    'cart_items'      => $cartItemCount,
                    'cart_qty'        => $cartQty,
                    'detail_db'       => $row->count_detail_db,
                    'sum_detail_db'   => (float) $row->sum_detail_db,
                    'qty_tercatat'    => $row->qty_tercatat,
                    'cart_subtotal'   => $cartSubtotal,
                    'cart_disc_prod'  => $cartDiscountProduct,
                    'cart_disc_trans' => $cartDiscountTransaction,
                    'disc_trans_name' => $discountTransName,
                    'cart_grand'      => $cartGrandTotal,
                    'disc_tercatat'   => (float) $row->discount_tercatat,
                    'total_tercatat'  => $totalTercatat,
                    'selisih'         => $selisih,
                    'cart'            => $cart,
                ];
            } else {
                $matched++;
            }
        }

        // ─────────────────────────────────────────────────────────────
        // LOG: REKAP PER BULAN
        // ─────────────────────────────────────────────────────────────
        Log::channel('single')->info('──────────────────────────────────────────────────────────────────────────────');
        Log::channel('single')->info('  KERUGIAN PER BULAN (PAID only)');
        Log::channel('single')->info('──────────────────────────────────────────────────────────────────────────────');
        Log::channel('single')->info(sprintf(
            '  %-8s | %-5s | %-5s | %18s | %18s | %14s',
            'Bulan', 'Trx', 'Error', 'Seharusnya', 'Tercatat', 'KERUGIAN'
        ));
        Log::channel('single')->info('  ' . str_repeat('-', 82));

        foreach ($totalKerugianPerBulan as $bulan => $data) {
            $flag = abs($data['kerugian']) > 0 ? '  ⚠️' : '  ✅';
            $line = sprintf(
                '  %-8s | %-5d | %-5d | %18s | %18s | %14s%s',
                $bulan,
                $data['trx_total'],
                $data['trx_bermasalah'],
                'Rp ' . number_format($data['total_seharusnya'], 0, ',', '.'),
                'Rp ' . number_format($data['total_tercatat'], 0, ',', '.'),
                'Rp ' . number_format($data['kerugian'], 0, ',', '.'),
                $flag
            );
            Log::channel('single')->info($line);
            $this->line($line);
        }

        // Grand total
        $grandSeharusnya = array_sum(array_column($totalKerugianPerBulan, 'total_seharusnya'));
        $grandTercatat   = array_sum(array_column($totalKerugianPerBulan, 'total_tercatat'));

        Log::channel('single')->info('');
        Log::channel('single')->info('══════════════════════════════════════════════════════════════════════════════');
        Log::channel('single')->info(sprintf(
            '  TOTAL KERUGIAN  =  Rp %s  |  dari %d transaksi bermasalah (dari %d total paid)',
            number_format($totalKerugian, 0, ',', '.'),
            count($problemList),
            count($rows)
        ));
        Log::channel('single')->info(sprintf(
            '  Omzet seharusnya =  Rp %s  |  Omzet tercatat = Rp %s',
            number_format($grandSeharusnya, 0, ',', '.'),
            number_format($grandTercatat, 0, ',', '.')
        ));
        Log::channel('single')->info('══════════════════════════════════════════════════════════════════════════════');

        $this->info('');
        $this->warn(sprintf(
            '💸 TOTAL KERUGIAN: Rp %s  (%d transaksi bermasalah dari %d total)',
            number_format($totalKerugian, 0, ',', '.'),
            count($problemList),
            count($rows)
        ));
        $this->info(sprintf(
            '   Omzet seharusnya: Rp %s  |  Omzet tercatat: Rp %s',
            number_format($grandSeharusnya, 0, ',', '.'),
            number_format($grandTercatat, 0, ',', '.')
        ));

        // ─────────────────────────────────────────────────────────────
        // LOG: DETAIL SETIAP TRANSAKSI BERMASALAH
        // ─────────────────────────────────────────────────────────────
        Log::channel('single')->info('');
        Log::channel('single')->info('──────────────────────────────────────────────────────────────────────────────');
        Log::channel('single')->info(sprintf('  DETAIL TRANSAKSI BERMASALAH (%d transaksi)', count($problemList)));
        Log::channel('single')->info('──────────────────────────────────────────────────────────────────────────────');

        if (count($problemList) === 0) {
            Log::channel('single')->info('  ✅ Tidak ada kerugian! Semua transaksi cart = total tercatat.');
            $this->info('✅ Tidak ada kerugian!');
        } else {
            foreach ($problemList as $p) {
                Log::channel('single')->info('');
                Log::channel('single')->info(sprintf(
                    '  [%s] %s', $p['tanggal'], $p['invoice']
                ));
                Log::channel('single')->info(sprintf(
                    '      Cart: %d item(s), qty=%d  |  DB detail: %d row(s), sum=Rp %s, qty_tercatat=%d',
                    $p['cart_items'], $p['cart_qty'], $p['detail_db'],
                    number_format($p['sum_detail_db'], 0, ',', '.'), $p['qty_tercatat']
                ));
                Log::channel('single')->info(sprintf(
                    '      Cart subtotal  : Rp %s', number_format($p['cart_subtotal'], 0, ',', '.')
                ));
                if ($p['cart_disc_prod'] > 0) {
                    Log::channel('single')->info(sprintf(
                        '      Disc product   : -Rp %s', number_format($p['cart_disc_prod'], 0, ',', '.')
                    ));
                }
                if ($p['cart_disc_trans'] > 0) {
                    Log::channel('single')->info(sprintf(
                        '      Disc transaksi : -Rp %s (%s)', number_format($p['cart_disc_trans'], 0, ',', '.'), $p['disc_trans_name']
                    ));
                }
                Log::channel('single')->info(sprintf(
                    '      Grand total    : Rp %s  (seharusnya dibayar)',
                    number_format($p['cart_grand'], 0, ',', '.')
                ));
                Log::channel('single')->info(sprintf(
                    '      Tercatat       : Rp %s  (disc DB=Rp %s)',
                    number_format($p['total_tercatat'], 0, ',', '.'),
                    number_format($p['disc_tercatat'], 0, ',', '.')
                ));

                $label = $p['selisih'] > 0 ? 'RUGI' : 'LEBIH BAYAR';
                Log::channel('single')->info(sprintf(
                    '      %s       : Rp %s',
                    $label,
                    number_format(abs($p['selisih']), 0, ',', '.')
                ));

                // Tampilkan item cart
                Log::channel('single')->info('      Item di cart:');
                foreach ($p['cart'] as $i => $item) {
                    $disc = (float) ($item['priceDiscount'] ?? 0);
                    $discLabel = $disc > 0 ? '  disc=-Rp ' . number_format($disc, 0, ',', '.') : '';
                    Log::channel('single')->info(sprintf(
                        '        [%d] %-30s qty=%-2d  base=Rp %-8s  grand=Rp %s%s',
                        $i + 1,
                        $item['name'] ?? '?',
                        $item['qty']  ?? 1,
                        number_format($item['basePrice'] ?? 0, 0, ',', '.'),
                        number_format($item['grandTotal'] ?? 0, 0, ',', '.'),
                        $discLabel
                    ));
                }
            }
        }

        // ─────────────────────────────────────────────────────────────
        // LOG: STATISTIK
        // ─────────────────────────────────────────────────────────────
        Log::channel('single')->info('');
        Log::channel('single')->info('──────────────────────────────────────────────────────────────────────────────');
        Log::channel('single')->info('  STATISTIK');
        Log::channel('single')->info('──────────────────────────────────────────────────────────────────────────────');
        Log::channel('single')->info(sprintf('  Transaksi paid diperiksa   : %d', count($rows)));
        Log::channel('single')->info(sprintf('  Transaksi cocok (aman)     : %d', $matched));
        Log::channel('single')->info(sprintf('  Transaksi bermasalah       : %d', count($problemList)));
        Log::channel('single')->info(sprintf('  Transaksi tanpa cart data  : %d', $noCartData));
        Log::channel('single')->info(sprintf('  Total kerugian estimasi    : Rp %s', number_format($totalKerugian, 0, ',', '.')));
        Log::channel('single')->info(sprintf('  Persentase error           : %.2f%%', count($rows) > 0 ? (count($problemList) / count($rows) * 100) : 0));
        Log::channel('single')->info('');
        Log::channel('single')->info('  ✔ Dijalankan: ' . now()->format('Y-m-d H:i:s'));
        Log::channel('single')->info('');

        $this->info('');
        $this->info(sprintf('  ✅ %d transaksi aman', $matched));
        $this->warn(sprintf('  ⚠️  %d transaksi bermasalah', count($problemList)));
        $this->info(sprintf('  ℹ️  %d transaksi tidak ada cart data', $noCartData));
        $this->info('');
        $this->info('✅ Selesai! Lihat detail lengkap di storage/logs/laravel.log');
    }
}
