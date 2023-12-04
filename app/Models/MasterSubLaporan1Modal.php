<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterSubLaporan1Modal extends Model
{
    protected $table = 'master_sub_laporan_1';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['text', 'master_sub_laporan_id', 'major'];
}