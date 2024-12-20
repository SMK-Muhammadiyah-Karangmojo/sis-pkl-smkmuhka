<?php

namespace App\Controllers\Presence;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use Mpdf\Mpdf;

class PresenceController extends BaseController
{

    public function index(): string|RedirectResponse
    {
        $data = [
            'title' => "Presensi Siswa",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'data' => $this->presenceModel->findAllByDeletedAtNull()
        ];
        return $this->responseBuilder->ReturnViewValidation(
            $this->session,
            'pages/presence/index',
            $data
        );
    }

    public function detail($id): string|RedirectResponse
    {
        $response = $this->users->findTeacherDetailByEmail(
            $this->session->get('email'))->getRow();
        $data = [
            'title' => "Presensi Siswa",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'data' => $response,
            'data_presence' => $this->presenceModel->findByIdAndDeletedAtIsNull($id)
        ];
        return $this->responseBuilder->ReturnViewValidation(
            $this->session,
            'pages/presence/detail',
            $data
        );
    }

    public function presenceDetailSiswa($userId): string|RedirectResponse
    {
        $response = $this->users->findTeacherDetailByEmail(
            $this->session->get('email'))->getRow();
        $data = [
            'title' => "Presensi Siswa",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'data' => $response,
            'user_id' => $userId,
            'data_presence' => $this->presenceModel->findAllByUserIdAndDeletedAtIsNull($userId)
        ];
        return $this->responseBuilder->ReturnViewValidation(
            $this->session,
            'pages/presence/detail-siswa',
            $data
        );
    }

    public function printPresenceStudent($userId): void
    {
        $response = $this->users->findTeacherDetailByEmail(
            $this->session->get('email'))->getRow();
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
        $this->response->setHeader('Content-Type', $this->applicationConstant->contentType('pdf'));
        $mpdf->Output('ID Card.pdf', 'I');

    }
}