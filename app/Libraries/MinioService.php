<?php

namespace App\Libraries;

use Aws\S3\S3Client;
use CodeIgniter\Database\BaseConnection;
use Exception;
use function PHPUnit\Framework\isJson;

/**
 * @property BaseConnection $db
 */
class MinioService
{
    protected S3Client $s3Client;
    protected MinioConfig $config;
    private BaseConnection $db;

    public function __construct()
    {
        $this->config = new MinioConfig();
        $this->db = db_connect();

        $this->s3Client = new S3Client([
            'version' => 'latest',
            'region' => $this->config->region,
            'endpoint' => $this->config->minioUrl . ':' . $this->config->port,
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key' => $this->config->accessKey,
                'secret' => $this->config->secretKey,
            ],
            'http' => [
                'verify' => $this->config->secure,
            ],
        ]);
    }

    /**
     * Upload file ke Minio
     *
     * @param string $filePath
     * @param string $fileName
     * @param string $folderName
     * @return array
     */
    public function uploadFile(string $filePath, string $fileName, string $folderName): array
    {
        $fileKey = $folderName . '/' . $fileName;
        $mimeType = mime_content_type($filePath);

        $request = [
            'Bucket' => $_ENV['MINIO_BUCKET'],
            'Key' => $fileKey,
            'SourceFile' => $filePath,
            'ContentType' => $mimeType,
            'ACL' => 'public-read',
        ];

        try {
            $result = $this->s3Client->putObject($request);

            $response = [
                'etag' => $result['ETag'],
                'bucket' => $_ENV['MINIO_BUCKET'],
                'region' => $this->config->region,
                'file' => $fileKey,
                'url' => $result['ObjectURL'],
            ];
            $this->saveLog("SUCCESS", $request, $response, "send to minio server success!!!");
            return $response;
        } catch (Exception $e) {
            $this->saveLog("FAILED", $request, $e, $e->getMessage());
            throw new \RuntimeException('Upload ke Minio gagal: ' . $e->getMessage());
        }
    }

    private function saveLog($status, $request, $response, $message): void
    {
        $this->db->table('logging')
            ->set("category", "MINIO_SERVER")
            ->set("send_to", "MINIO")
            ->set("status", $status)
            ->set("request", json_encode($request))
            ->set("response", isJson($response) ? json_encode($response) : $response)
            ->set("message", $message)
            ->insert();
    }
}