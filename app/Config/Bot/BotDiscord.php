<?php
/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.my.id/
 */

namespace Config\Bot;

use CodeIgniter\Database\Config;
use CURLFile;

class BotDiscord extends Config
{
    public function sendImagePresence($webhook_url, $image, $description)
    {
        $request = [
            "username" => "Muhka Bot",
            "embeds" => [
                [
                    "title" => "Presence Notification",
                    "description" => $description,
                    "color" => 15258703,
                ]]
        ];
        $curl = curl_init();

        curl_setopt_array($curl,
            [
                CURLOPT_URL => $webhook_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => [
                    'payload_json' => json_encode($request),
                    'file1' => new CURLFILE($image),
                ],
            ]);

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }

    public function sendPresence($webhook_url, $description)
    {
        $request = [
            "username" => "Muhka Bot",
            "embeds" => [
                [
                    "title" => "Presence Notification",
                    "description" => $description,
                    "color" => 15258703,
                ]]
        ];
        $curl = curl_init();

        curl_setopt_array($curl,
            [
                CURLOPT_URL => $webhook_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => [
                    'payload_json' => json_encode($request),
                ],
            ]);

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }

}