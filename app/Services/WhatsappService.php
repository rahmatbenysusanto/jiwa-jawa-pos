<?php

namespace App\Services;

class WhatsappService
{
    public function sendMessage($message): void
    {
        $ch = curl_init("https://whatsapp.venusverse.me/api/session/Kedai%20Selvin/send");

        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'X-Api-Key: 50508c9ce63a4a6e9dbe2726fb978160e17c609c25f646c299181d9cf2703a91'
            ],
            CURLOPT_POSTFIELDS => json_encode([
                'to' => env('WA'),
                'message' => $message
            ]),
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            logger()->error('WA CURL Error', [
                'error' => curl_error($ch)
            ]);
        }

        curl_close($ch);
    }
}