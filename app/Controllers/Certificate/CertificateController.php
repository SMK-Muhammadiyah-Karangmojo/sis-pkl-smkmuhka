<?php

namespace App\Controllers\Certificate;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use Mpdf\Mpdf;
use Mpdf\MpdfException;

class CertificateController extends BaseController
{
    public function index(): string|RedirectResponse
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

        return $this->responseBuilder->ReturnViewValidation(
            $this->session,
            'pages/admin/certificate',
            $data
        );
    }

    /**
     * @throws MpdfException
     */
    public function frontCertificate(): void
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
        $this->response->setHeader('Content-Type', $this->applicationConstant->contentType('pdf'));
        $mpdf->Output('Sertifikat-' . $data['data']->name . '.pdf', 'I');
    }

    /**
     * @throws MpdfException
     */
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
        $this->response->setHeader('Content-Type', $this->applicationConstant->contentType('pdf'));
        $mpdf->Output('Sertifikat-' . $data['data']->name . '.pdf', 'I');
    }
}