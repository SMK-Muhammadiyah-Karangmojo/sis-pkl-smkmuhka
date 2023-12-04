<?php
/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.github.io/
 */

namespace App\Controllers;

use App\Models\ClassModel;
use App\Models\DataLaporanSiswaModal;
use App\Models\MajorModel;
use App\Models\MasterDataModel;
use App\Models\MasterLaporanModal;
use App\Models\UserDetailModel;
use App\Models\UsersModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Session\Session;
use Config\APIResponseBuilder;
use Config\Services;
use Config\YantoDevConfig;

/**
 * @property Session|mixed|null $session
 * @property ClassModel $class
 * @property UserDetailModel $userDetail
 * @property APIResponseBuilder $ResponseBuilder
 * @property MasterLaporanModal $masterLaporan
 * @property DataLaporanSiswaModal $laporanSiswa
 */
class Student extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->session = session();
        $this->config = new YantoDevConfig();
        $this->ResponseBuilder = new APIResponseBuilder();
        $this->usersModel = new UsersModel();
        $this->major = new MajorModel();
        $this->class = new ClassModel();
        $this->userDetail = new UserDetailModel();
        $this->masterData = new MasterDataModel();
        $this->masterLaporan = new MasterLaporanModal();
        $this->laporanSiswa = new DataLaporanSiswaModal();
    }

    public function index()
    {
        $response = $this->users->findUserDetailByEmail(
            $this->session->get('email'))->getRow();
//        dd($response);
        $res = $this->masterData->findByNis($response != null ? $response->nis : null)->getRow();
        if ($response && $res) {
            return $this->ResponseBuilder->ReturnViewValidationStudent(
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
                    'dataIduka' => $this->masterData->findByUserPublicId($response->id),
                    'major' => $this->major->findAll(),
                    'tp' => $this->tp->findAll(),
                    'class' => $this->class->getWhere(['is_active' => 1])->getResult(),
                    'iduka' => $this->idukaModel->findAllByMajorId($response->major_id),
                ]
            );
        }

        return $this->ResponseBuilder->ReturnViewValidationStudent(
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
                'class' => $this->class->getWhere(['is_active' => 1])->getResult(),
                'data' => $response,
                'master' => $res,
                'iduka' => $this->idukaModel->findAllByMajorId($response ? $response->major_id : null),
            ]
        );
    }

    function addDetail(): \CodeIgniter\HTTP\RedirectResponse
    {
        if (!$this->validate([
            'nis' => [
                'rules' => 'required|is_unique[user_details.user_id]',
                'errors' => [
                    'required' => '{field} harus diisi!!!',
                    'is_unique' => '{field} sudah ada! Silahkan gunakan NIS lainnya'
                ]
            ],
            'user_public_id' => [
                'rules' => 'required|is_unique[user_details.user_public_id]',
                'errors' => [
                    'required' => '{field} harus diisi!!!',
                    'is_unique' => 'user sudah ada! Silahkan hubungi admin anda!!!'
                ]
            ]
        ])) {
            return redirect()->to('/student')->withInput();
        }
        $data = [
            'user_id' => $this->request->getVar('nis'),
            'user_public_id' => $this->request->getVar('user_public_id'),
            'nisn' => $this->request->getVar('nisn'),
            'name' => $this->request->getVar('name'),
            'jk' => $this->request->getVar('jk'),
            'tp_id' => $this->request->getVar('tp'),
            'major_id' => $this->request->getVar('major_id'),
            'class_id' => $this->request->getVar('class_id')
        ];
        try {
            $this->userDetail->insert($data);
        } catch (\ReflectionException $e) {
            $this->session->setFlashdata('eror', $e);
        }
        $this->session->setFlashdata('success', 'Data is updated!!!');
        return redirect()->to('/student');
    }

    function addMasterData(): \CodeIgniter\HTTP\RedirectResponse
    {
        if (!$this->validate([
            'nis' => [
                'rules' => 'required|is_unique[master_data.nis]',
                'errors' => [
                    'required' => '{field} harus diisi!!!',
                    'is_unique' => '{field} sudah memilih lokasi PKL!!!'
                ]
            ]
        ])) {
            return redirect()->to('/student')->withInput();
        }
        $data = [
            'user_public_id' => $this->request->getVar('user_public_id'),
            'nis' => $this->request->getVar('nis'),
            'tp_id' => $this->request->getVar('tp_id'),
            'iduka_id' => $this->request->getVar('iduka_id'),
        ];
        try {
            $this->masterData->insert($data);
        } catch (\ReflectionException $e) {
            $this->session->setFlashdata('error', $e);
        }
        $this->session->setFlashdata('success', 'Data is updated!!!');
        return redirect()->to('/student');
    }

    public function profile()
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
            'class' => $this->class->getWhere(['is_active' => 1])->getResult(),
            'master' => $res,
            'iduka' => $this->idukaModel->findAllByMajorId($response ? $response->major_id : null),
            'dataIduka' => $this->idukaModel->findById($res ? $res->iduka_id : null)
        ];
        if ($response && $res) {
            return $this->ResponseBuilder->ReturnViewValidationStudent(
                $this->session,
                'pages/student/profile',
                $data
            );
        }
        return $this->ResponseBuilder->ReturnViewValidationStudent(
            $this->session,
            'pages/student/validation',
            $data
        );
    }

    /**
     * @throws \ReflectionException
     */
    public function updateProfile(): \CodeIgniter\HTTP\RedirectResponse
    {
        helper(['form']);
        if (!$this->validate($this->config->formValidationUserDetail())) {
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

    public function iduka()
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
        return $this->ResponseBuilder->ReturnViewValidationStudent(
            $this->session,
            'pages/student/iduka',
            $data
        );
    }

    public function verifikasi()
    {
        $response = $this->users->findUserDetailByEmail(
            $this->session->get('email'))->getRow();
        $id = $this->request->getVar('id');
        $data = [
            'title' => "Verifikasi Data",
            'users' => $this->session->get('email'),
            'users_id' => $this->session->get('id'),
            'role' => $this->session->get('role'),
            'validation' => Services::validation(),
            'data' => $response,
            'master' => $this->masterData->findById($id),
            'statusData' => $this->request->getVar('statusData')
        ];
        return $this->ResponseBuilder->ReturnViewValidationStudent(
            $this->session,
            'pages/admin/verifikasi-data-pkl',
            $data
        );
    }

    /**
     * @throws \ReflectionException
     */
    public function laporan()
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
            return redirect()->to('student/laporan');
        }
        return $this->ResponseBuilder->ReturnViewValidationStudent(
            $this->session,
            'pages/student/laporan',
            $data
        );
    }

    public function findSubLaporan(): \CodeIgniter\HTTP\Response
    {
        $id = $this->request->getVar('id');
        $result = $this->masterLaporan->findSubLaporanByMasterId($id);
        return $this->respond(
            $this->ResponseBuilder->ok($result)
        );
    }

    public function findSubLaporan1(): \CodeIgniter\HTTP\Response
    {
        $id = $this->request->getVar('id');
        $result = $this->masterLaporan->findSubLaporan1BySubLaporanId($id);
        return $this->respond(
            $this->ResponseBuilder->ok($result)
        );
    }

    public function deleteReport(): \CodeIgniter\HTTP\Response
    {
        return $this->respond($this->ResponseBuilder->ok(
            $this->laporanSiswa->delete(
                $this->request->getVar('id')
            )
        ));
    }
}