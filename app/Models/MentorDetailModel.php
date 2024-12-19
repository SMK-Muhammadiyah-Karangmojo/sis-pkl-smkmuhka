<?php

namespace App\Models;

use CodeIgniter\Model;

class MentorDetailModel extends Model
{
    protected $table = 'mentor_detail';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['iduka_id', 'tp_id', 'name', 'position', 'identity_number', 'hp', 'email'];

    public function findAllByMajorId(mixed $majorId): array
    {
        if (is_null($majorId)) {
            return $this->db->table('mentor_detail md')
                ->select('md.id, md.name,i.name as iduka,md.hp, md.email, md.position,
                                tp.name as tp')
                ->join('iduka i', 'i.id = md.iduka_id')
                ->join('tp', "tp.id = md.tp_id")
                ->join('major m', 'm.id = i.major_id')
                ->get()->getResult();
        }
        return $this->db->table('mentor_detail md')
            ->select('md.id, md.name,i.name as iduka,md.hp, md.email, md.position,
                                tp.name as tp')
            ->join('iduka i', 'i.id = md.iduka_id')
            ->join('tp', "tp.id = md.tp_id")
            ->join('major m', 'm.id = i.major_id')
            ->where('i.major_id', $majorId)
            ->get()->getResult();
    }

    public function findByIdukaIdAndTpId(mixed $idukaId, mixed $tpId)
    {
        return $this->db->table('mentor_detail mdtl')
            ->select('mdtl.*, i.id as idukaId, tp.pkl')
            ->join('iduka i', 'mdtl.iduka_id = i.id')
            ->join('tp', 'mdtl.tp_id = tp.id')
            ->where('tp.id', $tpId)
            ->where('mdtl.iduka_id', $idukaId)
            ->get()->getRow();
    }
}