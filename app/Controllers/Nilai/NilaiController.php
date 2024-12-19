<?php

namespace App\Controllers\Nilai;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class NilaiController extends BaseController
{

    /**
     * @return string|RedirectResponse
     */
    public function index(): string|RedirectResponse
    {
        $majorId = $this->request->getVar("jurusan");
        $tp = $this->request->getVar("tp");
        $iduka = $this->request->getVar("iduka");
        $result = $this->users->findAllSiswaByMajorAndTpId($majorId, $tp, $iduka);
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
            'kelas' => $this->class->findAllByIsActiveTrue()
        ];
        return $this->responseBuilder->ReturnViewValidation(
            $this->session,
            'pages/nilai/index',
            $data
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    public function exportNilai(): void
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

        try {
            $writer->save('php://output');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}