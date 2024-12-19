<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterSettingCertificateUkkModel extends Model
{
    protected $table = 'master_setting_certificate_ukk';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['code', 'name', 'tp_id'];

    public function getDataByClass($kelas)
    {
        return $this->db->table("master_setting_certificate_ukk setting")
            ->select("setting.id, setting.code, setting.name, tp.name as tp")
            ->where("setting.code", $kelas)
            ->join("tp", "setting.tp_id = tp.id")
            ->orderBy("setting.id", "ASC")
            ->get()->getResult();
    }
}