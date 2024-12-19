<?php
/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.github.io/
 */

namespace App\Models;

use CodeIgniter\Model;

class MasterNilaiModel extends Model
{
    protected $table = 'master_nilai';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['user_public_id', 'nilai_1', 'nilai_2', 'nilai_3', 'nilai_4', 'nilai_5', 'nilai_6', 'nilai_7', 'nilai_8', 'nilai_9', 'nilai_10', 'nilai_11'];

    public function findByMajorId(mixed $majorId): array
    {
        if ($majorId) {
            return $this->db->table("master_category_nilai")
                ->select("*")
                ->where("major", $majorId)
                ->get()->getResult();
        }
        return [];
    }

    public function findAllByUserPublicId($userPublicId): array
    {
        if ($userPublicId) {
            return $this->db->table('master_nilai')
                ->select('*')
                ->where('user_public_id', $userPublicId)
                ->get()->getResult();
        }
        return [];
    }

    public function findByUserPublicId(mixed $id)
    {
        if ($id) {
            return $this->db->table('master_nilai')
                ->select('*')
                ->where('user_public_id', $id)
                ->get()->getRow();
        }
        return [];
    }

    public function findALlByTpIdAndClassId($tp, $kelas)
    {
        return $this->db->table("master_nilai")
            ->select("master_nilai.*,
                            class.name as kelas,
                            tp.name as tpName,
                            ud.major_id,
                            ud.user_id as nis, 
                            ud.nisn,
                            ud.name")
            ->join("user_details ud", "master_nilai.user_public_id = ud.user_public_id")
            ->join("class", "ud.class_id = class.id")
            ->join("tp", "ud.tp_id = tp.id")
            ->where("ud.tp_id", $tp)
            ->where("ud.class_id", $kelas)
            ->get()->getResult();
    }
}