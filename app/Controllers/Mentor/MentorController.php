<?php

namespace App\Controllers\Mentor;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;

class MentorController extends BaseController
{

    use ResponseTrait;
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

    public function addMentor(): ResponseInterface
    {
        helper(['form']);
        if (!$this->session->get('logged_in')) {
            return redirect()->to($this->applicationConstant->auth);
        }
        if ($this->validate($this->formValidation->formValidationAddMentor())) {
            $data = [
                'iduka_id' => $this->request->getVar('idukaId'),
                'tp_id' => $this->request->getVar('tpId'),
                'name' => $this->request->getVar('name'),
                'position' => $this->request->getVar('position'),
                'identity_number' => $this->request->getVar('identityNumber'),
                'hp' => $this->request->getVar('hp'),
                'email' => $this->request->getVar('email')
            ];
            $result = $this->mentorDetailModel->insert($data);
            if ($result) {
                $response = $this->responseBuilder->ok(true);
            } else {
                $response = $this->responseBuilder->internalServerError("Gagal simpan data");
            }
        }
        return $this->respond($response);
    }

    public function editMentor($id): ResponseInterface|RedirectResponse
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to($this->applicationConstant->auth);
        }
        if ($id) {
            $result = $this->mentorDetailModel->find($id);
            if ($result) {
                $response = $this->responseBuilder->ok($result);
            } else {
                $response = $this->responseBuilder->internalServerError("data with id " . $id . " not found");
            }
        } else {
            $ids = $this->request->getVar('id');
            $data = [
                'name' => $this->request->getVar('name'),
                'position' => $this->request->getVar('position'),
                'identity_number' => $this->request->getVar('identityNumber'),
                'hp' => $this->request->getVar('hp'),
                'email' => $this->request->getVar('email')
            ];
            $saveData = $this->mentorDetailModel->update($ids, $data);
            $response = $this->responseBuilder->ok($saveData);
        }
        return $this->respond($response);
    }
}