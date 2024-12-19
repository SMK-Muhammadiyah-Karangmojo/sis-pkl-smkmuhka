<?php

namespace App\Models;

use CodeIgniter\Model;

class NomorSuratModel extends Model
{
    protected $table = 'nomor_surat';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['nomor', 'tanggal', 'detail_tanggal', 'tp_id', 'kategori_surat_id'];

    public function findAllBy(): array
    {
        return $this->db->table('nomor_surat')
            ->select('nomor_surat.id, nomor_surat.nomor, nomor_surat.tanggal,
            tp.id as tpId, tp.name as tpName,
            kategori_surat.name as kategori')
            ->join('tp', 'tp.id = nomor_surat.tp_id')
            ->join('kategori_surat', 'kategori_surat.id = nomor_surat.kategori_surat_id')
            ->where('nomor_surat.deleted_at', null)
            ->orderBy('id', 'DESC')
            ->get()->getResult();
    }

    public function findAllById($id)
    {
        return $this->db->table('nomor_surat')
            ->select('nomor_surat.id, nomor_surat.nomor, nomor_surat.tanggal,
            tp.id as tpId, tp.name as tpName,
            kategori_surat.id as categoryId,kategori_surat.name as kategori')
            ->join('tp', 'tp.id = nomor_surat.tp_id')
            ->join('kategori_surat', 'kategori_surat.id = nomor_surat.kategori_surat_id')
            ->where('nomor_surat.id', $id)
            ->where('nomor_surat.deleted_at', null)
            ->get()->getRow();
    }

    public function findByTp($tp)
    {
        return $this->db->table('nomor_surat')
            ->select('*')
            ->where('tp_id', $tp)
            ->get()->getRow();
    }

    public function findByTpAndCategory($tp, int $category)
    {
        return $this->db->table('nomor_surat')
            ->select('*')
            ->where('tp_id', $tp)
            ->where('kategori_surat_id', $category)
            ->get()->getRow();
    }
}