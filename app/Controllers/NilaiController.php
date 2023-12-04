<?php
/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.github.io/
 */

namespace App\Controllers;

use App\Models\ClassModel;
use App\Models\MajorModel;
use App\Models\MasterCategoryNilaiModel;
use App\Models\TpModel;
use App\Models\UsersModel;
use Config\APIResponseBuilder;
use Config\IApplicationConstantConfig;
use Config\YantoDevConfig;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * @property \CodeIgniter\Session\Session|mixed|null $session
 * @property YantoDevConfig $config
 * @property APIResponseBuilder $ResponseBuilder
 * @property IApplicationConstantConfig $IApplicationConstant
 * @property UsersModel $usersModel
 * @property MajorModel $major
 * @property MasterCategoryNilaiModel $masterCategoryNilai
 * @property ClassModel $classModel
 */
class NilaiController extends BaseController
{

    public function __construct()
    {
        $this->session = session();
        $this->config = new YantoDevConfig();
        $this->ResponseBuilder = new APIResponseBuilder();
        $this->IApplicationConstant = new IApplicationConstantConfig();
        $this->usersModel = new UsersModel();
        $this->major = new MajorModel();
        $this->tp = new TpModel();
        $this->masterCategoryNilai = new MasterCategoryNilaiModel();
        $this->classModel = new ClassModel();
    }

    public function index()
    {
        $majorId = $this->request->getVar("jurusan");
        $tp = $this->request->getVar("tp");
        $iduka = $this->request->getVar("iduka");
        $result = $this->usersModel->findAllSiswaByMajorAndTpId($majorId, $tp, $iduka);
        $data = [
            'title' => "Daftar Nilai Siswa",
            'users' => $this->session->get('email'),
            'role' => $this->session->get('role'),
            'data' => $result,
            'jurusan' => $this->major->findAll(),
            'tp' => $this->tp->findAll(),
            'categoryNilai' => $this->masterCategoryNilai->findByMajorId($majorId),
            'majorId' => $majorId ? $majorId : 0,
            'tpId' => $tp ? $tp : 0,
            'idukaId' => $iduka ? $iduka : 0,
            'kelas' => $this->classModel->findAllByIsActiveTrue()
        ];
        return $this->ResponseBuilder->ReturnViewValidation(
            $this->session,
            'pages/nilai/index',
            $data
        );
    }

    public function addNilai(): \CodeIgniter\HTTP\RedirectResponse
    {
        $tp = $this->request->getVar('tp');
        $major = $this->request->getVar('majorId');
        $iduka = $this->request->getVar('idukaId');
        $userPublicId = $this->request->getVar('userPublicId[]');
        $id = $this->request->getVar('id[]');
        $nilai1 = $this->request->getVar('nilai_1[]');
        $nilai2 = $this->request->getVar('nilai_2[]');
        $nilai3 = $this->request->getVar('nilai_3[]');
        $nilai4 = $this->request->getVar('nilai_4[]');
        $nilai5 = $this->request->getVar('nilai_5[]');
        $nilai6 = $this->request->getVar('nilai_6[]');
        $nilai7 = $this->request->getVar('nilai_7[]');
        $nilai8 = $this->request->getVar('nilai_8[]');
        $nilai9 = $this->request->getVar('nilai_9[]');
        $nilai10 = $this->request->getVar('nilai_10[]') != null ? $this->request->getVar('nilai_10[]') : "-";
        $nilai11 = $this->request->getVar('nilai_11[]') != null ? $this->request->getVar('nilai_11[]') : "-";
        $result = [];
        foreach ($userPublicId as $key => $val) {
            if (!isset($nilai10[$key]) && !isset($nilai11[$key])) {
                $nilaiFix10 = '-';
                $nilaiFix11 = '-';
            } else {
                $nilaiFix10 = $nilai10[$key];
                $nilaiFix11 = $nilai11[$key];
            }
            $result[] = [
                'user_public_id' => $userPublicId[$key],
                'nilai_1' => $nilai1[$key],
                'nilai_2' => $nilai2[$key],
                'nilai_3' => $nilai3[$key],
                'nilai_4' => $nilai4[$key],
                'nilai_5' => $nilai5[$key],
                'nilai_6' => $nilai6[$key],
                'nilai_7' => $nilai7[$key],
                'nilai_8' => $nilai8[$key],
                'nilai_9' => $nilai9[$key],
                'nilai_10' => $nilaiFix10,
                'nilai_11' => $nilaiFix11,
            ];
        }

        try {
            $query = $this->masterNilai->updateBatch($result, 'user_public_id');
            if ($query) {
                $this->session->setFlashdata('success', 'update nilai berhasil!!!');
            } else {
                $this->masterNilai->insertBatch($result);
                $this->session->setFlashdata('success', 'insert nilai berhasil!!!');
            }
        } catch (\ReflectionException $e) {
            $this->session->setFlashdata('error', $e);
        }
        return redirect()->to("nilai?tp=$tp&jurusan=$major&iduka=$iduka");
    }

    public function exportNilai()
    {
        $tp = $this->request->getVar("tp");
        $kelas = $this->request->getVar("kelas");
        $result = $this->masterNilai->findALlByTpIdAndClassId($tp, $kelas);
        $categoryNilai = $this->masterCategoryNilai->findByMajorId($result[0]->major_id);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue("A1", "Daftar Nilai Kelas " . $result[0]->kelas);
        $sheet->setCellValue("A2", "Tahun Pelajaran " . $result[0]->tpName);
        $sheet->setCellValue('A4', 'NIS');
        $sheet->setCellValue('B4', 'NISN');
        $sheet->setCellValue('C4', 'NAMA');
        $sheet->setCellValue('D4', 'KELAS');

        $row = range('E', 'Z');
        $idx = 0;
        foreach ($categoryNilai as $cat) {
            $sheet->setCellValue($row[$idx++] . "4", $cat->name);
        }

        $rows = 5;
        foreach ($result as $val) {
            $sheet->setCellValue('A' . $rows, $val->nis);
            $sheet->setCellValue('B' . $rows, $val->nisn);
            $sheet->setCellValue('C' . $rows, $val->name);
            $sheet->setCellValue('D' . $rows, $val->kelas);
            $sheet->setCellValue('E' . $rows, $val->nilai_1);
            $sheet->setCellValue('F' . $rows, $val->nilai_2);
            $sheet->setCellValue('G' . $rows, $val->nilai_3);
            $sheet->setCellValue('H' . $rows, $val->nilai_4);
            $sheet->setCellValue('I' . $rows, $val->nilai_5);
            $sheet->setCellValue('J' . $rows, $val->nilai_6);
            $sheet->setCellValue('K' . $rows, $val->nilai_7);
            $sheet->setCellValue('L' . $rows, $val->nilai_8);
            $sheet->setCellValue('M' . $rows, $val->nilai_9);
            $sheet->setCellValue('N' . $rows, $val->nilai_10);
            $sheet->setCellValue('O' . $rows, $val->nilai_11);
            $rows++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'Daftar Nilai PKL Kelas ' . $result[0]->kelas;
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}