<?php

namespace Config;

use CodeIgniter\Database\Config;

class IApplicationConstantConfig extends Config
{
    public string $auth = "/auth";
    public string $authError = "/auth/error";

    public function contentType($data): string
    {
        switch ($data) {
            case "pdf":
                return "application/pdf";
            case "json":
                return "application/json";
            default:
                return "";
        }
    }
}