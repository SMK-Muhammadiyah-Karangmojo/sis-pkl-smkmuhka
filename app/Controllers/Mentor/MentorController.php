<?php

namespace App\Controllers\Mentor;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;

class MentorController extends BaseController
{

    public function index(): string|RedirectResponse
    {
        $majorId = $this->request->getVar('jurusan');
        $jurusan = $this->major->findAll();
        $iduka = $this->mentorDetailModel->findAllByMajorId($majorId);
        $data = [
            'title' => "Pembimbing PKL",
            'subtitle' => "Data Pembimbing PKL",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'iduka' => $iduka,
            'jurusan' => $jurusan
        ];
        return $this->responseBuilder->ReturnViewValidation(
            $this->session,
            'pages/admin/mentor/mentor',
            $data
        );
    }
}