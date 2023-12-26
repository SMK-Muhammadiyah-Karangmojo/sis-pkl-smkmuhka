<?php

/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.my.id/
 */

namespace App\Controllers;

use App\Libraries\PdfGenerator;
use App\Models\KajurModel;
use App\Models\KategoriSuratModel;
use App\Models\MajorModel;
use App\Models\NomorSuratModel;
use App\Models\SuratModel;
use App\Models\TeacherModel;
use App\Models\TutorModel;
use App\Models\UsersModel;
use CodeIgniter\API\ResponseTrait;
use Config\APIResponseBuilder;
use Config\IApplicationConstantConfig;
use Config\Services;
use Config\YantoDevConfig;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use ReflectionException;


/**
 * @property \CodeIgniter\Session\Session|mixed|null $session
 * @property APIResponseBuilder $ResponseBuilder
 * @property IApplicationConstantConfig $IApplicationConstant
 * @property SuratModel $surat
 * @property KajurModel $kajur
 * @property TutorModel $tutor
 * @property KategoriSuratModel $kategoriSurat
 * @property TeacherModel $teacher
 * @property NomorSuratModel $nomorModel
 * @property PdfGenerator $pdfGenerator
 */
class  Admin extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->session = session();
        $this->config = new YantoDevConfig();
        $this->ResponseBuilder = new APIResponseBuilder();
        $this->IApplicationConstant = new IApplicationConstantConfig();
        $this->usersModel = new UsersModel();
        $this->major = new MajorModel();
        $this->surat = new SuratModel();
        $this->kajur = new KajurModel();
        $this->tutor = new TutorModel();
        $this->teacher = new TeacherModel();
        $this->kategoriSurat = new KategoriSuratModel();
        $this->nomorModel = new NomorSuratModel();
        $this->pdfGenerator = new PdfGenerator();
    }

    public function index()
    {
        $data = [
            'title' => "Dashboard",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
        ];
        return $this->ResponseBuilder->ReturnViewValidation(
            $this->session,
            'pages/admin/dashboard',
            $data
        );
    }

    public function data()
    {
        $major = $this->request->getVar('major') ?: false;
        $data = [
            'title' => "Data",
            'subtitle' => "Data Siswa",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'siswa' => $major != null ? $this->users->findAllSiswaByMajor($major) : $this->users->findAllSiswa(),
            'major' => $this->major->findAll(),
            'tp' => $this->tp->findAll()
        ];

        return $this->ResponseBuilder->ReturnViewValidation(
            $this->session,
            'pages/admin/data-student-pkl',
            $data
        );
    }

    public function pendamping()
    {
        $tp = $this->request->getVar('tp') ?: false;
        $major = $this->request->getVar('major') ?: false;
        $data = [
            'title' => "Data Guru Pendamping",
            'subtitle' => "Guru Pendamping Siswa",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'tutor' => $this->tutor->findByTpAndMajor($tp, $major),
            'major' => $this->major->findAll(),
            'tp' => $this->tp->findAll(),
            'teacher' => $this->users->findAllTeacher()
        ];
        if (!$this->session->get('logged_in')) {
            return redirect()->to($this->IApplicationConstant->auth);
        }
        if ($this->session->get('role') != 1) {
            return redirect()->to($this->IApplicationConstant->authError);
        }
        return view('pages/admin/data-pendamping', $data);
    }

    public function rekap()
    {
        $tp = $this->request->getVar('tp') ?: false;
        $major = $this->request->getVar('major') ?: false;
        $data = [
            'title' => "Rekap Data",
            'subtitle' => "Rekap Data Lokasi PKL",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'data' => $this->masterData->findByTpAndMajor($tp, $major),
            'major' => $this->major->findAll(),
            'tp' => $this->tp->findAll(),
            'teacher' => $this->users->findAllTeacher(),
            'dataTp' => $tp,
            'dataMajor' => $major
        ];
        return $this->ResponseBuilder->ReturnViewValidation(
            $this->session,
            'pages/admin/rekap-data',
            $data
        );
    }

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function rekapExcel()
    {
        $tp = $this->request->getVar('tp');
        $major = $this->request->getVar('major');
        $spreadsheet = new Spreadsheet();
        $data = $this->masterData->findByTpAndMajor($tp, $major);
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Rekap Data Siswa PKL')
            ->setCellValue('A2', 'Tahun Pelajaran ' . ($tp != null ? $data[0]->tpName : 'Semua'))
            ->setCellValue('A4', 'Tahun Pelajaran')
            ->setCellValue('B4', 'NIS')
            ->setCellValue('C4', 'Nama Lengkap')
            ->setCellValue('D4', 'Jurusan')
            ->setCellValue('E4', 'Kelas')
            ->setCellValue('F4', 'Iduka')
            ->setCellValue('G4', 'Alamat')
            ->setCellValue('H4', 'Guru Pendamping')
            ->setCellValue('I4', 'Status');

        $column = 5;

        foreach ($data as $d) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $d->tpName)
                ->setCellValue('B' . $column, $d->nis)
                ->setCellValue('C' . $column, $d->name)
                ->setCellValue('D' . $column, $d->majorName)
                ->setCellValue('E' . $column, $d->kelas)
                ->setCellValue('F' . $column, $d->idukaName)
                ->setCellValue('G' . $column, $d->address)
                ->setCellValue('H' . $column, $d->teacherName)
                ->setCellValue('I' . $column, statusPKLExcel($d->status));

            $column++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = date('Y-m-d-His') . '-Rekap-Siswa';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    /**
     * @throws MpdfException
     */
    public function rekapPDF()
    {
        $tp = $this->request->getVar('tp');
        $major = $this->request->getVar('major');
        $data = [
            'title' => "Rekap Data",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'data' => $this->masterData->findByTpAndMajor($tp, $major),
            'major' => $major,
            'tp' => $tp,
            'teacher' => $this->users->findAllTeacher(),
        ];

        view('pages/general/cetak-rekap-siswa', $data);
        $mpdf = new Mpdf();
        $mpdf->showImageErrors = true;
        $html = view('pages/general/cetak-rekap-siswa', []);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', $this->IApplicationConstant->contentType('pdf'));
        $mpdf->Output('Surat Pengantar.pdf', 'I');
    }

    public function verifikasi()
    {
        $id = $this->request->getVar('id');
        $data = [
            'title' => "Verifikasi Data",
            'subtitle' => "Rekap Data Lokasi PKL",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'validation' => Services::validation(),
            'master' => $this->masterData->findById($id),
            'statusData' => '',
        ];
        return $this->ResponseBuilder->ReturnViewValidation(
            $this->session,
            'pages/admin/verifikasi-data-pkl',
            $data
        );

    }

    public function verificationData()
    {
        helper(['form']);
        $id = $this->request->getVar('id');
        $status = $this->request->getVar('status');
        $statusData = $this->request->getVar('statusData');
        $oldImage = $this->request->getVar('oldImage');
        $fileImage = $this->request->getFile('image');
        try {
            if (!$this->validate($this->config->formValidationVerifikasiDataPKL())) {
                return redirect()->to('/admin/verifikasi?id=' . $id)->withInput();
            }
            $imageName = $oldImage;
            if (!$fileImage->getError() == 4 && !$fileImage->hasMoved()) {
                $message = "Verifikasi lokasi PKL";
                $filePath = WRITEPATH . 'uploads/' . $fileImage->store();
                $result = $this->botDiscord->sendImagePresence($_ENV['BASE_URL_NOTIFICATION'], $filePath, $message);
                $imageName = $result->attachments[0]->url;
            }
            $this->masterData->update($id, [
                'image' => $imageName,
                'status' => $status
            ]);
            $this->session->setFlashdata('success', 'Data is updated!!!');
            if ($statusData == 'student') {
                return redirect()->to('/student');
            } else {
                return redirect()->to('/admin/rekap');
            }
        } catch (ReflectionException $e) {
            $this->session->setFlashdata('error', $e);
        }
    }

    public function master_sekolah()
    {
        $session = session();
        $data = [
            'title' => "Master Sekolah",
            'users' => $session->get('email'),
            'role' => $session->get('role'),
            'sekolah' => $this->schoolModel->find(1)
        ];
        $id = $this->request->getVar("id");
        if ($id) {
            $result = $this->schoolModel->update($id, [
                "name" => $this->request->getPost('name'),
                "npsn" => $this->request->getPost('npsn'),
                "address" => $this->request->getPost('address'),
                "phone" => $this->request->getPost('phone'),
                "akreditasi" => $this->request->getPost('akreditasi'),
                "ks" => $this->request->getPost('kepala_sekolah'),
                "nip" => $this->request->getPost('nip'),
                "ttd" => $this->request->getPost('ttd'),
            ]);
            if ($result) {
                $this->session->setFlashdata('success', 'Data is updated!!!');
                return redirect()->to('/admin/master_sekolah');
            }
        }

        return $this->ResponseBuilder->ReturnViewValidation(
            $this->session,
            'pages/admin/master-sekolah',
            $data
        );

    }

    /**
     * menu master data
     */

    public function iduka()
    {
        $majorId = $this->request->getVar('jurusan');
        $jurusan = $this->major->findAll();
        $iduka = $this->idukaModel->findAllByMajorId($majorId);
        $data = [
            'title' => "Iduka",
            'subtitle' => "Data Iduka",
            'role' => $this->session->get('role'),
            'users' => $this->session->get('email'),
            'iduka' => $iduka,
            'jurusan' => $jurusan
        ];
        if (!$this->session->get('logged_in')) {
            return redirect()->to($this->IApplicationConstant->auth);
        }
        if ($this->session->get('role') != 1) {
            return redirect()->to($this->IApplicationConstant->authError);
        }
        return view('pages/admin/iduka', $data);
    }

    /*
     * Menu guru
     */
    public function guru()
    {
        $session = session();
        $guru = $this->guruModel->findAll();
        $data = [
            'title' => "Guru",
            'subtitle' => "Data Guru",
            'role' => $session->get('role'),
            'users' => $session->get('email'),
            'guru' => $guru,
        ];
        if (!$this->session->get('logged_in')) {
            return redirect()->to($this->IApplicationConstant->auth);
        }
        if ($session->get('role') != 1) {
            return redirect()->to($this->IApplicationConstant->authError);
        }
        return view('pages/admin/guru', $data);
    }


    public function addGuru()
    {
        try {
            $this->guruModel->save([
                'email' => $this->request->getVar('nbm'),
                'nama' => $this->request->getVar('name'),
                'nbm' => $this->request->getVar('nbm'),
                'hp' => $this->request->getVar('hp'),
                'jabatan' => $this->request->getVar('jabatan'),
            ]);
        } catch (ReflectionException $e) {
            dd((array)$e);
        }
    }

    public function updateGuru($id)
    {
        try {
            $this->guruModel->update($id, [
                'nbm' => $this->request->getVar('nbm'),
                'nama' => $this->request->getVar('name'),
                'jabatan' => $this->request->getVar('jabatan'),
                'hp' => $this->request->getVar('hp'),
                'email' => $this->request->getVar('email'),
            ]);
        } catch (ReflectionException $e) {
            dd((array)$e);
        }
    }

    public function deleteGuru()
    {
        $this->guruModel->delete($this->request->getVar('id'));
    }

    public function nomor()
    {
        $id = $this->request->getVar('id');
        $tp = $this->request->getVar('tp');
        $category = $this->request->getVar('category');
        $nomor = $this->request->getVar('nomor');
        $tgl = $this->request->getVar('tgl');
        if ($tp && $category && $nomor && $tgl) {
            $request = [
                'nomor' => $nomor,
                'tanggal' => $tgl,
                'tp_id' => $tp,
                'kategori_surat_id' => $category
            ];
            if ($id) {
                try {
                    $result = $this->nomorModel->update($id, $request);
                    $response = $this->ResponseBuilder->ok($result);
                    return $this->respond($response);
                } catch (ReflectionException $e) {
                    $this->session->setFlashdata('error', $e);
                }
            } else {
                try {
                    $this->nomorModel->insert($request);
                    $this->session->setFlashdata('success', 'tambah nomor surat berhasil');
                    return redirect()->to('admin/nomor');
                } catch (ReflectionException $e) {
                    $this->session->setFlashdata('error', $e);
                }
            }

        } elseif ($id) {
            $result = $this->nomorModel->findAllById($id);
            $response = $this->ResponseBuilder->ok($result);
            return $this->respond($response);
        }
        $data = [
            'title' => "Nomor Surat",
            'subtitle' => "Data Nomor Surat",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'tp' => $this->tp->findAll(),
            'category' => $this->kategoriSurat->findAll(),
            'data' => $this->nomorModel->findAllBy()
        ];

        return $this->ResponseBuilder->ReturnViewValidation(
            $this->session,
            'pages/admin/nomor-surat',
            $data
        );
    }

    public function deleteNomor()
    {
        $id = $this->request->getVar('id');
        $result = $this->nomorModel->delete($id);
        $response = $this->ResponseBuilder->ok($result);
        return $this->respond($response);
    }

    public function tp()
    {
        $data = [
            'title' => "Tahun Pelajaran",
            'subtitle' => "Data Tahun Pelajaran",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'tp' => $this->tp->findAll()
        ];
        if (!$this->session->get('logged_in')) {
            return redirect()->to($this->IApplicationConstant->auth);
        }
        if ($this->session->get('role') != 1) {
            return redirect()->to($this->IApplicationConstant->authError);
        }
        return view('pages/admin/tp', $data);
    }

    public function teacher()
    {
        $data = [
            'title' => "Guru",
            'subtitle' => "Data Guru",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'data' => $this->users->findAllTeacher()
        ];
        if (!$this->session->get('logged_in')) {
            return redirect()->to($this->IApplicationConstant->auth);
        }
        if ($this->session->get('role') != 1) {
            return redirect()->to($this->IApplicationConstant->authError);
        }
        return view('pages/admin/data-teacher', $data);
    }

    public function student()
    {
        $data = [
            'title' => "Siswa",
            'subtitle' => "Data Siswa",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'data' => $this->users->findAllStudent()
        ];
        if (!$this->session->get('logged_in')) {
            return redirect()->to($this->IApplicationConstant->auth);
        }
        if ($this->session->get('role') != 1) {
            return redirect()->to($this->IApplicationConstant->authError);
        }
        return view('pages/admin/data-student', $data);
    }

    public function users()
    {
        $data = [
            'title' => "Users",
            'subtitle' => "Data Users",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'data' => $this->users->findAllByDetail()
        ];
        return $this->ResponseBuilder->ReturnViewValidation(
            $this->session,
            'pages/admin/data-users',
            $data,
        );
    }

    public function print()
    {
        $data = [
            'title' => "Cetak",
            'subtitle' => "Cetak Data",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'major' => $this->major->findAll(),
            'tp' => $this->tp->findAll()
        ];
        return $this->ResponseBuilder->ReturnViewValidation(
            $this->session,
            'pages/admin/print',
            $data,
        );
    }

    /**
     * @throws MpdfException
     */
    public function printApplicationLetter()
    {
        $tp = $this->request->getVar('tp');
        $major = $this->request->getVar('major_id');
        $iduka = $this->request->getVar('iduka');
        $instansi = $this->request->getVar('instansi');
        $surat = $this->surat->findByTp($tp)->getRow();
        $masterData = $this->masterData->findByIdukaAndTp($iduka, $tp);
        $school = $this->schoolModel->find(1);
        $kajur = $this->kajur->findByMajor($major)->getRow();
        if ($surat === null) {
            $this->session->setFlashdata(
                'info',
                'Anda belum melengkapi data surat, silahkan lengkapi terlebih dahulu!!!'
            );
            return redirect()->to('/admin/print');
        }
        $data = [
            'iduka' => $this->idukaModel->findById($iduka),
            'instansi' => $instansi,
            'surat' => $surat ?: '',
            'master_data' => $masterData,
            'kajur' => $kajur,
            'school' => $school
        ];
        view('pages/general/permohonan1', $data);
        view('pages/general/permohonan2', $data);

        $mpdf = new Mpdf();
        $mpdf->showImageErrors = true;
        $html = view('pages/general/permohonan1', []);
        $mpdf->WriteHTML($html);

        $mpdf->AddPage();
        $mpdf->SetFooter('<p align="left">
                            1 lembar dikirim ke SMK Muh. Karangmojo<br />
                            1 lembar untuk arsip Kepala Kompetensi Keahlian<br />
                            1 lembar untuk arsip IDUKA (Instansi)<br />
                            *) Coret salah satu
                        </p>');
        $html2 = view('pages/general/permohonan2', []);
        $mpdf->WriteHTML($html2);
        $this->response->setHeader('Content-Type', $this->IApplicationConstant->contentType('pdf'));
        $iduka = $this->idukaModel->find($iduka);
        $mpdf->Output('Surat Permohonan ' . $iduka["name"] . '.pdf', 'I');
    }

    /**
     * @throws MpdfException
     */
    public function printAssignmentLetter()
    {
        $tp = $this->request->getVar('tp_tugas');
        $teacherId = $this->request->getVar('teacher');
        $result = $this->teacher->findAllByUserPublicId($teacherId);
        $data = [
            'results' => $result,
            'surat' => $this->nomorModel->findByTpAndCategory($tp, 2),
            'tp' => $tp,
            'school' => $this->schoolModel->find(1),
            'kop_surat' => $this->masterTemplateModel->findByCode("KOP_SURAT"),
        ];
        view('pages/general/cetak-surat-tugas', $data);
        $mpdf = new Mpdf();
        $mpdf->showImageErrors = true;
        $html = view('pages/general/cetak-surat-tugas', []);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', $this->IApplicationConstant->contentType('pdf'));
        $mpdf->Output('Surat Tugas ' . $result[0]->name . '. pdf', 'I');
    }

    /**
     * @throws MpdfException
     */
    public function printCoveringLetter()
    {
        $tp = $this->request->getVar('tp_pengantar');
        $major = $this->request->getVar('major_id_pengantar');
        $result = $this->masterData->findIdukaByTpAndMajor($tp, $major);
        $surat = $this->nomorModel->findByTpAndCategory($tp, 4);
        $data = [
            'instansi' => $this->request->getVar('instansi'),
            'result' => $result,
            'surat' => $surat,
            'school' => $this->schoolModel->find(1),
            'master_template' => $this->masterTemplateModel->findByCodeAndCategorySuratIdAndTpId("SURAT", $surat->kategori_surat_id, $tp),
            'kop_surat' => $this->masterTemplateModel->findByCode("KOP_SURAT"),
        ];
        view('pages/general/cetak-surat-pengantar', $data);
        $mpdf = new Mpdf();
        $html = view('pages/general/cetak-surat-pengantar', []);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', $this->IApplicationConstant->contentType('pdf'));
        $mpdf->Output('Surat Pengantar.pdf', 'I');
    }

    public function printIdCard()
    {
        $tp = $this->request->getVar('tpIdCard');
        $major = $this->request->getVar('majorIdCard');
        $result = $this->masterData->findByTpAndMajor($tp, $major);
        $data = [
            'instansi' => $this->request->getVar('instansi'),
            'result' => $result,
            'surat' => $this->nomorModel->findByTp($tp),
            'data' => $this->masterData->findByTpAndMajor($tp, $major)
        ];
        view('pages/general/cetak-id-card', $data);
        $mpdf = new Mpdf();
        $mpdf->showImageErrors = true;
        $html = view('pages/general/cetak-id-card', [
            ini_set("pcre.backtrack_limit", $this->IApplicationConstant->limitPdf)
        ]);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', $this->IApplicationConstant->contentType('pdf'));
        $mpdf->Output('ID Card.pdf', 'I');
    }

    public function printLetterHead()
    {
        $tp = $this->request->getVar('tp_kop');
        $data = [
            'instansi' => $this->request->getVar('instansi'),
            'surat' => $this->nomorModel->findByTp($tp),
            'data' => $this->idukaModel->findById($this->request->getVar('kop-surat-iduka')),
            'hal' => $this->request->getVar('hal'),
            'kop_surat' => $this->masterTemplateModel->findByCode("KOP_SURAT"),
        ];
        view('pages/general/cetak-kop-surat', $data);
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => [110, 220],
            'orientation' => 'L',
            'setAutoTopMargin' => false,
        ]);
        $mpdf->showImageErrors = true;
        $html = view('pages/general/cetak-kop-surat', [
            ini_set("pcre.backtrack_limit", $this->IApplicationConstant->limitPdf)
        ]);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', $this->IApplicationConstant->contentType('pdf'));
        $mpdf->Output('kop-surat.pdf', 'I');
    }

    public function printLetterDisposition()
    {
        $tp = $this->request->getVar('tp_surat_jalan');
        $surat = $this->nomorModel->findByTpAndCategory($tp, 3);
        $data = [
            'instansi' => $this->request->getVar('instansi'),
            'surat' => $this->nomorModel->findByTp($tp),
            'iduka' => $this->masterData->findByTp($tp),
            'nomor' => $this->nomorModel->findByTpAndCategory($tp, 3),
            'tp' => $tp,
            'kop_surat' => $this->masterTemplateModel->findByCode("KOP_SURAT"),
            'school' => $this->schoolModel->find(1),
            'master_template' => $this->masterTemplateModel->findByCodeAndCategorySuratIdAndTpId("SURAT", $surat->kategori_surat_id, $tp),
        ];
        view('pages/general/cetak-surat-jalan', $data);
        $mpdf = new Mpdf();
        $mpdf->showImageErrors = true;
        $html = view('pages/general/cetak-surat-jalan', [
            ini_set("pcre.backtrack_limit", $this->IApplicationConstant->limitPdf)
        ]);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', $this->IApplicationConstant->contentType('pdf'));
        $mpdf->Output('surat-jalan.pdf', 'I');
    }

    public function printParticipantList()
    {
        $tp = $this->request->getVar('tp_daftar_siswa');
        $data = [
            'surat' => $this->nomorModel->findByTp($tp),
            'iduka' => $this->masterData->findByTp($tp),
            'nomor' => $this->nomorModel->findByTpAndCategory($tp, 3),
            'tp' => $tp,
            'dataTp' => $this->tp->find($tp),
            'school' => $this->schoolModel->find(1),
            'kop_surat' => $this->masterTemplateModel->findByCode("KOP_SURAT"),
        ];
        view('pages/general/cetak-daftar-peserta', $data);
        $mpdf = new Mpdf();
        $mpdf->showImageErrors = true;
        $html = view('pages/general/cetak-daftar-peserta', [
            ini_set("pcre.backtrack_limit", $this->IApplicationConstant->limitPdf)
        ]);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', $this->IApplicationConstant->contentType('pdf'));
        $mpdf->Output('ID Card.pdf', 'I');
    }

    /**
     * @throws MpdfException
     */
    public function printMonitoringSheet()
    {
        $tp = $this->request->getVar('tp_monitoring');
        $data = [
            'surat' => $this->nomorModel->findByTp($tp),
            'iduka' => $this->masterData->findByTp($tp),
            'tp' => $tp,
            'dataTp' => $this->tp->find($tp)
        ];
        view('pages/general/cetak-lembar-monitoring', $data);
        $mpdf = new Mpdf();
        $mpdf->showImageErrors = true;
        $html = view('pages/general/cetak-lembar-monitoring', [
            ini_set("pcre.backtrack_limit", $this->IApplicationConstant->limitPdf)
        ]);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', $this->IApplicationConstant->contentType('pdf'));
        $mpdf->Output('ID Card.pdf', 'I');
    }

    /**
     * @throws MpdfException
     */
    public function printStudentPresence()
    {
        $tp = $this->request->getVar('tp_dh');
        $data = [
            'surat' => $this->nomorModel->findByTp($tp),
            'iduka' => $this->masterData->findByTp($tp),
            'tp' => $tp,
            'dataTp' => $this->tp->find($tp)
        ];
        view('pages/general/cetak-daftar-hadir', $data);
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'L',
            'setAutoTopMargin' => false,
        ]);
        $mpdf->showImageErrors = true;
        $html = view('pages/general/cetak-daftar-hadir', [
            ini_set("pcre.backtrack_limit", $this->IApplicationConstant->limitPdf)
        ]);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', $this->IApplicationConstant->contentType('pdf'));
        $mpdf->Output('ID Card.pdf', 'I');
    }

    public function certificate()
    {
        $tpInput = $this->request->getVar("tp");
        $majorInput = $this->request->getVar("major");
        if ($tpInput && $majorInput) {
            $result = $this->masterData->findAllStudentByTpAndMajor($tpInput, $majorInput);
        } else {
            $result = $this->masterData->findAllStudent();
        }
        $data = [
            'title' => "Cetak Sertifikat",
            'subtitle' => "Daftar Siswa",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'data' => $result,
            'jurusan' => $this->major->findAll(),
            'tp' => $this->tp->findAll()
        ];

        return $this->ResponseBuilder->ReturnViewValidation(
            $this->session,
            'pages/admin/certificate',
            $data
        );
    }

    public function frontCertificate()
    {
        $id = $this->request->getVar('id');
        $majorId = $this->request->getVar('majorId');
        $result = $this->masterData->findStudentById($id);
        $data = [
            'data' => $result,
            'school' => $this->schoolModel->find(1),
            'mentor' => $this->mentorDetailModel->findByIdukaIdAndTpId($result->idukaId, $result->tpId)
        ];
        $file = 'pages/general/front-certificate-' . $majorId;
        view($file, $data);
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => [215, 330],
            'orientation' => 'L',
            'setAutoTopMargin' => false,
        ]);
        $mpdf->showImageErrors = true;
        $html = view($file);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', $this->IApplicationConstant->contentType('pdf'));
        $mpdf->Output('Sertifikat-' . $data['data']->name . '.pdf', 'I');
    }

    public function backCertificate()
    {
        $id = $this->request->getVar('id');
        $majorId = $this->request->getVar('majorId');
        $result = $this->masterData->findStudentById($id);
        $data = [
            'data' => $result,
            'school' => $this->schoolModel->find(1),
            'mentor' => $this->mentorDetailModel->findByIdukaIdAndTpId($result->idukaId, $result->tpId),
            'tableNonTeknis' => $this->masterCategoryNilai->findAllByMajorIdAndMasterCodeId($majorId, 1),
            'tableTeknis' => $this->masterCategoryNilai->findAllByMajorIdAndMasterCodeId($majorId, 2),
            'nilai' => $this->masterNilai->findAllByUserPublicId($result->userPublicId)
        ];
        $file = 'pages/general/back-certificate';
        view($file, $data);
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => [215, 330],
            'orientation' => 'L',
            'setAutoTopMargin' => false,
        ]);
        $mpdf->showImageErrors = true;
        $html = view($file);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', $this->IApplicationConstant->contentType('pdf'));
        $mpdf->Output('Sertifikat-' . $data['data']->name . '.pdf', 'I');
    }
}