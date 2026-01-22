<?php

namespace App\Services;

class WhatsappService
{
    public function sendMessageDefault($message): void
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

    public function sendMessage($message): void
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://gowa-lgzsmb7bsgvi.sgp-ramaparasu.sumopod.my.id/send/message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                'phone'     => env('WA'),
                'message'   => $message
            ]),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic OFJHczVWQWw6WFp5NUNwcEU2M1RDU2lBRDU3S0tTbURz',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://gowa-lgzsmb7bsgvi.sgp-ramaparasu.sumopod.my.id/send/message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                'phone'     => env('WA_2'),
                'message'   => $message
            ]),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic OFJHczVWQWw6WFp5NUNwcEU2M1RDU2lBRDU3S0tTbURz',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
}