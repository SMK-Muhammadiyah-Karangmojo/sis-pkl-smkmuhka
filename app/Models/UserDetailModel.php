<?php
/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.github.io/
 */

/**
 * The Admin Controller
 * @author  Eko Cahyanto
 * mail to: ekocahyanto007@gmail.com
 */

namespace App\Models;

use CodeIgniter\Model;

class UserDetailModel extends Model
{
    protected $table = 'user_details';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['user_id', 'nisn', 'name', 'tp_id', 'jk', 'class_id', 'major_id', 'user_public_id'];

    public function countCompleted(): array
    {
        return $this->db->table('users u')
            ->selectCount('ud.name', 'total')
            ->join('user_details ud', 'u.id = ud.user_public_id')
            ->join('major m', 'm.id = ud.major_id')
            ->join('class c', 'c.id = ud.class_id')
            ->join('master_data md', 'md.nis = ud.user_id')
            ->join('iduka i', 'i.id = md.iduka_id')
            ->join('tp', 'tp.id = md.tp_id')
            ->get()->getResult();
    }

    public function findById($id)
    {
        return $this->db->table('users u')
            ->select(
                'ud.name, ud.user_id as nis, ud.nisn, ud.tp_id as tpId,
                ud.jk,
                 m.id as majorId, m.name as major,
                c.id as classId, c.name as kelas,
                i.id as idukaId, i.name as iduka,
                tp.id as tpId, tp.name as tp
                ')
            ->join('user_details ud', 'u.id = ud.user_public_id')
            ->join('major m', 'm.id = ud.major_id', 'left')
            ->join('class c', 'c.id = ud.class_id', 'left')
            ->join('master_data md', 'md.nis = ud.user_id', 'left')
            ->join('iduka i', 'i.id = md.iduka_id', 'left')
            ->join('tp', 'tp.id = ud.tp_id', 'left')
            ->where('ud.id', $id)
            ->get()->getRow();
    }

    public function updateTeacher($id, $data): array
    {
        $userDetail = $this->db->table('user_details')
            ->set('user_id', $data['nbm'])
            ->where('user_public_id', $id)
            ->update();
        $teacher = $this->db->table('teacher')
            ->set('nbm', $data['nbm'])
            ->set('name', $data['name'])
            ->set('position', $data['position'])
            ->where('user_public_id', $id)
            ->update();

        return [
            'user_detail' => $userDetail,
            'teacher' => $teacher
        ];
    }

    public function findByUserPublicId($id)
    {
        return $this->db->table('users u')
            ->select(
                'ud.name, ud.user_id as nis, ud.nisn, ud.tp_id as tpId,
                ud.jk,
                 m.id as majorId, m.name as major,
                c.id as classId, c.name as kelas,
                i.id as idukaId, i.name as iduka,
                tp.id as tpId, tp.name as tp
                ')
            ->join('user_details ud', 'u.id = ud.user_public_id')
            ->join('major m', 'm.id = ud.major_id', 'LEFT')
            ->join('class c', 'c.id = ud.class_id', 'LEFT')
            ->join('master_data md', 'md.nis = ud.user_id', 'LEFT')
            ->join('iduka i', 'i.id = md.iduka_id', 'LEFT')
            ->join('tp', 'tp.id = ud.tp_id', 'LEFT')
            ->where('ud.user_public_id', $id)
            ->get()->getRow();
    }
}