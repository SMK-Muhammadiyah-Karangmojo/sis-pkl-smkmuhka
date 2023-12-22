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

    public function findAllByDeletedAtNull(): array
    {
        $builder = $this->db->table("presence p");
        $builder->select("p.id, p.date, p.time_in, p.time_out, ud.name, c.name as class");
        $builder->join("user_details ud", "ud.user_public_id = p.users_id");
        $builder->join("class c", "c.id = ud.class_id");
        $builder->where("p.deleted_at", null);
        $builder->orderBy("p.date", "DESC");
        $builder->orderBy("p.time_in", "DESC");

        $sql = $builder->get();
        return $sql->getResult();
    }

    public function findByIdAndDeletedAtIsNull($id)
    {
        $builder = $this->db->table("presence p");
        $builder->select("p.id, p.date, p.time_in, p.time_out, p.location_in, p.location_out,
        p.image_in, p.image_out, ud.name, c.name as class");
        $builder->join("user_details ud", "ud.user_public_id = p.users_id");
        $builder->join("class c", "c.id = ud.class_id");
        $builder->where("p.id", $id);
        $builder->where("p.deleted_at", null);
        $builder->orderBy("p.date", "DESC");
        $builder->orderBy("p.time_in", "DESC");

        $sql = $builder->get();
        return $sql->getRow();
    }


}