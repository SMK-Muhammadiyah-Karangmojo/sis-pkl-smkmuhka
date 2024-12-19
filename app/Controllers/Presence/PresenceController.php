<?php

namespace App\Controllers\Presence;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;

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
        $response = $this->session ? $this->users->findTeacherDetailByEmail(
            $this->session->get('email'))->getRow() : null;
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
}