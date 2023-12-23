<?php

namespace App\Models;

use CodeIgniter\Model;

class SchoolModel extends Model
{
    protected $table = 'master_sekolah';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'npsn', 'address','phone', 'fax', 'akreditasi',
        'kepala_sekolah', 'nip', 'ttd'];
}