<?php

namespace App\Models;

use CodeIgniter\Model;

class CertificateModel extends Model
{
    protected $table = 'master_sertifikat';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['nis', 'nisn', 'name', 'kelas', 'nil_1',
        'nil_2', 'nil_3', 'nil_4', 'nil_5', 'nil_6', 'nil_7', 'nil_8', 'nil_9'];

    public function getDataSekolah()
    {
        return $this->db->table("master_sekolah")
            ->get()->getRow();
    }

    public function getDataAsesor($kelas)
    {
        return $this->db->table("master_assessor")
            ->where("kelas", $kelas)
            ->get()->getRow();
    }

    public function getDataSertifikat($kelas)
    {
        return $this->db->table("master_sertifikat")
            ->where("kelas", $kelas)
            ->get()->getResult();
    }

    public function updateMasterSekolah($id, $data)
    {
        return $this->db->table("master_sekolah")
            ->set("kepala_sekolah", $data['kepsek'])
            ->set("nip", $data['nip'])
            ->set("print_date", $data['print_date'])
            ->where("id", $id)
            ->update();
    }

    public function updateMasterAccessor($id, $data)
    {
        return $this->db->table("master_assessor")
            ->set("name_assessor", $data['accessor'])
            ->set("nopeg", $data['nopeg'])
            ->where("id", $id)
            ->update();
    }

    public function getMasterData($nisn)
    {
        return $this->db->table("master_sertifikat")
            ->where("nisn", $nisn)
            ->get()->getRow();
    }

    public function getNilai($kelas)
    {
        return $this->db->table("master_sertifikat")
            ->where("kelas", $kelas)
            ->get()->getResult();
    }
}