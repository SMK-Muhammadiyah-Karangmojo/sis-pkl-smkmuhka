<?php

namespace App\Libraries;

class MinioConfig
{
    public string|array|false $minioUrl;
    public string|array|false $port;
    public string|array|false $accessKey;
    public string|array|false $secretKey;
    public bool $secure;
    public string|array|false $region;

    public function __construct()
    {
        $this->minioUrl = getenv('MINIO_URL');
        $this->port = getenv('MINIO_PORT');
        $this->accessKey = getenv('MINIO_ACCESS_KEY');
        $this->secretKey = getenv('MINIO_SECRET_KEY');
        $this->secure = getenv('MINIO_SECURE') === 'true';
        $this->region = getenv('MINIO_REGION');
    }
}