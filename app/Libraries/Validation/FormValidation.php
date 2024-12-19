<?php

namespace App\Libraries\Validation;

class FormValidation
{
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
}