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

class UsersModel extends Model
{
    protected $table = 'users';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['email', 'image', 'password', 'role_pkl', 'is_active'];

    public function findUserDetailByEmail($email)
    {
        return $this->db->table('users as u')
            ->select('u.id as id, u.email, u.password, u.role_pkl, u.is_active, u.image,
                            ud.id as ids, ud.name, ud.user_id as nis, ud.major_id,
                            ud.nisn, ud.jk, tp.id as idTp, tp.name as tp,
                            c.name as class, c.id as classId')
            ->join('user_details as ud', 'u.id = ud.user_public_id')
            ->join('tp', 'tp.id = ud.tp_id')
            ->join('class c', 'c.id = ud.class_id')
            ->where('u.email', $email)
            ->get();
    }

    public function findAllSiswa(): array
    {
        return $this->db->query('
                    select ud.id,
                           ud.name,
                           ud.jk,
                           ud.user_id as nis,
                           c.name   as kelas,
                           m.name   as jurusan,
                           i.name   as iduka,
                           t.name as tp,
                           md.id as masterDataId
                    from users u
                             inner join user_details ud on u.id = ud.user_public_id
                             inner join class c on ud.class_id = c.id
                             inner join major m on ud.major_id = m.id
                             left join master_data md on md.nis = ud.user_id
                             left join iduka i on i.id = md.iduka_id
                             inner join tp t on t.id = ud.tp_id
                    where u.role_pkl = 3;
        ')->getResult();
    }

    public function findAllSiswaByMajor($major): array
    {
        if (!$major) {
            return [];
        }
        return $this->db->query('
                    select ud.id,
                           ud.name,
                           ud.jk,
                           ud.user_id as nis,
                           c.name   as kelas,
                           m.name   as jurusan,
                           i.name   as iduka,
                           t.name as tp,
                           md.id as masterDataId
                    from users u
                             inner join user_details ud on u.id = ud.user_public_id
                             inner join class c on ud.class_id = c.id
                             inner join major m on ud.major_id = m.id
                             left join master_data md on md.nis = ud.user_id
                             left join iduka i on i.id = md.iduka_id
                             inner join tp t on t.id = ud.tp_id
                    where u.role_pkl = 3 and ud.major_id =' . $major
        )->getResult();
    }

    public function findAllTeacher(): array
    {
        return $this->db->table('users u')
            ->select('u.id,
                       u.email,
                       u.image,
                       ud.id as userDetailId,
                       t.name,
                       t.nbm, t.hp, t.position')
            ->join('user_details ud', 'u.id = ud.user_public_id')
            ->join('teacher t', 'u.id = t.user_public_id')
            ->where('u.role_pkl', 2)
            ->orderBy('t.name', 'ASC')
            ->get()->getResult();
    }

    public function findAllStudent(): array
    {
        return $this->db->table('users u')
            ->select('u.id,
                            u.email, 
                            ud.id as userDetailId, ud.name, ud.user_id as nis, ud.nisn,
                            ud.jk,
                            c.id as classId, c.name as kelas,
                            m.id as majorId, m.name as jurusan,
                            tp.name as tp, tp.id as tpId')
            ->join('user_details ud', 'u.id = ud.user_public_id')
            ->join('class c', 'c.id = ud.class_id', 'left')
            ->join('major m', 'm.id = ud.major_id', 'left')
            ->join('tp', 'tp.id = ud.tp_id', 'left')
            ->where('u.role_pkl', 3)
            ->orderBy('ud.name', 'ASC')
            ->get()->getResult();
    }

    public function findTeacherById($id)
    {
        return $this->db->table('users u')
            ->select('u.id, u.email, u.image,
                       ud.id as ids, t.name,
                       t.nbm, t.hp, t.position')
            ->join('user_details ud', 'u.id = ud.user_public_id')
            ->join('teacher t', 'u.id = t.user_public_id')
            ->where('u.role_pkl', 2)
            ->where('u.id', $id)
            ->orderBy('t.name', 'ASC')
            ->get()->getRow();
    }

    public function findAllByDetail(): array
    {
        return $this->db->table('users u')
            ->select('u.id as id, u.email, u.role_pkl, ud.name, ur.name as role')
            ->join('user_details ud', 'u.id = ud.user_public_id')
            ->join('user_role ur', 'ur.id = u.role_pkl', 'left')
            ->whereNotIn('u.role_pkl', [1])
            ->orderBy('ud.name', 'ASC')
            ->get()->getResult();
    }

    public function findTeacherDetailByEmail($email)
    {
        return $this->db->table('users as u')
            ->select('u.id as id, u.email, u.password, u.role_pkl, u.is_active, u.image,
                            ud.id as ids, ud.name, ud.jk')
            ->join('user_details as ud', 'u.id = ud.user_public_id', 'left')
            ->where('u.email', $email)
            ->get();
    }

    public function findAllSiswaByMajorAndTpId($majorId, $tp, $iduka): array
    {
        if (!$majorId && !$tp && $iduka) {
            return [];
        }
        return $this->db->table("users u")
            ->select("u.id as userPublicId,
                           ud.name,
                           ud.jk,
                           ud.user_id as nis,
                           c.name   as kelas,
                           m.name   as jurusan,
                           i.name   as iduka,
                           t.name as tp,
                           md.id as masterDataId,
                           mn.*")
            ->join("user_details ud", "u.id = ud.user_public_id")
            ->join("class c", "ud.class_id = c.id")
            ->join("major m", "ud.major_id = m.id")
            ->join("master_data md", "md.nis = ud.user_id", "LEFT")
            ->join("iduka i", "i.id = md.iduka_id", "LEFT")
            ->join("tp t", "t.id = ud.tp_id")
            ->join("master_nilai mn", "u.id = mn.user_public_id", "LEFT")
            ->where("u.role_pkl", 3)
            ->where("ud.major_id", $majorId)
            ->where("ud.tp_id", $tp)
            ->where("i.id", $iduka)
            ->get()->getResult();

    }

}