<?php

namespace App\Models;

use CodeIgniter\Model;

class TpModel extends Model
{
    protected $table = 'tp';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name'];
}