<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Str;
use Xendit\Configuration;
use Xendit\PaymentRequest\PaymentRequestApi;
use Xendit\PaymentRequest\PaymentRequestParameters;
use Xendit\XenditSdkException;

class XenditService
{
    /**
     * @throws XenditSdkException
     */
    public function createQRIS($transactionId): array
    {
        $transaction = Transaction::find($transactionId);

        $uuid = (string) Str::uuid();
        $secret = config('services.xendit.secret_key', env('XENDIT_SECRET_KEY'));
        Configuration::setXenditKey($secret);

        $params = new PaymentRequestParameters([
            'reference_id'  => $transaction->invoice_number,
            'amount'        => $transaction->total,
            'currency'      => 'IDR',
            'country'       => 'ID',
            'payment_method'=> [
                'type'        => 'QR_CODE',
                'reusability' => 'ONE_TIME_USE',
                'qr_code'     => [
                    'channel_code' => 'QRIS',
                ],
            ],
        ]);

        $api = new PaymentRequestApi();
        $hitXendit = $api->createPaymentRequest($uuid, null, null, $params);
        $response = json_decode(json_encode($hitXendit), true);

        $qrString = null;
        if (!empty($response['actions']) && is_array($response['actions'])) {
            foreach ($response['actions'] as $action) {
                $type       = $action['type'] ?? '';
                $descriptor = strtoupper($action['descriptor'] ?? '');
                $value      = $action['value'] ?? null;

                if ($type === 'PRESENT_TO_CUSTOMER' && $value && str_contains($descriptor, 'QR')) {
                    $qrString = $value;
                    break;
                }
            }
        }

        if (!$qrString) {
            $qrString = $response['payment_method']['qr_code']['qr_string'] ?? null;
        }

        return [
            'payment_request_id' => $arr['id'] ?? null,
            'reference_id'       => $transaction->invoice_number,
            'status'             => $arr['status'] ?? null,
            'qr_string'          => $qrString,
        ];
    }
}