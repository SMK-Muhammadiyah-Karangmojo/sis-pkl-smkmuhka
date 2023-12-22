<?php
/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.my.id/
 */

namespace App\Controllers\Presence;

use App\Controllers\BaseController;
use Config\APIResponseBuilder;

class PresenceController extends BaseController
{
    protected APIResponseBuilder $ResponseBuilder;
    /**
     * @var \CodeIgniter\Session\Session|mixed|null
     */
    protected mixed $session;

    public function __construct()
    {
        $this->session = session();
        $this->ResponseBuilder = new APIResponseBuilder();
    }

    public function index()
    {
        $data = [
            'title' => "Presensi Siswa",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'data' => $this->presenceModel->findAllByDeletedAtNull()
        ];
        return $this->ResponseBuilder->ReturnViewValidation(
            $this->session,
            'pages/presence/index',
            $data
        );

    }
    public function presenceDetail($id)
    {
        $data = [
            'title' => "Presensi Siswa",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'data' => $this->presenceModel->findByIdAndDeletedAtIsNull($id)
        ];
        return $this->ResponseBuilder->ReturnViewValidation(
            $this->session,
            'pages/presence/detail',
            $data
        );

    }

}