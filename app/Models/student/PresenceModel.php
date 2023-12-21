<?php
/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.my.id/
 */

namespace App\Models\student;

use CodeIgniter\Model;

class PresenceModel extends Model
{

    protected $table = 'presence';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['users_id', 'name', 'image_in', 'location_in', 'date', 'time_in', 'time_out',
        'location_out', 'image_out'];


    public function findByUserIdAndDate($userId, $today)
    {
        $builder = $this->db->table("presence");
        $builder->where("users_id", $userId);
        $builder->where("date", $today);
        $builder->where("deleted_at", null);
        $builder->orderBy("date", "DESC");
        $builder->orderBy("time_in", "DESC");

        $sql = $builder->get();
        return $sql->getRow();
    }

    public function findByUserIdAndDeletedAtIsNull($userId): array
    {
        $builder = $this->db->table("presence");
        $builder->where("users_id", $userId);
        $builder->where("deleted_at", null);
        $builder->orderBy("date", "DESC");
        $builder->orderBy("time_in", "DESC");

        $sql = $builder->get();
        return $sql->getResult();
    }


}