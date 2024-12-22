<?php

namespace App\Controllers\Api;

use App\Libraries\ResponseBuilder;
use App\Models\MentorDetailModel;
use App\Models\TeacherModel;
use App\Models\TutorModel;
use App\Models\UserDetailModel;
use App\Models\UsersModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Exception;

class TeacherEndpoint extends ResourceController
{
    use ResponseTrait;

    protected ResponseBuilder $responseBuilder;
    protected UsersModel $usersModel;
    protected MentorDetailModel $mentorDetailModel;
    protected UserDetailModel $userDetail;
    protected TeacherModel $teacherModel;
    protected TutorModel $tutorModel;

    public function __construct()
    {
        $this->responseBuilder = new ResponseBuilder();
        $this->usersModel = new UsersModel();
        $this->userDetail = new UserDetailModel();
        $this->teacherModel = new TeacherModel();
        $this->mentorDetailModel = new MentorDetailModel();
        $this->tutorModel = new TutorModel();
    }

    public function create()
    {
        $email = $this->request->getVar('email');
        $requestUser = [
            'email' => $email,
            'password' => password_hash('12345678', PASSWORD_DEFAULT),
            'image' => "default.png",
            'role_pkl' => 2,
            'is_active' => 1
        ];

        $user = $this->usersModel->insert($requestUser);

        if ($user) {
            $userId = $this->usersModel->findUserByEmail($email);
            $this->userDetail->insert([
                'user_public_id' => $userId->id,
                'user_id' => $this->request->getVar('nbm'),
                'name' => $this->request->getVar('name'),
            ]);
            $data = [
                "user_public_id" => $userId->id,
                'name' => $this->request->getVar('name'),
                'position' => $this->request->getVar('position'),
                'nbm' => $this->request->getVar('nbm'),
                'hp' => $this->request->getVar('hp'),
                'email' => $email
            ];
            $result = $this->teacherModel->insert($data);
        } else {
            $result = false;
        }
        if ($result) {
            $response = $this->responseBuilder->ok($userId);
        } else {
            $response = $this->responseBuilder->internalServerError("Gagal simpan data");
        }
        return $this->respond($response);
    }

    public function show($id = null)
    {
        try {
            $result = $this->usersModel->findTeacherById($id);
            $response = $this->responseBuilder->ok($result);
        } catch (Exception $e) {
            $response = $this->responseBuilder->internalServerError($e->getMessage());
        }
        return $this->respond($response);
    }

    public function update($id = null)
    {
        $request = [
            'nbm' => $this->request->getVar('nbm'),
            'name' => $this->request->getVar('name'),
            'position' => $this->request->getVar('position'),
            'hp' => $this->request->getVar('hp')
        ];
        try {
            $result = $this->userDetail->updateTeacher($id, $request);
            $response = $this->responseBuilder->ok($result);
        } catch (Exception $e) {
            $response = $this->responseBuilder->internalServerError("update teacher with id " . $id . " failed");
        }
        return $this->respond($response);
    }

    public function findTeacherByTp(): ResponseInterface
    {
        $tp = $this->request->getVar('tp');
        try {
            $result = $this->tutorModel->findByTp($tp);
            $response = $this->responseBuilder->ok($result);
        } catch (\Exception $e) {
            $response = $this->responseBuilder->internalServerError($e->getMessage());
        }
        return $this->respond($response);
    }
}