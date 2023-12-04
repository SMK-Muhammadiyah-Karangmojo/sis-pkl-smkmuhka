<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class BaseResponse extends BaseConfig
{
    public function ResponseMajorDto($data): array
    {
        foreach ($data as $d) {
            $data = [
                'id' => $d['id'],
                'name' => $d['name'],
                'code' => $d['code']
            ];
            $result[] = $data;
        }
        return $result;
    }

    public function ResponseDetailMajor($data): array
    {
        return [
            'id' => $data['id'],
            'name' => $data['name'],
            'code' => $data['code']
        ];
    }

}