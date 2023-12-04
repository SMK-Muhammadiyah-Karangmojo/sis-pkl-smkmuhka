<?php
/**
 * Copyright (c) yantodev all right reserved
 * The Mentor Controller
 * @Author Eko Cahyanto
 * mail to : ekocahyanto007@gmail.com
 */

namespace App\Controllers\Mentor;

use App\Controllers\BaseController;
use App\Models\IdukaModel;
use App\Models\MajorModel;
use App\Models\MentorDetailModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Session\Session;
use Config\APIResponseBuilder;
use Config\IApplicationConstantConfig;
use Config\YantoDevConfig;
use ReflectionException as ReflectionExceptionAlias;

/**
 * @property Session|mixed|null $session
 * @property APIResponseBuilder $ResponseBuilder
 * @property IApplicationConstantConfig $IApplicationConstant
 * @property MentorDetailModel $mentorDetailModel
 */
class Mentor extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->session = session();
        $this->config = new YantoDevConfig();
        $this->ResponseBuilder = new APIResponseBuilder();
        $this->IApplicationConstant = new IApplicationConstantConfig();
        $this->major = new MajorModel();
        $this->idukaModel = new IdukaModel();
        $this->mentorDetailModel = new MentorDetailModel();
    }

    public function index(): string|\CodeIgniter\HTTP\RedirectResponse
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
        return $this->ResponseBuilder->ReturnViewValidation(
            $this->session,
            'pages/admin/mentor/mentor',
            $data
        );
    }

    /**
     * @throws ReflectionExceptionAlias
     */
    public function addMentor(): \CodeIgniter\HTTP\Response|\CodeIgniter\HTTP\RedirectResponse
    {
        helper(['form']);
        if (!$this->session->get('logged_in')) {
            return redirect()->to($this->IApplicationConstant->auth);
        }
        if ($this->validate($this->config->formValidationAddMentor())) {
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
                $response = $this->ResponseBuilder->ok(true);
            } else {
                $response = $this->ResponseBuilder->internalServerError("Gagal simpan data");
            }
        }
        return $this->respond($response);
    }

    /**
     * @throws ReflectionExceptionAlias
     */
    public function editMentor($id): \CodeIgniter\HTTP\Response
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to($this->IApplicationConstant->auth);
        }
        if ($id) {
            $result = $this->mentorDetailModel->find($id);
            if ($result) {
                $response = $this->ResponseBuilder->ok($result);
            } else {
                $response = $this->ResponseBuilder->internalServerError("data with id " . $id . " not found");
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
            $response = $this->ResponseBuilder->ok($saveData);
        }
        return $this->respond($response);
    }
}