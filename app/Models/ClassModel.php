<?php
/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.github.io/
 */

namespace App\Models;

use CodeIgniter\Model;

class ClassModel extends Model
{
    protected $table = 'class';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'tp', 'is_active', 'major_id'];

    public function findAllByMajor($major): array
    {
        return $this->db->table('class')
            ->select('*')
            ->where('major_id', $major)
            ->get()->getResult();
    }

    public function findAllBy($getVar): array
    {
        return $this->db->table('class')
            ->select('*')
            ->where('is_active', 1)
            ->get()->getResult();
    }

    public function findByMajorId($majorId)
    {
        return $this->db->table('class')
            ->select('*')
            ->where('major_id', $majorId)
            ->get()->getRow();
    }

    public function findAllByIsActiveTrue()
    {
        return $this->db->table("master_nilai")
            ->distinct("class.id")
            ->select("class.id, class.name")
            ->join("user_details ud", "master_nilai.user_public_id = ud.user_public_id")
            ->join("class", "ud.class_id = class.id")
            ->join("tp", "ud.tp_id = tp.id")
            ->get()->getResult();
    }
}