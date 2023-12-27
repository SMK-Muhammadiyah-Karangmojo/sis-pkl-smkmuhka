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
use Mpdf\Mpdf;

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
        $response = $this->session ? $this->users->findTeacherDetailByEmail(
            $this->session->get('email'))->getRow() : null;
        $data = [
            'title' => "Presensi Siswa",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'data' => $response,
            'data_presence' => $this->presenceModel->findByIdAndDeletedAtIsNull($id)
        ];
        return $this->ResponseBuilder->ReturnViewValidation(
            $this->session,
            'pages/presence/detail',
            $data
        );

    }

    public function presenceDetailSiswa($userId)
    {
        $response = $this->session ? $this->users->findTeacherDetailByEmail(
            $this->session->get('email'))->getRow() : null;
        $data = [
            'title' => "Presensi Siswa",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'data' => $response,
            'user_id' => $userId,
            'data_presence' => $this->presenceModel->findAllByUserIdAndDeletedAtIsNull($userId)
        ];
        return $this->ResponseBuilder->ReturnViewValidation(
            $this->session,
            'pages/presence/detail-siswa',
            $data
        );

    }

    public function printPresenceStudent($userId)
    {
        $response = $this->session ? $this->users->findTeacherDetailByEmail(
            $this->session->get('email'))->getRow() : null;
        $data = [
            'title' => "Presensi Siswa",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'data' => $response,
            'user_id' => $userId,
            'user_detail' => $this->userDetail->findByUserPublicId($userId),
            'kop_surat' => $this->masterTemplateModel->findByCode("KOP_SURAT"),
            'data_presence' => $this->presenceModel->findAllByUserIdAndDeletedAtIsNull($userId)
        ];

        view('pages/general/cetak-presence-student', $data);
        $mpdf = new Mpdf();
        $mpdf->showImageErrors = true;
        $html = view('pages/general/cetak-presence-student', [
            ini_set("pcre.backtrack_limit", "5000000")
        ]);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', $this->IApplicationConstant->contentType('pdf'));
        $mpdf->Output('ID Card.pdf', 'I');

    }

}