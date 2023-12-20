<?php
/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.my.id/
 */

namespace App\Models\Template;

use CodeIgniter\Model;

class MasterTemplateModel extends Model
{

    protected $table = 'master_template';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['code', 'kategori_surat_id',
        'content', 'content_2', 'content_3', 'content_4', 'content_5',
        'hal', 'lampiran', 'nomor', 'tp_id', 'detail_tanggal'];

    public function findByCodeAndCategorySuratIdAndTpId($code, $kategori_surat_id, $tpId)
    {
        $builder = $this->db->table("master_template template");
        $builder->select("template.*, nomor.nomor as nomor_surat, nomor.tanggal");
        $builder->join("nomor_surat nomor", "template.kategori_surat_id = nomor.kategori_surat_id", "LEFT");
        $builder->where("template.tp_id", $tpId);
        $builder->where("template.code", $code);
        $builder->where("template.kategori_surat_id", $kategori_surat_id);
        $builder->where("template.deleted_at", null);

        $sql = $builder->get();

        return $sql->getRow();

    }

    public function findByCode($code)
    {
        $builder = $this->db->table("master_template template");
        $builder->where("template.code", $code);
        $builder->where("template.deleted_at", null);

        $sql = $builder->get();

        return $sql->getRow();
    }

}