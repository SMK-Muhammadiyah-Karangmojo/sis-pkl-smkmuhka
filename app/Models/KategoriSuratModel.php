<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriSuratModel extends Model
{
    protected $table = 'kategori_surat';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name'];
}