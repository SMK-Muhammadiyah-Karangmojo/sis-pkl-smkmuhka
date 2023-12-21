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
    protected $allowedFields = ['user_id', 'name', 'image', 'location', 'date', 'time_in', 'time_out'];



}