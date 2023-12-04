<?php
/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.github.io/
 */

namespace App\Models;

use CodeIgniter\Model;

class MasterCategoryNilaiModel extends Model
{
    protected $table = 'master_category_nilai';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'code', 'major', 'master_code_nilai_id'];

    public function findByMajorId($majorId): array
    {
        if ($majorId) {
            return $this->db->table("master_category_nilai")
                ->select("*")
                ->where("major", $majorId)
                ->orderBy("id", "ASC")
                ->get()->getResult();
        }
        return [];
    }

    public function findAllByMajorIdAndMasterCodeId(mixed $majorId, int $int): array
    {
        if ($majorId && $int) {
            return $this->db->table("master_category_nilai")
                ->select("*")
                ->where("major", $majorId)
                ->where('master_code_nilai_id', $int)
                ->get()->getResult();
        }
        return [];
    }
}