<?php

namespace App\Controllers\Student;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;

class StudentController extends BaseController
{

    public function index(): string|RedirectResponse
    {
        $response = $this->users->findUserDetailByEmail(
            $this->session->get('email'))->getRow();
//        dd($response);
        $res = $this->masterData->findByNis($response != null ? $response->nis : null)->getRow();
        if ($response && $res) {
//            dd($response->id);
//            dd($this->masterData->findByUserPublicId($response->id));
//            dd([
//                'title' => "Dashboard",
//                'validation' => Services::validation(),
//                'users' => $this->session->get('email'),
//                'users_id' => $this->session->get('id'),
//                'role' => $this->session->get('role'),
//                'data' => $response,
//                'master' => $res,
//                'dataIduka' => $this->masterData->findByUserPublicId($response->id) ?? null,
//                'major' => $this->major->findAll(),
//                'tp' => $this->tp->findAll(),
//                'class' => $this->class->findClassActive()->getResult(),
//                'iduka' => $this->idukaModel->findAllByMajorId($response->major_id) ?? [],
//            ]);
            return $this->responseBuilder->ReturnViewValidationStudent(
                $this->session,
                'pages/student/dashboard',
                [
                    'title' => "Dashboard",
                    'validation' => Services::validation(),
                    'users' => $this->session->get('email'),
                    'users_id' => $this->session->get('id'),
                    'role' => $this->session->get('role'),
                    'data' => $response,
                    'master' => $res,
                    'dataIduka' => $this->masterData->findByUserPublicId($response->id) ?? null,
                    'major' => $this->major->findAll(),
                    'tp' => $this->tp->findAll(),
                    'class' => $this->class->findClassActive()->getResult(),
                    'iduka' => $this->idukaModel->findAllByMajorId($response->major_id) ?? [],
                ]
            );
        }
//        dd(false);
        return $this->responseBuilder->ReturnViewValidationStudent(
            $this->session,
            'pages/student/validation',
            [
                'title' => "Dashboard",
                'validation' => Services::validation(),
                'users' => $this->session->get('email'),
                'usersDetail' => $response ? $this->userDetail->findByUserPublicId($response->id) : null,
                'users_id' => $this->session->get('id'),
                'tp' => $this->tp->findAll(),
                'major' => $this->major->findAll(),
                'class' => $this->class->findClassActive()->getResult(),
                'data' => $response,
                'master' => $res,
                'iduka' => $this->idukaModel->findAllByMajorId($response ? $response->major_id : null) ?? [],
            ]
        );
    }

    public function presence(): string|RedirectResponse
    {
        $data = [
            'title' => "Presensi Siswa",
            'users' => $this->session->get('email'),
            'users_id' => $this->session->get('id'),
            'role' => $this->session->get('role'),
            'data' => $this->users->findUserDetailByEmail(
                $this->session->get('email'))->getRow(),
            'cek_presence' => $this->presenceModel->findByUserIdAndDate($this->session->get('id'), today()),
            'data_presence' => $this->presenceModel->findByUserIdAndDeletedAtIsNull($this->session->get('id'))
        ];

        return $this->responseBuilder->ReturnViewValidationStudent(
            $this->session,
            'pages/student/presence',
            $data
        );
    }

    public function profile(): string|RedirectResponse
    {
        $response = $this->users->findUserDetailByEmail(
            $this->session->get('email'))->getRow();
        $res = $this->masterData->findByNis($response ? $response->nis : null)->getRow();
        $data = [
            'title' => "Profile",
            'validation' => Services::validation(),
            'users' => $this->session->get('email'),
            'users_id' => $this->session->get('id'),
            'role' => $this->session->get('role'),
            'data' => $response,
            'major' => $this->major->findAll(),
            'tp' => $this->tp->findAll(),
            'class' => $this->class->findClassActive()->getResult(),
            'master' => $res,
            'iduka' => $this->idukaModel->findAllByMajorId($response ? $response->major_id : null),
            'dataIduka' => $this->idukaModel->findById($res ? $res->iduka_id : null)
        ];
        if ($response && $res) {
            return $this->responseBuilder->ReturnViewValidationStudent(
                $this->session,
                'pages/student/profile',
                $data
            );
        }
        return $this->responseBuilder->ReturnViewValidationStudent(
            $this->session,
            'pages/student/validation',
            $data
        );
    }

    public function updateProfile(): RedirectResponse
    {
        helper(['form']);
        if (!$this->validate($this->formValidation->formValidationUserDetail())) {
            return redirect()->to('/student/profile')->withInput();
        }

        $oldImage = $this->request->getVar('oldImage');
        $fileImage = $this->request->getFile('profile');
        if ($fileImage->getError() == 4) {
            $imageName = $oldImage;
        } else {
            $imageName = $fileImage->getRandomName();
            $fileImage->move('assets/img/users', $imageName);
            if ($oldImage != 'default.png') {
                unlink('assets/img/users/' . $oldImage);
            }
        }


        $major = $this->class->find($this->request->getVar('class_id'));
        if ($major != null) {
            $data = [
                'name' => $this->request->getVar('name'),
                'nis' => $this->request->getVar('nis'),
                'nisn' => $this->request->getVar('nisn'),
                'jk' => $this->request->getVar('jk'),
                'tp' => $this->request->getVar('tp'),
                'class_id' => $this->request->getVar('class_id'),
            ];

            $this->users->update(
                $this->request->getVar('id'),
                [
                    'image' => $imageName
                ]
            );
            $this->userDetail->update($this->request->getVar('ids'), $data);

            $this->session->setFlashdata('success', 'Data is updated!!!');
            return redirect()->to('/student/profile');
        }
        $this->session->setFlashdata('error', 'major is null');
        return redirect()->to('/student/profile');
    }

    public function iduka(): string|RedirectResponse
    {
        $response = $this->users->findUserDetailByEmail(
            $this->session->get('email'))->getRow();
        $res = $this->masterData->findByNis($response ? $response->nis : null)->getRow();
        $data = [
            'title' => "Daftar Iduka",
            'validation' => Services::validation(),
            'users' => $this->session->get('email'),
            'users_id' => $this->session->get('id'),
            'role' => $this->session->get('role'),
            'data' => $response,
            'iduka' => $this->idukaModel->findAllByMajorId($response ? $response->major_id : null),
            'dataIduka' => $this->idukaModel->findById($res ? $res->iduka_id : null)
        ];
        return $this->responseBuilder->ReturnViewValidationStudent(
            $this->session,
            'pages/student/iduka',
            $data
        );
    }

    public function report(): string|RedirectResponse
    {
        $masterLaporan = $this->request->getVar('master_laporan');
        $subLaporan = $this->request->getVar('sub_laporan');
        $subLaporan1 = $this->request->getVar('sub_laporan_1');
        $date = $this->request->getVar('date');
        $other = $this->request->getVar('other');
        $users = $this->users->findUserDetailByEmail(
            $this->session->get('email'))->getRow();
        $data = [
            'title' => "Laporan PKL",
            'users' => $this->session->get('email'),
            'users_id' => $this->session->get('id'),
            'role' => $this->session->get('role'),
            'data' => $users,
            'master_data' => $users ? $this->masterLaporan->findAllByMajorId($users->major_id) : null,
            'laporan' => $users ? $this->laporanSiswa->findByUserPublicId($users->id) : null
        ];
        if ($masterLaporan) {
            $result = $this->laporanSiswa->insert([
                'user_public_id' => $users->id,
                'master_laporan_id' => $masterLaporan,
                'master_sub_laporan_id' => $subLaporan,
                'master_sub_laporan_1_id' => $subLaporan1,
                'major_id' => $users->major_id,
                'other' => $other,
                'date' => $date
            ]);
            if ($result) {
                $this->session->setFlashdata('success', 'tambah laporan berhasil');
            } else {
                $this->session->setFlashdata('error', 'tambah laporan gagal');
            }
            return redirect()->to('student/report');
        }
        return $this->responseBuilder->ReturnViewValidationStudent(
            $this->session,
            'pages/student/laporan',
            $data
        );
    }
}