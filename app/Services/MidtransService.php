<?php

namespace App\Services;
use Midtrans\Config as MidtransConfig;
use Midtrans\CoreApi;
use Midtrans\Transaction;
use App\Models\Transaction as TransactionModel;

class MidtransService
{
    public function __construct()
    {
        MidtransConfig::$serverKey    = env('MIDTRANS_SERVER_KEY');
        MidtransConfig::$isProduction = filter_var(env('MIDTRANS_IS_PRODUCTION', false), FILTER_VALIDATE_BOOLEAN);
        MidtransConfig::$isSanitized  = true;
        MidtransConfig::$is3ds        = true;
    }

    public function createQRIS($transactionId): array
    {
        $transaction = TransactionModel::find($transactionId);

        $params = [
            'payment_type'          => 'qris',
            'transaction_details'   => [
                'order_id'      => $transaction->invoice_number,
                'gross_amount'  => $transaction->total,
            ],
            'qris'  => [
                'acquirer'  => 'gopay'
            ]
        ];

        $response = CoreApi::charge($params);

        $qrUrl = null;
        if (!empty($resp->actions)) {
            foreach ($resp->actions as $a) {
                if (in_array($a->name, ['generate-qr-code-v2', 'generate-qr-code'])) {
                    $qrUrl = $a->url;
                    break;
                }
            }
        }

        return [
            'order_id' => $transaction->invoice_number,
            'status'   => $response->transaction_status ?? 'pending',
            'qr_url'   => $qrUrl,
            'raw'      => $response,
        ];
    }
}