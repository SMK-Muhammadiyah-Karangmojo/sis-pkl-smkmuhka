<?php
/*
 * Copyright (c) 2024. . Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.my.id/
 */

namespace App\Libraries;

use CodeIgniter\Database\BaseConnection;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

class WhatsappGatewayService
{

    protected Client $client;

    protected BaseConnection $db;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('WHATSAPP_GATEWAY_BASE_URL'),
            'timeout' => 10.0,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => '*/*',
                'x-api-key' => env('WHATSAPP_GATEWAY_API_KEY'),
            ]
        ]);
        $this->db = db_connect();
    }

    /**
     * @throws Exception
     */
    public function sendText($target, $content, $contentType = 'string', $options = [])
    {
        $request = [
            'json' => [
                'sessionId' => env('WHATSAPP_GATEWAY_SESSION'),
                'chatId' => $target,
                'contentType' => $contentType,
                'content' => $this->convertContent($contentType, $content),
                "options" => $options,
            ],
        ];
        try {
            $response = $this->client->post('/api/client/sendMessage', $request);
            $this->saveLog($response->getStatusCode(), $request, $response->getBody()->getContents(), "Send from WhatsApp Gateway to $target success", $target);
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            $this->saveLog(500, $request, $e, "Send from WhatsApp Gateway to $target failed", $target);
            return [
                'error' => true,
                'message' => json_encode($e->getMessage()),
            ];
        }
    }

    /**
     * @throws Exception
     */
    private function convertContent($contentType, $content): array|string|object
    {
        return match ($contentType) {
            'string', 'MessageMediaFromURL' => $content,
            'MessageMedia' => $this->prepareMessageMedia($content),
            'Location' => [
                'latitude' => null,
                'longitude' => null,
                'description' => null,
            ],
            default => null,
        };
    }
    private function prepareMessageMedia($filePath): array
    {
        return !file_exists($filePath) ? throw new Exception("File tidak ditemukan: $filePath") : [
            "mimetype" => mime_content_type($filePath),
            "data" => base64_encode(file_get_contents($filePath)),
            "filename" => basename($filePath),
        ];

    }

    private function saveLog($status, $request, $response, $message, $target): void
    {
        $this->db->table('logging')
            ->set("category", "WHATSAPP_GATEWAY_SERVICE")
            ->set("send_to", $target)
            ->set("status", $status)
            ->set("request", json_encode($request))
            ->set("response", $response)
            ->set("message", $message)
            ->insert();
    }

    public function sendMedia($filePath, $target, $message)
    {
        try {
            $response = $this->client->post('/api/sendmedia', [
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => fopen($filePath, 'r'),
                        'filename' => basename($filePath),
                        'headers' => [
                            'Content-Type' => '<Content-type header>'
                        ]
                    ],
                    [
                        'name' => 'sessions',
                        'contents' => env('WHATSAPP_GATEWAY_SESSION'),
                    ],
                    [
                        'name' => 'target',
                        'contents' => $target,
                    ],
                    [
                        'name' => 'message',
                        'contents' => $message,
                    ],
                ],
                'headers' => [
                    'Cookie' => 'connect.sid:"s%3Al-tJThhm9lxFfmT1xkXHwK5VK-eXGZxY.FDukE5tvLiXKmBCUlVbdTRAlsI2ZqT%2B0oivBmwLNnak"',
                ],
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return $e->getMessage();
        } catch (GuzzleException $e) {
            return $e->getMessage();
        }
    }
}