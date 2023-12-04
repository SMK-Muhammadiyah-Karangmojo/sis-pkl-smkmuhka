<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratModel extends Model
{
    protected $table = 'tbl_surat';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'nomor', 'lampiran', 'hal', 'detail_tgl', 'p1',
        'p2', 'p3', 'p4', 'p5', 'p6', 'tgl_surat', 'kepala_sekolah',
        'nbm', 'id_tp'];

    public function findByTp($tp)
    {
        return $this->db->table('tbl_surat')
            ->select('*')
            ->where('id_tp', $tp)
            ->get();
    }
}