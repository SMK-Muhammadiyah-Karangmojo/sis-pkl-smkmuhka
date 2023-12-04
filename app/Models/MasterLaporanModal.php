<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterLaporanModal extends Model
{
    protected $table = 'master_laporan';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'major_id'];

    public function findAllByMajorId($majorId): array
    {
        return $this->db->query("
                SELECT id, name, major_id
                FROM master_laporan
                where deleted_at is null
                and major_id = $majorId
        ")->getResult();
    }

    public function findSubLaporanByMasterId($id): array
    {
        return $this->db->query("
            SELECT msl.id, msl.master_laporan_id, msl.text
            FROM master_laporan ml
            inner join master_sub_laporan msl
            ON ml.id = msl.master_laporan_id
            where ml.id = $id
        ")->getResult();
    }

    public function findSubLaporan1BySubLaporanId($id): array
    {
        return $this->db->query("
            SELECT msl1.id, msl1.text, msl1.major
            FROM master_sub_laporan msl
            inner join master_sub_laporan_1 msl1
            ON msl.id = msl1.master_sub_laporan_id
            where msl1.master_sub_laporan_id = $id
        ")->getResult();
    }
}