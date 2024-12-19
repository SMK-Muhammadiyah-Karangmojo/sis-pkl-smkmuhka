<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailIdukaModel extends Model
{
    protected $table = 'detail_iduka';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id_iduka', 'name', 'address', 'email', 'telp', 'mentor', 'nip', 'position', 'email_mentor', 'hp_mentor', 'tp'];

    public function findByIdIduka($id)
    {
        return $this->db->table('detail_iduka')
            ->select('*')
            ->where('id_iduka', $id)
            ->get()->getRow();
    }

    public function updateByIdIduka($id, $address): bool
    {
        return $this->db->table('detail_iduka')
            ->set('address', $address)
            ->where('id_iduka', $id)
            ->update();
    }
}