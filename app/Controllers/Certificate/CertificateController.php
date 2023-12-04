<?php

namespace App\Controllers\Certificate;

use App\Controllers\BaseController;
use App\Models\CertificateModel;
use App\Models\MasterSettingCertificateUkkModel;
use CodeIgniter\API\ResponseTrait;
use Config\IApplicationConstantConfig;
use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

/**
 * @property CertificateModel $certificate
 * @property IApplicationConstantConfig $IApplicationConstant
 * @property \CodeIgniter\Session\Session|mixed|null $session
 * @property MasterSettingCertificateUkkModel $masterSettingCertificateModel
 */
class CertificateController extends BaseController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->certificate = new CertificateModel();
        $this->IApplicationConstant = new IApplicationConstantConfig();
        $this->session = session();
        $this->masterSettingCertificateModel = new MasterSettingCertificateUkkModel();
    }

    public function index()
    {
        $kelas = $this->request->getVar('kelas');
        $data = [
            'title' => 'sertifikat',
            'kelas' => $kelas,
            'sekolah' => $this->certificate->getDataSekolah(),
            'asesor' => $this->certificate->getDataAsesor($kelas),
            'data' => $this->certificate->getDataSertifikat($kelas),
        ];

        return view("certificate/page/index", $data);
    }

    public function masterSekolah()
    {
        $data = [
            'kepsek' => $this->request->getVar('ks'),
            'nip' => $this->request->getVar('nbm'),
            'print_date' => $this->request->getVar('tgl'),
        ];
        return $this->respond($this->certificate->updateMasterSekolah($this->request->getVar('id'), $data));
    }

    public function masterAccessor()
    {
        $data = [
            'accessor' => $this->request->getVar('accessor'),
            'nopeg' => $this->request->getVar('nopeg'),
        ];
        return $this->respond($this->certificate->updateMasterAccessor($this->request->getVar("id"), $data));
    }

    public function frontCertificate()
    {
        $kelas = $this->request->getVar('kelas');
        $nisn = $this->request->getVar('nisn');
        $data = [
            'title' => 'Sertifikat Depan',
            'sekolah' => $this->certificate->getDataSekolah(),
            'kelas' => $kelas,
            'nisn' => $nisn,
            'jurusan' => getJurusan($kelas),
            'data' => $this->certificate->getMasterData($nisn),
            'asesor' => $this->certificate->getDataAsesor($kelas),
        ];

        view("certificate/page/sertifikat-depan", $data);
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => [210, 297],
            'orientation' => 'L',
            'setAutoTopMargin' => false,
        ]);
        $mpdf->showImageErrors = true;
        $html = view('certificate/page/sertifikat-depan', []);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', $this->IApplicationConstant->contentType('pdf'));
        $mpdf->Output('Surat Pengantar.pdf', 'I');
    }

    public function backCertificate()
    {
        $kelas = $this->request->getVar('kelas');
        $nisn = $this->request->getVar('nisn');
        $data = [
            'title' => 'Sertifikat Belakang',
            'sekolah' => $this->certificate->getDataSekolah(),
            'kelas' => $kelas,
            'nisn' => $nisn,
            'jurusan' => getJurusan($kelas),
            'data' => $this->certificate->getMasterData($nisn),
            'asesor' => $this->certificate->getDataAsesor($kelas),
            'nilai' => $this->certificate->getNilai($kelas),
            'table' => $this->masterSettingCertificateModel->getDataByClass($kelas)
        ];

        view("certificate/page/sertifikat-belakang", $data);
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => [210, 297],
            'orientation' => 'L',
            'setAutoTopMargin' => false,
        ]);
        $mpdf->showImageErrors = true;
        $html = view('certificate/page/sertifikat-belakang', []);
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', $this->IApplicationConstant->contentType('pdf'));
        $mpdf->Output('Surat Pengantar.pdf', 'I');
    }

    public function importExcel()
    {
        $data = array();
        $kelas = $this->request->getVar('kelas');
        if ($kelas == null) {
            $kelas = 'TKRO';
        }
        // If file uploaded
        if (!empty($_FILES['fileURL']['name'])) {
            $kelas = $this->request->getVar('kelas');
            if ($kelas == null) {
                $kelas = 'TKRO';
            }
            $data = [
                'title' => 'sertifikat',
                'kelas' => $kelas,
                'sekolah' => $this->certificate->getDataSekolah(),
                'asesor' => $this->certificate->getDataAsesor($kelas),
                'data' => $this->certificate->getDataSertifikat($kelas),
            ];
            // get file extension
            $extension = pathinfo($_FILES['fileURL']['name'], PATHINFO_EXTENSION);

            if ($extension == 'csv') {
                $reader = new Csv();
            } elseif ($extension == 'xlsx') {
                $reader = new Xlsx();
            } else {
                $reader = new Xls();
            }
            // file path
            $spreadsheet = $reader->load($_FILES['fileURL']['tmp_name']);
            $allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            // array Count
            $arrayCount = count($allDataInSheet);
            $flag = 0;
            $createArray = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12');
            $makeArray = array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '8' => '8',
                '9' => '9',
                '10' => '10',
                '11' => '11',
                '12' => '12',
            );
            $sheetDataKey = array();
            foreach ($allDataInSheet as $dataInSheet) {
                foreach ($dataInSheet as $key => $value) {
                    if (in_array(trim((string)$value), $createArray)) {
                        $value = preg_replace('/\s+/', '', $value);
                        $sheetDataKey[trim($value)] = $key;
                    }
                }
            }
            $dataDiff = array_diff_key($makeArray, $sheetDataKey);
            if (empty($dataDiff)) {
                $flag = 1;
            }
            // match excel sheet column
            if ($flag == 1) {
                for ($i = 5; $i <= $arrayCount; $i++) {
                    $addresses = array();
                    $nis = $sheetDataKey['1'];
                    $nisn = $sheetDataKey['2'];
                    $name = $sheetDataKey['3'];
                    $kelas = $sheetDataKey['4'];
                    $nil1 = $sheetDataKey['5'];
                    $nil2 = $sheetDataKey['6'];
                    $nil3 = $sheetDataKey['7'];
                    $nil4 = $sheetDataKey['8'];
                    $nil5 = $sheetDataKey['9'];
                    $nil6 = $sheetDataKey['10'];
                    $nil7 = $sheetDataKey['11'];
                    $nil8 = $sheetDataKey['12'];

                    $nis = filter_var(trim((string)$allDataInSheet[$i][$nis]));
                    $nisn = filter_var(trim((string)$allDataInSheet[$i][$nisn]));
                    $name = filter_var(trim((string)$allDataInSheet[$i][$name]));
                    $kelas = filter_var(trim((string)$allDataInSheet[$i][$kelas]));
                    $nil1 = filter_var(trim((string)$allDataInSheet[$i][$nil1]));
                    $nil2 = filter_var(trim((string)$allDataInSheet[$i][$nil2]));
                    $nil3 = filter_var(trim((string)$allDataInSheet[$i][$nil3]));
                    $nil4 = filter_var(trim((string)$allDataInSheet[$i][$nil4]));
                    $nil5 = filter_var(trim((string)$allDataInSheet[$i][$nil5]));
                    $nil6 = filter_var(trim((string)$allDataInSheet[$i][$nil6]));
                    $nil7 = filter_var(trim((string)$allDataInSheet[$i][$nil7]));
                    $nil8 = filter_var(trim((string)$allDataInSheet[$i][$nil8]));
                    $fetchData[] = array(
                        'nis' => $nis,
                        'nisn' => $nisn,
                        'name' => $name,
                        'kelas' => $kelas,
                        'nil_1' => $nil1,
                        'nil_2' => $nil2,
                        'nil_3' => $nil3,
                        'nil_4' => $nil4,
                        'nil_5' => $nil5,
                        'nil_6' => $nil6,
                        'nil_7' => $nil7,
                        'nil_8' => $nil8,
                    );
                }
                $data['dataInfo'] = $fetchData;
                $result = $this->certificate->insertBatch($fetchData);
                if ($result) {
                    $this->session->setFlashdata('success', 'insert data berhasil!!!');
                } else {
                    $this->session->setFlashdata('error', 'Please import correct file, did not match excel sheet column!!!');
                }
            } else {
                $this->session->setFlashdata('error', 'Please import correct file, did not match excel sheet column!!!');
            }
            $data = [
                'title' => 'sertifikat',
                'kelas' => $kelas,
                'sekolah' => $this->certificate->getDataSekolah(),
                'asesor' => $this->certificate->getDataAsesor($kelas),
                'data' => $this->certificate->getDataSertifikat($kelas),
            ];
        }
        $this->session->destroy();
        return view("certificate/page/index", $data);
    }

    public function setting()
    {
        $code = $this->request->getPost('code');
        $request = [
            'tp_id' => $this->request->getPost('tp'),
            'code' => $code,
            'name' => $this->request->getPost('name')
        ];

        $kelas = $this->request->getVar('kelas');
        $data = [
            'title' => 'sertifikat',
            'kelas' => $kelas,
            'sekolah' => $this->certificate->getDataSekolah(),
            'asesor' => $this->certificate->getDataAsesor($kelas),
            'data' => $this->masterSettingCertificateModel->getDataByClass($kelas),
            'tp' => $this->tp->findAll()
        ];
        if ($code) {
            $result = $this->masterSettingCertificateModel->insert($request);
            if ($result) {
                $this->session->setFlashdata("success", "tambah data berhasil!!!");
            } else {
                $this->session->setFlashdata("error", "Tambah data gaga!!!");
            }
            $this->session->destroy();
            return redirect()->to("/sertifikat/setting?kelas=" . $code);
        } else {
            return view("certificate/page/setting", $data);
        }
    }
}