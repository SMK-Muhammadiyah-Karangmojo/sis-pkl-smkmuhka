<?php
/**
 * @Author : yantodev
 * mailto: ekocahyanto007@gmail.com
 * link : http://yantodev.github.io/
 */

namespace Config;

use CodeIgniter\Config\BaseConfig;

class YantoDevConfig extends BaseConfig
{
    public $name = 'YantoDev';
    public $baseURL = 'http://localhost/yantodev/';

    public function getdata()
    {
        return $this->name;
    }

    public function ApiResponseBuilder($result): array
    {
        return [
            'code' => $result ? 200 : 404,
            'message' => $result ? 'success' : 'error',
            'result' => $result ?: null
        ];
    }

    public function baseUrl($url): array
    {
        return [
            'url' => $url
        ];
    }

    public function formValidationUserDetail(): array
    {
        return [
            'nis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!!!',
                ]
            ],
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!!!'
                ]
            ],
            'nisn' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!!!'
                ]
            ],
            'profile' => [
                'rules' => 'max_size[profile,10240]|is_image[profile]',
                'errors' => [
                    'max_size' => 'Ukuran foto terlalu besar!!!',
                    'is_image' => 'Yang dipilih bukan image!!!'
                ]
            ],
        ];
    }

    public function formValidationVerifikasiDataPKL(): array
    {
        return [
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!!!',
                ]
            ],
            'image' => [
                'rules' => 'max_size[image,10240]|is_image[image]',
                'errors' => [
                    'max_size' => 'Ukuran foto terlalu besar!!!',
                    'is_image' => 'Yang dipilih bukan image!!!'
                ]
            ]
        ];
    }

    public function formValidationAddMentor(): array
    {
        return [
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!!!',
                ]
            ],
            'email' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi!!!',
                ]
            ]
        ];
    }
}