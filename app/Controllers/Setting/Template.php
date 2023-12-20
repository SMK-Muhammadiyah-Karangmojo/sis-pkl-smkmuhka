<?php
/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.my.id/
 */

namespace App\Controllers\Setting;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use Config\APIResponseBuilder;

/**
 * @property \CodeIgniter\Session\Session|mixed|null $session
 * @property APIResponseBuilder $ResponseBuilder
 */
class Template extends BaseController
{

    use ResponseTrait;

    public function __construct()
    {
        $this->session = session();
        $this->ResponseBuilder = new APIResponseBuilder();
    }

    public function index()
    {
        $kategori_surat_id = $this->request->getVar("kategori_surat");
        $tp = $this->request->getVar("tp");
        $data = [
            'title' => "Template",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'kategori' => $this->kategoriSurat->findAll(),
            'template' => $kategori_surat_id,
            'tpId' => $tp,
            'sekolah' => $this->schoolModel->find(1),
            'tp' => $this->tp->findAll(),
            'data_template' => $this->masterTemplateModel->findByCodeAndCategorySuratIdAndTpId("SURAT", $kategori_surat_id, $tp),
            'surat' => $this->nomorSuratModel->findByTp($tp),
            'kop_surat' => $this->masterTemplateModel->findByCode("KOP_SURAT"),
        ];

        $result = $this->ResponseBuilder->ReturnViewValidation(
            $this->session,
            'pages/setting/index',
            $data);

        if (!$data['data_template']) {
            $this->masterTemplateModel->insert(
                [
                    "kategori_surat_id" => $kategori_surat_id,
                    "tp_id" => $tp,
                    "code" => "SURAT"
                ]
            );
        }
        return $result;
    }

    public function updateTemplate()
    {
        $id = $this->request->getVar('id');
        $content = $this->request->getVar('content');
        $content_2 = $this->request->getVar('content_2');
        $content_3 = $this->request->getVar('content_3');
        $content_4 = $this->request->getVar('content_4');
        $content_5 = $this->request->getVar('content_5');
        $tp = $this->request->getVar('tp');
        $detail_tanggal = $this->request->getVar('detail_tanggal');
        $kategori_surat = $this->request->getVar('kategori_surat');
        $response = $this->masterTemplateModel->update(
            $id,
            [
                "hal" => $this->request->getVar("hal"),
                "lampiran" => $this->request->getVar("lampiran"),
                "content" => $content,
                "content_2" => $content_2,
                "content_3" => $content_3,
                "content_4" => $content_4,
                "content_5" => $content_5,
                "detail_tanggal" => $detail_tanggal,
            ]
        );
        if ($response) {
            $this->session->setFlashdata('success', 'update template surat berhasil');
        }
        return redirect()->to("/setting/template?tp=$tp&kategori_surat=$kategori_surat");
    }

    public function templateKopSurat()
    {
        $data = [
            'title' => "Kop Surat",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'data_template' => $this->masterTemplateModel->findByCode("KOP_SURAT"),
        ];

        $result = $this->ResponseBuilder->ReturnViewValidation(
            $this->session,
            'pages/setting/kop-surat',
            $data);

        if (!$data['data_template']) {
            $this->masterTemplateModel->insert(
                [
                    "code" => "KOP_SURAT"
                ]
            );
        }
        return $result;
    }

    public function saveTemplateKopSurat()
    {
        $id = $this->request->getVar('id');
        $content = $this->request->getVar('content');
        $response = $this->masterTemplateModel->update(
            $id,
            [
                "content" => $content
            ]
        );
        if ($response) {
            $this->session->setFlashdata('success', 'update template kop surat berhasil');
        }
        return redirect()->to('/setting/template/kop-surat');
    }
}