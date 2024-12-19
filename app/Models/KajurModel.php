<?php

namespace App\Models;

use CodeIgniter\Model;

class KajurModel extends Model
{
    protected $table = 'tbl_kajur';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_user', 'major'];

    public function findByTp($tp)
    {
        return $this->db->table('tbl_surat')
            ->select('*')
            ->where('id_tp', $tp)
            ->get();
    }

    public function findByMajor($major)
    {
        return $this->db->query('
                select ud.name, ud.user_id as nbm
                from tbl_kajur as k
                left join user_details as ud on k.id_user = ud.user_public_id
                where k.major =' . $major);
    }
}