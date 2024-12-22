<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;
use Mpdf\Mpdf;

class TeacherController extends BaseController
{

    public function index(): string|RedirectResponse
    {
        $response = $this->users->findTeacherDetailByEmail(
            $this->session->get('email'))->getRow();
        $tutor = $response ? $this->tutorModel->findByTeacherId($response->id) : null;

        $data = [
            'title' => "Dashboard",
            'validation' => Services::validation(),
            'users' => $this->session->get('email'),
            'users_id' => $this->session->get('id'),
            'role' => $this->session->get('role'),
            'data' => $response,
            'tutor' => $tutor
        ];
        if ($response) {
            return $this->responseBuilder->ReturnViewValidationTeacher(
                $this->session,
                'pages/teacher/dashboard',
                $data
            );
        }
        return $this->responseBuilder->ReturnViewValidationTeacher(
            $this->session,
            'pages/teacher/validation',
            $data
        );
    }

    public function report(): string|RedirectResponse
    {
        $response = $this->users->findTeacherDetailByEmail(
            $this->session->get('email'))->getRow();
        $tpId = $this->request->getVar("tp");
        $data = [
            'title' => "Laporan Siswa",
            'validation' => Services::validation(),
            'users' => $this->session->get('email'),
            'users_id' => $this->session->get('id'),
            'role' => $this->session->get('role'),
            'data' => $response,
            'tp' => $this->tp->findAll(),
            'laporan' => $this->laporanSiswa->findStudentReport($response->id, $tpId)
        ];

        return $this->responseBuilder->ReturnViewValidationTeacher(
            $this->session,
            'pages/teacher/laporan',
            $data
        );
    }

    public function printReport($id): void
    {
        $userDetail = $this->userDetail->findByUserPublicId($id);
        $data = [
            'userDetail' => $userDetail,
            'laporan' => $this->laporanSiswa->findByUserPublicId($id)
        ];
        view('pages/general/cetak-laporan-siswa', $data);
        $mpdf = new Mpdf();
        $mpdf->showImageErrors = true;
        $html = view('pages/general/cetak-laporan-siswa');
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', $this->applicationConstant->contentType('pdf'));
        $mpdf->Output("Laporan Siswa $userDetail->name.pdf", 'I');
    }

    public function presence(): string|RedirectResponse
    {
        $tpId = $this->request->getVar("tp");

        $response = $this->users->findTeacherDetailByEmail(
            $this->session->get('email'))->getRow();
        $data = [
            'title' => "Presensi Siswa",
            'validation' => Services::validation(),
            'users' => $this->session->get('email'),
            'users_id' => $this->session->get('id'),
            'role' => $this->session->get('role'),
            'data' => $response,
            'tp' => $this->tp->findAll(),
            'laporan' => $response ? $this->laporanSiswa->findStudentReport($response->id, $tpId) : null,
        ];

        return $this->responseBuilder->ReturnViewValidationTeacher(
            $this->session,
            'pages/teacher/presence',
            $data
        );
    }

    public function print(): string|RedirectResponse
    {
        $response = $this->users->findTeacherDetailByEmail(
            $this->session->get('email'))->getRow();
        $data = [
            'title' => "Menu Cetak",
            'users' => $this->session->get('email'),
            'users_id' => $this->session->get('id'),
            'role' => $this->session->get('role'),
            'data' => $response,
            'tp' => $this->tp->findAll(),
        ];

        return $this->responseBuilder->ReturnViewValidationTeacher(
            $this->session,
            'pages/teacher/menu-print',
            $data
        );
    }

    public function monitoring($id): void
    {
        $tp = $this->tp->get()->getLastRow();
        $teacher = $this->tutorModel->findByTeacherId($id);
        $data = [
            'iduka' => $teacher,
            'tp' => $tp->id,
            'dataTp' => $this->tp->find($tp->id),
        ];
        view('pages/teacher/cetak-lembar-monitoring', $data);
        $mpdf = new Mpdf();
        $mpdf->showImageErrors = true;
        $html = view('pages/teacher/cetak-lembar-monitoring', [
            ini_set("pcre.backtrack_limit", "5000000")
        ]);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', $this->applicationConstant->contentType('pdf'));
        $mpdf->Output('ID Card.pdf', 'I');
    }

    public function suratTugas($teacherId){
        {
            $tp = 7;
            $result = $this->teacherModel->findAllByUserPublicId($teacherId, $tp);
            $data = [
                'results' => $result,
                'surat' => $this->nomorSuratModel->findByTpAndCategory($tp, 2),
                'tp' => $tp,
                'school' => $this->schoolModel->find(1),
                'kop_surat' => $this->masterTemplateModel->findByCode("KOP_SURAT"),
            ];
            view('pages/general/cetak-surat-tugas', $data);
            $mpdf = new Mpdf();
            $mpdf->showImageErrors = true;
            $html = view('pages/general/cetak-surat-tugas', []);
            $mpdf->WriteHTML($html);
            $this->response->setHeader('Content-Type', $this->applicationConstant->contentType('pdf'));
            $mpdf->Output('Surat Tugas ' . $result[0]->name . '. pdf', 'I');
        }
    }
}