<?php

namespace App\Services;

class WhatsappService
{
    public function sendMessage($message): void
    {
        $ch = curl_init("https://whatsapp.venusverse.me/api/session/Kedai%20Selvin/send");

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'X-Api-Key: 50508c9ce63a4a6e9dbe2726fb978160e17c609c25f646c299181d9cf2703a91']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'to' => env('WA'),
            'message' => $message,
            'media' => [
                [
                    'type' => 'image',
                    'data' => '',
                    'caption' => '',
                    'filename' => '',
                    'mimetype' => ''
                ]
            ]
        ]));

        curl_exec($ch);
        curl_close($ch);
    }
}