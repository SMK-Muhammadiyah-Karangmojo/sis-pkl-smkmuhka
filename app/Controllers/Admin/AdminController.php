<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;
use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use ReflectionException;

class AdminController extends BaseController
{

    /**
     * @return string|RedirectResponse
     */
    public function index(): string|RedirectResponse
    {
        $data = [
            'title' => "Dashboard",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
        ];
        return $this->responseBuilder->ReturnViewValidation(
            $this->session,
            'pages/admin/dashboard',
            $data
        );
    }

    /**
     * @return string|RedirectResponse
     */
    public function dataSiswa(): string|RedirectResponse
    {
        $major = $this->request->getVar('major') ?: false;
        $tpId = $this->request->getVar('tp') ?: false;
        $data = [
            'title' => "Data",
            'subtitle' => "Data Siswa",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'siswa' => $major != null ? $this->users->findAllSiswaByMajor($major, $tpId) : $this->users->findAllSiswa(),
            'major' => $this->major->findAll(),
            'tp' => $this->tp->findAll()
        ];

        return $this->responseBuilder->ReturnViewValidation(
            $this->session, 'pages/admin/data-student-pkl', $data);
    }

    public function pendamping(): string|RedirectResponse
    {
        $tp = $this->request->getVar('tp') ?: false;
        $major = $this->request->getVar('major') ?: false;
        $data = [
            'title' => "Data Guru Pendamping",
            'subtitle' => "Guru Pendamping Siswa",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'tutor' => $this->tutorModel->findByTpAndMajor($tp, $major),
            'major' => $this->major->findAll(),
            'tp' => $this->tp->findAll(),
            'teacher' => $this->users->findAllTeacher()
        ];

        return $this->responseBuilder->ReturnViewValidation(
            $this->session, 'pages/admin/data-pendamping', $data);
    }

    public function rekap(): string|RedirectResponse
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
        return $this->responseBuilder->ReturnViewValidation(
            $this->session,
            'pages/admin/rekap-data',
            $data
        );
    }

    public function verification(): string|RedirectResponse
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
        return $this->responseBuilder->ReturnViewValidation(
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
            if (!$this->validate($this->formValidation->formValidationVerifikasiDataPKL())) {
                return redirect()->to('/admin/verification?id=' . $id)->withInput();
            }

            $masterData = $this->masterData->find($id);
            $imageName = $oldImage;

            if (!$fileImage->getError() == 4) {
                $fileName = $fileImage->getRandomName();
                $folderName = "/surat-balasan/" . $masterData['nis'];

                $responseMinIo = $this->minioService->uploadFile($fileImage->getTempName(), $fileName, $folderName);
                if ($responseMinIo) {
                    $imageName = $folderName . "/" . $fileName;
                }
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
            return redirect()->to("/admin/verification?id=$id");
        }
    }

    public function exportDataRekapExcel(): void
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

    public function exportDataRekapPdf(): void
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
        $this->response->setHeader('Content-Type', $this->applicationConstant->contentType('pdf'));
        $mpdf->Output('Surat Pengantar.pdf', 'I');
    }

    public function iduka(): string|RedirectResponse
    {
        $majorId = $this->request->getVar('jurusan');
        $jurusan = $this->major->findAll();
        $iduka = $this->idukaModel->findAllByMajorId($majorId);
        $data = [
            'title' => "Data Iduka",
            'subtitle' => "Data Iduka",
            'role' => $this->session->get('role'),
            'users' => $this->session->get('email'),
            'iduka' => $iduka,
            'jurusan' => $jurusan
        ];
        return $this->responseBuilder->ReturnViewValidation(
            $this->session,
            'pages/admin/iduka',
            $data
        );
    }
}