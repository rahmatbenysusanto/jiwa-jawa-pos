<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DebugTransactionTotal extends Command
{
    protected $signature   = 'debug:transaction-total
                                {--from=2026-01-01 : Tanggal mulai (Y-m-d)}
                                {--to=2026-03-15   : Tanggal akhir (Y-m-d)}';

    protected $description = 'Debug selisih total di tabel transaction vs sum(transaction_detail.total), per hari & per bulan';

    public function handle(): void
    {
        $from = $this->option('from');
        $to   = $this->option('to');

        $this->info("🔍 Debug Transaction Total: $from s/d $to");
        $this->info(str_repeat('=', 70));

        Log::channel('single')->info('');
        Log::channel('single')->info('╔══════════════════════════════════════════════════════════════════════╗');
        Log::channel('single')->info("║  DEBUG TRANSACTION TOTAL  |  $from  s/d  $to");
        Log::channel('single')->info('╚══════════════════════════════════════════════════════════════════════╝');
        Log::channel('single')->info('');

        // ─────────────────────────────────────────────────────────────
        // 1. DATA PER HARI
        // ─────────────────────────────────────────────────────────────
        $dailyData = DB::select("
            SELECT
                DATE(t.transaction_date)          AS tanggal,
                COUNT(DISTINCT t.id)              AS jumlah_transaksi,
                SUM(t.total)                      AS total_di_transaction,
                SUM(td.sum_detail)                AS total_di_detail,
                SUM(t.total) - SUM(td.sum_detail) AS selisih
            FROM `transaction` t
            LEFT JOIN (
                SELECT transaction_id, SUM(total) AS sum_detail
                FROM `transaction_detail`
                GROUP BY transaction_id
            ) td ON td.transaction_id = t.id
            WHERE DATE(t.transaction_date) BETWEEN ? AND ?
              AND (t.transaction_status IS NULL OR t.transaction_status != 'canceled')
            GROUP BY DATE(t.transaction_date)
            ORDER BY DATE(t.transaction_date) ASC
        ", [$from, $to]);

        // ─────────────────────────────────────────────────────────────
        // 2. DATA PER BULAN
        // ─────────────────────────────────────────────────────────────
        $monthlyData = DB::select("
            SELECT
                DATE_FORMAT(t.transaction_date, '%Y-%m') AS bulan,
                COUNT(DISTINCT t.id)                      AS jumlah_transaksi,
                SUM(t.total)                              AS total_di_transaction,
                SUM(td.sum_detail)                        AS total_di_detail,
                SUM(t.total) - SUM(td.sum_detail)         AS selisih
            FROM `transaction` t
            LEFT JOIN (
                SELECT transaction_id, SUM(total) AS sum_detail
                FROM `transaction_detail`
                GROUP BY transaction_id
            ) td ON td.transaction_id = t.id
            WHERE DATE(t.transaction_date) BETWEEN ? AND ?
              AND (t.transaction_status IS NULL OR t.transaction_status != 'canceled')
            GROUP BY DATE_FORMAT(t.transaction_date, '%Y-%m')
            ORDER BY bulan ASC
        ", [$from, $to]);

        // ─────────────────────────────────────────────────────────────
        // 3. TRANSAKSI BERMASALAH (selisih != 0)
        // ─────────────────────────────────────────────────────────────
        $problemRows = DB::select("
            SELECT
                t.id,
                t.invoice_number,
                DATE(t.transaction_date)               AS tanggal,
                t.qty                                  AS qty_header,
                t.subtotal                             AS subtotal_header,
                t.discount                             AS discount_header,
                t.total                                AS total_header,
                COALESCE(td.sum_detail, 0)             AS sum_detail,
                COALESCE(td.count_detail, 0)           AS count_detail,
                (t.total - COALESCE(td.sum_detail, 0)) AS selisih
            FROM `transaction` t
            LEFT JOIN (
                SELECT transaction_id,
                       SUM(total)  AS sum_detail,
                       COUNT(*)    AS count_detail
                FROM `transaction_detail`
                GROUP BY transaction_id
            ) td ON td.transaction_id = t.id
            WHERE DATE(t.transaction_date) BETWEEN ? AND ?
              AND (t.transaction_status IS NULL OR t.transaction_status != 'canceled')
              AND ABS(t.total - COALESCE(td.sum_detail, 0)) > 0
            ORDER BY t.transaction_date ASC
        ", [$from, $to]);

        // ─────────────────────────────────────────────────────────────
        // LOG: PER HARI
        // ─────────────────────────────────────────────────────────────
        Log::channel('single')->info('──────────────────────────────────────────────────────────────────────');
        Log::channel('single')->info('  REKAP PER HARI');
        Log::channel('single')->info('──────────────────────────────────────────────────────────────────────');
        Log::channel('single')->info(sprintf(
            '  %-12s | %-5s | %18s | %18s | %14s',
            'Tanggal', 'Trx', 'Total(transaction)', 'Total(detail)', 'SELISIH'
        ));
        Log::channel('single')->info('  ' . str_repeat('-', 75));

        $grandTotalTransaction = 0;
        $grandTotalDetail      = 0;

        foreach ($dailyData as $row) {
            $selisih                = (float) $row->selisih;
            $grandTotalTransaction += (float) $row->total_di_transaction;
            $grandTotalDetail      += (float) ($row->total_di_detail ?? 0);
            $flag                   = abs($selisih) > 0 ? '  ⚠️ SELISIH!' : '';

            $line = sprintf(
                '  %-12s | %-5d | %18s | %18s | %14s%s',
                $row->tanggal,
                $row->jumlah_transaksi,
                'Rp ' . number_format($row->total_di_transaction, 0, ',', '.'),
                'Rp ' . number_format($row->total_di_detail ?? 0, 0, ',', '.'),
                'Rp ' . number_format($selisih, 0, ',', '.'),
                $flag
            );
            Log::channel('single')->info($line);
            $this->line($line);
        }

        // ─────────────────────────────────────────────────────────────
        // LOG: PER BULAN
        // ─────────────────────────────────────────────────────────────
        Log::channel('single')->info('');
        Log::channel('single')->info('──────────────────────────────────────────────────────────────────────');
        Log::channel('single')->info('  REKAP PER BULAN');
        Log::channel('single')->info('──────────────────────────────────────────────────────────────────────');
        Log::channel('single')->info(sprintf(
            '  %-8s | %-5s | %18s | %18s | %14s',
            'Bulan', 'Trx', 'Total(transaction)', 'Total(detail)', 'SELISIH'
        ));
        Log::channel('single')->info('  ' . str_repeat('-', 70));

        foreach ($monthlyData as $row) {
            $selisih = (float) $row->selisih;

            $line = sprintf(
                '  %-8s | %-5d | %18s | %18s | %14s',
                $row->bulan,
                $row->jumlah_transaksi,
                'Rp ' . number_format($row->total_di_transaction, 0, ',', '.'),
                'Rp ' . number_format($row->total_di_detail ?? 0, 0, ',', '.'),
                'Rp ' . number_format($selisih, 0, ',', '.')
            );
            Log::channel('single')->info($line);
            $this->line($line);
        }

        // ─────────────────────────────────────────────────────────────
        // LOG: GRAND TOTAL
        // ─────────────────────────────────────────────────────────────
        $grandSelisih = $grandTotalTransaction - $grandTotalDetail;

        Log::channel('single')->info('');
        Log::channel('single')->info('══════════════════════════════════════════════════════════════════════');
        Log::channel('single')->info(sprintf(
            '  GRAND TOTAL (Jan–Mar 2026):  transaction = Rp %s  |  detail = Rp %s  |  SELISIH = Rp %s',
            number_format($grandTotalTransaction, 0, ',', '.'),
            number_format($grandTotalDetail,      0, ',', '.'),
            number_format($grandSelisih,          0, ',', '.')
        ));
        Log::channel('single')->info('══════════════════════════════════════════════════════════════════════');

        $this->info('');
        $this->info(sprintf(
            'GRAND TOTAL  →  transaction: Rp %s  |  detail: Rp %s  |  SELISIH: Rp %s',
            number_format($grandTotalTransaction, 0, ',', '.'),
            number_format($grandTotalDetail,      0, ',', '.'),
            number_format($grandSelisih,          0, ',', '.')
        ));

        // ─────────────────────────────────────────────────────────────
        // LOG: DAFTAR TRANSAKSI BERMASALAH
        // ─────────────────────────────────────────────────────────────
        Log::channel('single')->info('');
        Log::channel('single')->info('──────────────────────────────────────────────────────────────────────');
        Log::channel('single')->info(sprintf('  TRANSAKSI BERMASALAH (%d transaksi)', count($problemRows)));
        Log::channel('single')->info('──────────────────────────────────────────────────────────────────────');

        if (count($problemRows) === 0) {
            Log::channel('single')->info('  ✅ Tidak ada selisih! Semua transaksi sesuai.');
            $this->info('✅ Tidak ada selisih!');
        } else {
            Log::channel('single')->info(sprintf(
                '  %-12s | %-22s | %-4s | %14s | %14s | %12s',
                'Tanggal', 'Invoice', 'Det', 'Total(trx)', 'Sum(detail)', 'SELISIH'
            ));
            Log::channel('single')->info('  ' . str_repeat('-', 88));

            foreach ($problemRows as $row) {
                $line = sprintf(
                    '  %-12s | %-22s | %-4d | %14s | %14s | %12s',
                    $row->tanggal,
                    $row->invoice_number,
                    $row->count_detail,
                    'Rp ' . number_format($row->total_header, 0, ',', '.'),
                    'Rp ' . number_format($row->sum_detail,   0, ',', '.'),
                    'Rp ' . number_format($row->selisih,      0, ',', '.')
                );
                Log::channel('single')->info($line);
                $this->warn($line);
            }
        }

        Log::channel('single')->info('');
        Log::channel('single')->info('  ✔ Dijalankan: ' . now()->format('Y-m-d H:i:s'));
        Log::channel('single')->info('');

        $this->info('');
        $this->info('✅ Selesai! Cek log di storage/logs/laravel.log');
    }
}
