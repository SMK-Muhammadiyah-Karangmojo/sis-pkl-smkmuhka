<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterSubLaporanModal extends Model
{
    protected $table = 'master_sub_laporan';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['text', 'master_laporan_id', 'major'];
}