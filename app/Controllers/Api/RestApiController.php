<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use ReflectionException;

class RestApiController extends BaseController
{
    use ResponseTrait;

    public function syncData(): ResponseInterface
    {
        try {
            $result = $this->users->findAllStudent();
            $response = $this->responseBuilder->ok($result);
        } catch (Exception $e) {
            $response = $this->responseBuilder->internalServerError($e->getMessage());
        }
        return $this->respond($response);
    }

    public function syncMasterData(): ResponseInterface
    {
        $nis = $this->request->getVar('nis');
        try {
            $result = $this->masterData->findByNis($nis)->getRow();
            $response = $this->responseBuilder->ok($result);
        } catch (Exception $e) {
            $response = $this->responseBuilder->internalServerError($e->getMessage());
        }
        return $this->respond($response);
    }

    public function updateMasterDataByNis(): ResponseInterface
    {
        $nis = $this->request->getVar('nis');
        $data = [
            'tpId' => $this->request->getVar('tpId'),
            'id' => $this->request->getVar('id')
        ];
        try {
            $result = $this->masterData->updateByDataNis($nis, $data);
            $response = $this->responseBuilder->ok($result);
        } catch (Exception $e) {
            $response = $this->responseBuilder->internalServerError($e->getMessage());
        }
        return $this->respond($response);
    }

    /**
     * @return ResponseInterface
     */
    public function findStudentById(): ResponseInterface
    {
        $id = $this->request->getVar('id');
        try {
            $result = $this->userDetail->findById($id);
            $response = $this->responseBuilder->ok($result);
        } catch (Exception $e) {
            $response = $this->responseBuilder->noContent("student with id " . $id . " not found");
        }
        return $this->respond($response);
    }

    /**
     * @return ResponseInterface
     * @throws ReflectionException
     */
    public function addPresence(): ResponseInterface
    {
        $id = $this->request->getVar("id");
        $note = $this->request->getVar("note");
        $userId = $this->request->getVar("user_id");
        $latitude = $this->request->getVar("latitude");
        $longitude = $this->request->getVar("longitude");
        $fileImage = $this->request->getFile('image');
        $image = null;
        $user = $this->userDetail->findByUserPublicId($userId);

        if ($id && $note) {
            $message = "$user->name baru saja membuat laporan presensi";
        } else if ($id) {
            $message = "$user->name baru saja melakukan presensi pulang";
        } else {
            $message = "$user->name baru saja melakukan presensi masuk";
        }
        if (!$fileImage->getError() == 4) {
            $fileName = $fileImage->getRandomName();
            $folderName = "/presence-image/$user->major/$user->name";

            $responseMinIo = $this->minioService->uploadFile($fileImage->getTempName(), $fileName, $folderName);

            if ($responseMinIo) {
                $image = $folderName . "/" . $fileName;
                $this->botDiscord->sendPresence($_ENV['BASE_URL_PRESENCE'], $message);
            }
        }
        $today = date("Y-m-d");
        $time = date("H:i:s");
        if ($id && $note) {
            $response = $this->presenceModel->update($id, [
                "note" => $note,
            ]);
        } elseif ($id) {
            $message = <<<EOD
📢 *Notifikasi Absensi PKL* 📢

Halo Edi Prabowo 👋,  
*$user->name* telah berhasil melakukan absensi pulang pada:  
📅 $today  
⏰ $time  

📍 Lokasi:  
🌎 [Lihat di Google Maps](https://www.google.com/maps?q=$latitude,$longitude)
EOD;

            $this->whatsappGateway->sendText('083840398931', $message);

            $response = $this->presenceModel->update($id, [
                "time_out" => today(),
                "location_out" => "$latitude,$longitude",
                "image_out" => $image ?? null,
            ]);
        } else {
            $message = <<<EOD
📢 *Notifikasi Absensi PKL* 📢

Halo Edi Prabowo 👋,  
*$user->name* telah berhasil melakukan absensi masuk pada:  
📅 $today  
⏰ $time  

📍 Lokasi:  
🌎 [Lihat di Google Maps](https://www.google.com/maps?q=$latitude,$longitude)
EOD;

            try {
                $this->whatsappGateway->sendText('083840398931', $message);
            } catch (Exception $e) {
                $this->logger->error($e->getMessage());
            }

            $response = $this->presenceModel->insert([
                "users_id" => $userId,
                "location_in" => "$latitude,$longitude",
                "date" => today(),
                "time_in" => today(),
                "image_in" => $image ?? null,
                "tp_id" => $user->tpId,
            ]);
        }


        if ($response) {
            return $this->respond($this->responseBuilder->ok($response));
        }
        return $this->respond($this->responseBuilder->internalServerError("failed to save data"));
    }

    /**
     * @return ResponseInterface
     */
    public function updateIdukaStudent(): ResponseInterface
    {
        return $this->respond(
            $this->responseBuilder->ok(
                $this->masterData->updateByNis(
                    $this->request->getVar('nis'),
                    $this->request->getVar('id')
                )
            )
        );
    }

    /**
     * @return ResponseInterface
     */
    public function updateMasterDataStudent(): ResponseInterface
    {

        $id = $this->request->getVar('id');
        $data = [
            'nis' => $this->request->getVar('nis'),
            'iduka_id' => $this->request->getVar('iduka'),
            'tp_id' => $this->request->getVar('tp'),
            'user_public_id' => $this->request->getVar('userPublicId'),
        ];
        try {
            if (!$id) {
                $response = $this->responseBuilder->ok($this->masterData->save($data));
            } else {
                $response = $this->responseBuilder->ok($this->masterData->update($id,
                    [
                        'iduka_id' => $this->request->getVar('iduka'),
                        'user_public_id' => $this->request->getVar('userPublicId'),
                    ]
                ));
            }
        } catch (Exception $e) {
            $response = $this->responseBuilder->internalServerError($e->getMessage());
        }

        return $this->respond($response);
    }

    public function findAllIdukaByTp($tp): ResponseInterface
    {
        return $this->respond(
            $this->responseBuilder->ok(
                $this->idukaModel->findAllIdukaByTp($tp)
            )
        );
    }

    /**
     * @param $major
     * @return ResponseInterface Iduka
     * Iduka
     */
    public function findAllIdukaByMajor($major): ResponseInterface
    {
        try {
            $result = $this->idukaModel->findAllIdukaByMajor($major);
            $response = $this->responseBuilder->ok($result);
        } catch (Exception $e) {
            $response = $this->responseBuilder->internalServerError($e->getMessage());
        }
        return $this->respond($response);
    }

    /**
     * @return ResponseInterface
     */
    public function findAllIdukaByMajorAndTp(): ResponseInterface
    {
        $data = [
            'major' => $this->request->getVar('major'),
            'tp' => $this->request->getVar('tp')
        ];
        try {
            $result = $this->idukaModel->findAllIdukaByIdAndTp($data);
            $response = $this->responseBuilder->ok($result);
        } catch (Exception $e) {
            $response = $this->responseBuilder->internalServerError($e->getMessage());
        }
        return $this->respond($response);
    }

    public function addIduka(): ResponseInterface
    {
        $request = [
            'name' => $this->request->getVar('name'),
            'address' => $this->request->getVar('address'),
            'major_id' => $this->request->getVar('major')
        ];
        try {
            $responseAddIduka = $this->idukaModel->insert($request);
            if (!is_null($responseAddIduka)) {
                $this->detailIdukaModel->insert([
                    'id_iduka' => $responseAddIduka,
                    'address' => $this->request->getVar('address'),
                ]);
            }
            $response = $this->responseBuilder->ok($responseAddIduka);
        } catch (Exception $e) {
            $response = $this->responseBuilder->internalServerError($e->getMessage());
        }
        return $this->respond($response);
    }

    /**
     * @return ResponseInterface
     */
    public function detailIduka(): ResponseInterface
    {
        $id = $this->request->getVar('id');
        try {
            $result = $this->idukaModel->findById($id);
            if (is_null($result)) {
                $response = $this->responseBuilder->noContent("data with id " . $id . " not found");
            } else {
                $response = $this->responseBuilder->ok($result);
            }
        } catch (Exception $e) {
            $response = $this->responseBuilder->internalServerError($e->getMessage());
        }
        return $this->respond($response);
    }

    public function updateIduka(): ResponseInterface
    {
        $id = $this->request->getVar('id');
        $name = $this->request->getVar('name');
        $address = $this->request->getVar('address');
        $major = $this->request->getVar('major');
        $data = [
            'name' => $name,
            'address' => $address,
            'major' => $major,
        ];
        try {
            $responseDetail = $this->detailIdukaModel->findByIdIduka($id);
            if (is_null($responseDetail)) {
                $this->detailIdukaModel->insert([
                    'id_iduka' => $id,
                    'address' => $address
                ]);
            }
            $result = [
                'updateDetail' => $this->detailIdukaModel->updateByIdIduka($id, $address),
                'updateIduka' => $this->idukaModel->update($id, $data)
            ];
            $response = $this->responseBuilder->ok($result);
        } catch (Exception $e) {
            $response = $this->responseBuilder->internalServerError($e->getMessage());
        }
        return $this->respond($response);
    }

    public function deleteIduka(): ResponseInterface
    {
        return $this->respond(
            $this->responseBuilder->ok(
                $this->idukaModel->delete($this->request->getVar('id'))
            )
        );
    }

    /**
     * @return ResponseInterface
     * Desc Rest api for report
     */
    public function findSubLaporan(): ResponseInterface
    {
        $id = $this->request->getVar('id');
        $result = $this->masterLaporan->findSubLaporanByMasterId($id);
        return $this->respond(
            $this->responseBuilder->ok($result)
        );
    }

    /**
     * @return ResponseInterface
     */
    public function findSubSubLaporan(): ResponseInterface
    {
        $id = $this->request->getVar('id');
        $result = $this->masterLaporan->findSubLaporan1BySubLaporanId($id);
        return $this->respond(
            $this->responseBuilder->ok($result)
        );
    }

    /**
     * @return ResponseInterface
     */
    public function deleteReport(): ResponseInterface
    {
        return $this->respond($this->responseBuilder->ok(
            $this->laporanSiswa->delete(
                $this->request->getVar('id')
            )
        ));
    }

    /**
     * Tutor
     */
    public function findTutorById(): ResponseInterface
    {
        return $this->respond(
            $this->responseBuilder->ok(
                $this->tutorModel->findById($this->request->getVar('id'))
            )
        );
    }

    public function updateTutor(): ResponseInterface
    {
        $data = [
            'tp_id' => $this->request->getVar('tp'),
            'major_id' => $this->request->getVar('major'),
            'iduka_id' => $this->request->getVar('iduka'),
            'teacher_id' => $this->request->getVar('userId')
        ];
        return $this->respond(
            $this->responseBuilder->ok(
                $this->tutorModel->update($this->request->getVar('id'), $data)
            )
        );
    }

    public function addPendamping(): ResponseInterface
    {
        $data = [
            'tp_id' => $this->request->getVar('tp'),
            'major_id' => $this->request->getVar('major'),
            'iduka_id' => $this->request->getVar('iduka'),
            'teacher_id' => $this->request->getVar('teacher')
        ];
        return $this->respond(
            $this->responseBuilder->ok(
                $this->tutorModel->save($data)
            )
        );
    }

    public function findAllDataPresence(): ResponseInterface
    {
        $limit = $this->request->getVar("limit") ?? 10;
        $offset = $this->request->getVar("offset") ?? 0;
        $search = strtolower($this->request->getVar("search")) ?? null;

        $totalData = $this->presenceModel->findAllByDeletedAtNullWithPagination($limit, $offset, $search)->countAllResults();
        $totalPage = ceil($totalData / $limit);

        return $this->respond(
            $this->responseBuilder->paginationResult(
                $this->presenceModel->findAllByDeletedAtNullWithPagination($limit, $offset, $search)->get()->getResult(),
                $totalPage,
                $totalData
            )
        );
    }

    public function findAllMajor(): ResponseInterface
    {
        $result = $this->responseBuilder->ok($this->major->findAll());
        return $this->respond($result);
    }

    public function detailMajor(): ResponseInterface
    {
        return $this->respond(
            $this->responseBuilder->ok(
                $this->major->find($this->request->getVar('id'))
            )
        );
    }

    public function editMentor($id): ResponseInterface
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

    public function findTeacherById(): ResponseInterface
    {
        $id = $this->request->getVar('id');
        try {
            $result = $this->users->findTeacherById($id);
            $response = $this->responseBuilder->ok($result);
        } catch (Exception $e) {
            $response = $this->responseBuilder->internalServerError($e->getMessage());
        }
        return $this->respond($response);
    }

    public function updateTeacher(): ResponseInterface
    {
        $id = $this->request->getVar('id');
        $data = [
            'nbm' => $this->request->getVar('nbm'),
            'name' => $this->request->getVar('name'),
            'position' => $this->request->getVar('position'),
            'hp' => $this->request->getVar('hp')
        ];
        try {
            $result = $this->userDetail->updateTeacher($id, $data);
            $response = $this->responseBuilder->ok($result);
        } catch (Exception $e) {
            $response = $this->responseBuilder->internalServerError("update teacher with id " . $id . " failed");
        }
        return $this->respond($response);
    }
}