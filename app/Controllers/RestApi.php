<?php

/**
 * The Admin Controller
 * @author  Eko Cahyanto
 * mail to: ekocahyanto007@gmail.com
 */

namespace App\Controllers;

use App\Models\ClassModel;
use App\Models\IdukaModel;
use App\Models\KategoriSuratModel;
use App\Models\MajorModel;
use App\Models\MasterDataModel;
use App\Models\TutorModel;
use App\Models\UserDetailModel;
use App\Models\UsersModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use Config\APIResponseBuilder;
use Config\BaseResponse;
use Config\YantoDevConfig;
use ReflectionException;

/**
 * @property YantoDevConfig $config
 * @property MajorModel $major
 * @property IdukaModel $iduka
 * @property string $ok
 * @property string $error
 * @property UsersModel $user
 * @property TutorModel $tutor
 * @property UserDetailModel $userDetail
 * @property ClassModel $class
 * @property MasterDataModel $masterData
 * @property APIResponseBuilder $ResponseBuilder
 * @property BaseResponse $BaseResponse
 */
class RestApi extends ResourceController
{
    use ResponseTrait;

    private KategoriSuratModel $categoryModel;

    public function __construct()
    {
        $this->ResponseBuilder = new APIResponseBuilder();
        $this->BaseResponse = new BaseResponse();
        $this->config = new YantoDevConfig();
        $this->user = new UsersModel();
        $this->userDetail = new UserDetailModel();
        $this->major = new MajorModel();
        $this->iduka = new IdukaModel();
        $this->tutor = new TutorModel();
        $this->class = new ClassModel();
        $this->masterData = new MasterDataModel();
        $this->categoryModel = new KategoriSuratModel();
    }

    public function countData(): \CodeIgniter\HTTP\Response
    {
        $data = [
            'users' => $this->user->countAll(),
            'users_completed' => $this->userDetail->countCompleted(),
            'iduka' => $this->iduka->countAll(),
        ];
        $response = $this->ResponseBuilder->ok($data);
        return $this->respond($response);
    }

    public function findAllMajor(): \CodeIgniter\HTTP\Response
    {
        $data = $this->major->findAll();
        if (!is_null($data)) {
            $response = $this->BaseResponse->ResponseMajorDto($data);
            $result = $this->ResponseBuilder->ok($response);
        } else {
            $result = $this->ResponseBuilder->noContent('data not found');
        }
        return $this->respond($result);
    }

    public function detailMajor(): \CodeIgniter\HTTP\Response
    {
        $id = $this->request->getVar('id');
        $responseDetailMajor = $this->major->find($id);
        try {
            if (is_null($responseDetailMajor)) {
                $response = $this->ResponseBuilder->noContent('data with id ' . $id . ' not found');
            }
            $response = $this->ResponseBuilder->ok(
                $this->BaseResponse->ResponseDetailMajor($responseDetailMajor)
            );
        } catch (\Exception $e) {
            $response = $this->ResponseBuilder->internalServerError($e->getMessage());
        }
        return $this->respond($response);
    }

    public function getUserByEmail(): \CodeIgniter\HTTP\Response
    {
        $email = $this->request->getVar('email');
        $result = $this->user->getWhere(['email' => $email])->getRow();
        $data = [
            'id' => $result->id,
            'name' => $result->name,
            'email' => $result->email,
        ];
        try {
            if (is_null($result)) {
                $response = $this->ResponseBuilder->noContent('data with email ' . $email . ' not found');
            }
            $response = $this->ResponseBuilder->ok($data);
        } catch (\Exception $e) {
            $response = $this->ResponseBuilder->internalServerError($e->getMessage());
        }
        return $this->respond($response);
    }

    /**
     * @throws ReflectionException
     */
    public function addPendamping(): \CodeIgniter\HTTP\Response
    {
        $data = [
            'tp_id' => $this->request->getVar('tp'),
            'major_id' => $this->request->getVar('major'),
            'iduka_id' => $this->request->getVar('iduka'),
            'teacher_id' => $this->request->getVar('teacher')
        ];
        return $this->respond(
            $this->config->ApiResponseBuilder(
                $this->tutor->insert($data)
            )
        );
    }

    /**
     * @throws ReflectionException
     */
    public function updateTutor(): \CodeIgniter\HTTP\Response
    {
        $data = [
            'tp_id' => $this->request->getVar('tp'),
            'major_id' => $this->request->getVar('major'),
            'iduka_id' => $this->request->getVar('iduka'),
            'teacher_id' => $this->request->getVar('userId')
        ];
        return $this->respond(
            $this->config->ApiResponseBuilder(
                $this->tutor->update($this->request->getVar('id'), $data)
            )
        );
    }

    public function deleteTutor(): \CodeIgniter\HTTP\Response
    {
        return $this->respond(
            $this->config->ApiResponseBuilder(
                $this->tutor->delete($this->request->getVar('id'))
            )
        );
    }

    public function findTutorById(): \CodeIgniter\HTTP\Response
    {
        return $this->respond(
            $this->config->ApiResponseBuilder(
                $this->tutor->findById($this->request->getVar('id'))
            )
        );
    }

    public function findStudentById(): \CodeIgniter\HTTP\Response
    {
        $id = $this->request->getVar('id');
        try {
            $result = $this->userDetail->findById($id);
            $response = $this->ResponseBuilder->ok($result);
        } catch (\Exception $e) {
            $response = $this->ResponseBuilder->noContent("student with id " . $id . " not found");
        }
        return $this->respond($response);
    }

    public function findAllClassByMajor(): \CodeIgniter\HTTP\Response
    {
        return $this->respond(
            $this->config->ApiResponseBuilder(
                $this->class->findAllBy($this->request->getVar('major'))
            )
        );
    }

    /**
     * @throws ReflectionException
     */
    public function updateMasterDataStudent(): \CodeIgniter\HTTP\Response
    {

        $id = $this->request->getVar('id');
        $data = [
            'nis' => $this->request->getVar('nis'),
            'iduka_id' => $this->request->getVar('iduka'),
            'tp_id' => $this->request->getVar('tp')
        ];
        try {
            if (!$id) {
                $response = $this->ResponseBuilder->ok($this->masterData->save($data));
            } else {
                $response = $this->ResponseBuilder->ok($this->masterData->update($id,
                    ['iduka_id' => $this->request->getVar('iduka')]));
            }
        } catch (\Exception $e) {
            $response = $this->ResponseBuilder->internalServerError($e->getMessage());
        }

        return $this->respond($response);
    }

    public function findMajorByClass(): \CodeIgniter\HTTP\Response
    {
        return $this->respond(
            $this->config->ApiResponseBuilder(
                $this->class->find(
                    $this->request->getVar('id')
                )
            )
        );
    }

    /**
     * @throws ReflectionException
     */
    public function updateUserDetails(): \CodeIgniter\HTTP\Response
    {
        $id = $this->request->getVar('id');
        $data = [
            'name' => $this->request->getVar('name'),
            'class_id' => $this->request->getVar('classId'),
            'major_id' => $this->request->getVar('major'),
            'tp' => $this->request->getVar('tp'),
            'nisn' => $this->request->getVar('nisn'),
            'jk' => $this->request->getVar('jk')
        ];
        try {
            $result = $this->userDetail->update($id, $data);
            $response = $this->ResponseBuilder->ok($result);
        } catch (\Exception $e) {
            $response = $this->ResponseBuilder->internalServerError($e->getMessage());
        }
        return $this->respond($response);
    }

    public function findTeacherById(): \CodeIgniter\HTTP\Response
    {
        $id = $this->request->getVar('id');
        try {
            $result = $this->user->findTeacherById($id);
            $response = $this->ResponseBuilder->ok($result);
        } catch (\Exception $e) {
            $response = $this->ResponseBuilder->internalServerError($e->getMessage());
        }
        return $this->respond($response);
    }

    public function updateIdukaStudent(): \CodeIgniter\HTTP\Response
    {
        return $this->respond(
            $this->config->ApiResponseBuilder(
                $this->masterData->updateByNis(
                    $this->request->getVar('nis'),
                    $this->request->getVar('id')
                )
            )
        );
    }

    public function syncData(): \CodeIgniter\HTTP\Response
    {
        try {
            $result = $this->user->findAllStudent();
            $response = $this->ResponseBuilder->ok($result);
        } catch (\Exception $e) {
            $response = $this->ResponseBuilder->internalServerError($e->getMessage());
        }
        return $this->respond($response);
    }

    public function cekMasterData(): \CodeIgniter\HTTP\Response
    {
        $nis = $this->request->getVar('nis');
        try {
            $result = $this->masterData->findByNis($nis)->getRow();
            $response = $this->ResponseBuilder->ok($result);
        } catch (\Exception $e) {
            $response = $this->ResponseBuilder->internalServerError($e->getMessage());
        }
        return $this->respond($response);
    }

    public function updateMasterDataByNis(): \CodeIgniter\HTTP\Response
    {
        $nis = $this->request->getVar('nis');
        $data = [
            'tpId' => $this->request->getVar('tpId'),
            'id' => $this->request->getVar('id')
        ];
        try {
            $result = $this->masterData->updateByDataNis($nis, $data);
            $response = $this->ResponseBuilder->ok($result);
        } catch (\Exception $e) {
            $response = $this->ResponseBuilder->internalServerError($e->getMessage());
        }
        return $this->respond($response);
    }

    public function findCategory(): \CodeIgniter\HTTP\Response
    {
        try {
            $result = $this->categoryModel->findAll();
            $response = $this->ResponseBuilder->ok($result);
        } catch (\Exception $e) {
            $response = $this->ResponseBuilder->internalServerError($e->getMessage());
        }
        return $this->respond($response);
    }
}