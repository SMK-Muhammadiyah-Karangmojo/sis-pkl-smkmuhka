<?php

namespace App\Controllers;

use App\Models\ClassModel;
use App\Models\DataLaporanSiswaModal;
use App\Models\MajorModel;
use App\Models\MasterDataModel;
use App\Models\TutorModel;
use App\Models\UserDetailModel;
use App\Models\UsersModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Session\Session;
use Config\APIResponseBuilder;
use Config\IApplicationConstantConfig;
use Config\YantoDevConfig;

/**
 * @property Session|mixed|null $session
 * @property ClassModel $class
 * @property UserDetailModel $userDetail
 * @property TutorModel $tutor
 * @property DataLaporanSiswaModal $laporan
 * @property IApplicationConstantConfig $IApplicationConstant
 */
class Teacher extends BaseController
{
    use ResponseTrait;

    private APIResponseBuilder $ResponseBuilder;

    public function __construct()
    {
        $this->session = session();
        $this->ResponseBuilder = new APIResponseBuilder();
        $this->IApplicationConstant = new IApplicationConstantConfig();
        $this->config = new YantoDevConfig();
        $this->usersModel = new UsersModel();
        $this->major = new MajorModel();
        $this->class = new ClassModel();
        $this->userDetail = new UserDetailModel();
        $this->masterData = new MasterDataModel();
        $this->tutor = new TutorModel();
        $this->laporan = new DataLaporanSiswaModal();
    }

    public function index()
    {
        $response = $this->users->findTeacherDetailByEmail(
            $this->session->get('email'))->getRow();
        $tutor = $response ? $this->tutor->findByTeacherId($response->id) : null;

        $data = [
            'title' => "Dashboard",
            'validation' => \Config\Services::validation(),
            'users' => $this->session->get('email'),
            'users_id' => $this->session->get('id'),
            'role' => $this->session->get('role'),
            'data' => $response,
            'tutor' => $tutor
        ];
        if ($response) {
            return $this->ResponseBuilder->ReturnViewValidationTeacher(
                $this->session,
                'pages/teacher/dashboard',
                $data
            );
        }
        return $this->ResponseBuilder->ReturnViewValidationTeacher(
            $this->session,
            'pages/teacher/validation',
            $data
        );
    }

    public function profile()
    {
        $response = $this->users->findUserDetailByEmail(
            $this->session->get('email'))->getRow();
        $res = $this->masterData->findByNis($response ? $response->nis : null)->getRow();
        $data = [
            'title' => "Profile",
            'validation' => \Config\Services::validation(),
            'users' => $this->session->get('email'),
            'users_id' => $this->session->get('id'),
            'role' => $this->session->get('role'),
            'data' => $response,
            'major' => $this->major->findAll(),
            'tp' => $this->tp->findAll(),
            'class' => $this->class->getWhere(['is_active' => 1])->getResult(),
            'master' => $res,
            'iduka' => $this->idukaModel->findAllByMajorId($response ? $response->major_id : null)->getResult(),
            'dataIduka' => $this->idukaModel->findById($res ? $res->iduka_id : null)
        ];
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/auth');
        }
        if ($this->session->get('role') != 3) {
            $this->session->destroy();
            return redirect()->to('/auth/error');
        }
        if ($response && $res) {
            return view('pages/student/profile', $data);
        }
        return view('pages/student/validation', $data);
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
                'major_id' => $major['major_id']
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

    public function updateTeacher(): \CodeIgniter\HTTP\Response
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
            $response = $this->ResponseBuilder->ok($result);
        } catch (\Exception $e) {
            $response = $this->ResponseBuilder->internalServerError("update teacher with id " . $id . " failed");
        }
        return $this->respond($response);
    }

    public function findTeacherByTp(): \CodeIgniter\HTTP\Response
    {
        $tp = $this->request->getVar('tp');
        try {
            $result = $this->tutor->findByTp($tp);
            $response = $this->ResponseBuilder->ok($result);
        } catch (\Exception $e) {
            $response = $this->ResponseBuilder->internalServerError($e->getMessage());
        }
        return $this->respond($response);
    }

    public function laporan()
    {
        $response = $this->session ? $this->users->findTeacherDetailByEmail(
            $this->session->get('email'))->getRow() : null;
        $data = [
            'title' => "Laporan Siswa",
            'validation' => \Config\Services::validation(),
            'users' => $this->session->get('email'),
            'users_id' => $this->session->get('id'),
            'role' => $this->session->get('role'),
            'data' => $response,
            'laporan' => $response ? $this->laporan->findStudentReport($response->id) : null
        ];

        return $this->ResponseBuilder->ReturnViewValidationTeacher(
            $this->session,
            'pages/teacher/laporan',
            $data
        );
    }

    public function printReport($id)
    {
        $userDetail = $this->userDetail->findByUserPublicId($id);
        $data = [
            'userDetail' => $userDetail,
            'laporan' => $this->laporan->findByUserPublicId($id)
        ];
        view('pages/general/cetak-laporan-siswa', $data);
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->showImageErrors = true;
        $html = view('pages/general/cetak-laporan-siswa');
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', $this->IApplicationConstant->contentType('pdf'));
        $mpdf->Output('laporan.pdf', 'I');
    }

    public function monitoring($id)
    {
        $teacher = $this->tutor->findByTeacherId($id);
        $data = [
            'iduka' => $teacher,
            'tp' => 5,
            'dataTp' => $this->tp->find(5)
        ];
        view('pages/teacher/cetak-lembar-monitoring', $data);
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->showImageErrors = true;
        $html = view('pages/teacher/cetak-lembar-monitoring', [
            ini_set("pcre.backtrack_limit", "5000000")
        ]);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', $this->IApplicationConstant->contentType('pdf'));
        $mpdf->Output('ID Card.pdf', 'I');
    }
}