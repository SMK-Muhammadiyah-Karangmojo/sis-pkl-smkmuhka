<?php
/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.github.io/
 */

namespace App\Models;

use CodeIgniter\Model;

class MasterDataModel extends Model
{
    protected $table = 'master_data';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['user_public_id', 'nis', 'iduka_id', 'tp_id', 'status', 'image'];

    public function findByNis($nis)
    {
        return $this->db->table('master_data')
            ->select('*')
            ->where('nis', $nis)
            ->get();
    }

    public function findByIdukaAndTp($iduka, $tp): array
    {
        return $this->db->query('
                select ud.name    as name,
                       ud.user_id as nis,
                       i.name     as iduka,
                       ud.jk,
                       m.name     as jurusan,
                       c.name     as kelas,
                       di.address as alamat
                from master_data md
                        inner join user_details as ud on md.nis = ud.user_id
                        inner join iduka i on md.iduka_id = i.id
                        inner join major m on i.major_id = m.id
                        inner join class c on ud.class_id = c.id
                        left join detail_iduka di on di.id_iduka = i.id
                where md.deleted_at is null 
                    and md.user_public_id is not null
                    and md.iduka_id = ' . $iduka . ' 
                    and md.tp_id = ' . $tp
        )->getResult();
    }

    public function updateByNis($nis, $id): bool
    {
        return $this->db->query('
                update master_data
                set iduka_id = ' . $id . ',
                    status   = null
                where nis = ' . $nis
        )->getRow();
    }

    public function updateByDataNis($nis, array $data): bool
    {
        return $this->db->table('master_data')
            ->set('user_public_id', $data['id'])
            ->set('tp_id', $data['tpId'])
            ->where('nis', $nis)
            ->update();
    }

    public function findByTpAndMajor($tp, $major): array
    {
        $builder = $this->db->table('master_data md');
        $builder->select('
                            md.id, md.status, ud.name, i.id as idukaId, i.name as idukaName,
                            ud.user_id as nis, ud.jk, class.name as kelas, m.name as majorName,
                            di.address, tp.name as tpName, teacher.name as teacherName, teacher.hp, surat.detail_tgl');
        $builder->join('tp', 'tp.id = md.tp_id');
        $builder->join('iduka i', 'i.id = md.iduka_id');
        $builder->join('detail_iduka di', 'di.id_iduka = i.id', 'left');
        $builder->join('major m', 'm.id = i.major_id');
        $builder->join('user_details ud', 'ud.user_public_id = md.user_public_id');
        $builder->join('class', 'class.id = ud.class_id', 'left');
        $builder->join('tutor', 'tutor.iduka_id = i.id', 'left');
        $builder->join('teacher', 'teacher.user_public_id = tutor.teacher_id', 'left');
        $builder->join('tbl_surat surat', 'surat.id_tp = md.tp_id', 'left');
        $builder->where('tutor.deleted_at', null);
        if ($tp && $major) {
            $builder->where('md.tp_id', $tp);
            $builder->where('m.id', $major);
        }
        $builder->orderBy('i.name', 'ASC');
        $builder->orderBy('ud.user_id', 'ASC');

        $sql = $builder->get();
        return $sql->getResult();
    }

    public function findById($id)
    {
        return $this->db->table('master_data md')
            ->select('md.id, md.image,
                            ud.name, ud.user_id as nis,
                            i.name as iduka,
                            di.address')
            ->join('user_details ud', 'ud.user_public_id = md.user_public_id')
            ->join('iduka i', 'i.id = md.iduka_id')
            ->join('detail_iduka di', 'di.id_iduka = md.iduka_id')
            ->where('md.id', $id)
            ->get()->getRow();
    }

    public function findByUserPublicId($id)
    {
        return $this->db->table('master_data md')
            ->select('md.id, md.image, md.status,
                            ud.name, ud.user_id as nis,
                            i.name as iduka,
                            di.address,
                            teacher.name as teacher, teacher.hp')
            ->join('user_details ud', 'ud.user_public_id = md.user_public_id')
            ->join('iduka i', 'i.id = md.iduka_id')
            ->join('detail_iduka di', 'di.id_iduka = md.iduka_id')
            ->join('tutor', 'tutor.iduka_id = i.id', 'left')
            ->join('teacher', 'teacher.user_public_id = tutor.teacher_id', 'left')
            ->where('md.user_public_id', $id)
            ->get()->getRow();
    }

    public function findByTp($tp): array
    {
        return $this->db->query('
                select distinct md.iduka_id,
                                md.iduka_id as id,
                                i.name,
                                i.major_id,
                                di.address
                from master_data md
                        inner join iduka i on md.iduka_id = i.id
                        inner join detail_iduka di on i.id = di.id_iduka
                where md.deleted_at is null
                  and md.user_public_id is not null
                  and md.tp_id = ' . $tp . '
                order by i.major_id ASC
        ')->getResult();
    }

    public function findIdukaByTpAndMajor($tp, $major): array
    {
        return $this->db->query('
                select distinct md.iduka_id, i.name as idukaName, di.address, t.name as tpName
                from master_data md
                         inner join iduka i on md.iduka_id = i.id
                         inner join detail_iduka di on md.iduka_id = di.id_iduka
                         inner join tp t on md.tp_id = t.id
                where i.major_id = ' . $major . '
                  and md.tp_id = ' . $tp . '
                order by i.name
        ')->getResult();
    }

    public function findByTeacherId($id): array
    {
        return $this->db->query("
        select md.id,
               md.nis,
               ud.name,
               t2.name as tp,
               t2.id   as tpId,
               di.address
        from master_data md
                 inner join tutor t on md.iduka_id = t.iduka_id
                 inner join iduka i on t.iduka_id = i.id
                 inner join detail_iduka di on md.iduka_id = di.id
                 inner join user_details ud on md.user_public_id = ud.user_public_id
                 inner join tp t2 on md.tp_id = t2.id
        where t.deleted_at is null
          and md.deleted_at is null
          and t.teacher_id = $id
        order by i.name asc
        ")->getResult();
    }

    public function findAllStudent(): array
    {
        return $this->db->table("master_data md")
            ->select("md.id, ud.user_id as nis, ud.name, m.name as major,m.id as majorId,
             i.name as iduka,i.id as idukaId, mdtl.id as ids, mdtl.name as mentor, tp.name as tp, tp.id as tpId")
            ->join("users u", "md.user_public_id = u.id")
            ->join("user_details ud", "u.id = ud.user_public_id")
            ->join("major m", "ud.major_id = m.id")
            ->join("iduka i", "md.iduka_id = i.id")
            ->join("detail_iduka di", "i.id = di.id_iduka")
            ->join("tp", "md.tp_id = tp.id")
            ->join("mentor_detail mdtl", "md.tp_id = mdtl.tp_id and md.iduka_id = mdtl.iduka_id", "LEFT")
            ->where("u.role_pkl", 3)
            ->orderBy("md.tp_id", "DESC")
            ->orderBy("i.id")
            ->get()->getResult();
    }

    public function findAllStudentByTpAndMajor(mixed $tpInput, mixed $majorInput): array
    {
        return $this->db->table("master_data md")
            ->select("md.id, ud.user_id as nis, ud.name, m.name as major,m.id as majorId,
            i.name as iduka, i.id as idukaId, mdtl.id as ids, mdtl.name as mentor, tp.name as tp, tp.id as tpId")
            ->join("users u", "md.user_public_id = u.id")
            ->join("user_details ud", "u.id = ud.user_public_id")
            ->join("major m", "ud.major_id = m.id")
            ->join("iduka i", "md.iduka_id = i.id")
            ->join("detail_iduka di", "i.id = di.id_iduka")
            ->join("tp", "md.tp_id = tp.id")
            ->join("mentor_detail mdtl", "md.tp_id = mdtl.tp_id and md.iduka_id = mdtl.iduka_id", "LEFT")
            ->where("u.role_pkl", 3)
            ->where("tp.id", $tpInput)
            ->where("m.id", $majorInput)
            ->orderBy("md.tp_id", "DESC")
            ->orderBy("i.id")
            ->get()->getResult();
    }

    public function findStudentById(mixed $id)
    {
        return $this->db->table("master_data md")
            ->select("md.id, ud.user_id as nis, ud.name,
                            m.name as major, m.id as majorId, m.code as code,
                            i.id as idukaId, i.name as iduka,
                            mdtl.name as mentor,
                            tp.id as tpId, tp.name as tp,
                            di.address, u.id as userPublicId")
            ->join("users u", "md.user_public_id = u.id")
            ->join("user_details ud", "u.id = ud.user_public_id")
            ->join("major m", "ud.major_id = m.id")
            ->join("iduka i", "md.iduka_id = i.id")
            ->join("detail_iduka di", "i.id = di.id_iduka")
            ->join("tp", "md.tp_id = tp.id")
            ->join("mentor_detail mdtl", "md.tp_id = mdtl.tp_id and md.iduka_id = mdtl.iduka_id", "LEFT")
            ->where("md.id", $id)
            ->get()->getRow();
    }

    public function findByUserNis($id)
    {
        return $this->db->table('master_data md')
            ->select('md.id, md.image, md.status,
                            ud.name, ud.user_id as nis,
                            i.name as iduka,
                            di.address,
                            teacher.name as teacher, teacher.hp')
            ->join('user_details ud', 'ud.user_public_id = md.user_public_id')
            ->join('iduka i', 'i.id = md.iduka_id')
            ->join('detail_iduka di', 'di.id_iduka = md.iduka_id')
            ->join('tutor', 'tutor.iduka_id = i.id', 'left')
            ->join('teacher', 'teacher.user_public_id = tutor.teacher_id', 'left')
            ->where('md.nis', $id)
            ->get()->getRow();
    }
}