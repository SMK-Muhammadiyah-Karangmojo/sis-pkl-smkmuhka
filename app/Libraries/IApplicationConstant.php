<?php

namespace App\Libraries;

use CodeIgniter\Database\Config;

class IApplicationConstant extends Config
{
    public string $auth = "/";
    public string $authError = "/error";

    public string $limitPdf = "50000000";

    public function contentType($data): string
    {
        return match ($data) {
            "pdf" => "application/pdf",
            "json" => "application/json",
            default => "",
        };
    }
}