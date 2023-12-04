<?php

namespace App\Models;

use CodeIgniter\Model;

class DataLaporanSiswaModal extends Model
{
    protected $table = 'data_laporan_siswa';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'user_public_id', 'master_laporan_id',
        'master_sub_laporan_id', 'master_sub_laporan_1_id',
        'major_id', 'other', 'date'
    ];

    public function findByUserPublicId($id): array
    {
        return $this->db->query("
                select dls.id,
                       dls.date,
                       dls.other,
                       ml.name   as bidang_pekerjaan,
                       msl.text  as uraian_1,
                       msl1.text as uraian_2
                from data_laporan_siswa dls
                         inner join master_laporan ml
                                    on dls.master_laporan_id = ml.id
                         left join master_sub_laporan msl
                                    on dls.master_sub_laporan_id = msl.id
                         left join master_sub_laporan_1 msl1
                                   on dls.master_sub_laporan_1_id = msl1.id
                         inner join major m on dls.major_id = m.id
                where dls.user_public_id =  $id
                and dls.deleted_at is null
                order by dls.date ASC
        ")->getResult();
    }

    public function findAllByTeacherId($id): array
    {
        return $this->db->query("
               select md.id,
                       md.nis,
                       ud.user_public_id as userPublicId,
                       ud.name           as student,
                       i.name           as idukaName,
                       i.id              as idIduka,
                       t2.name           as tp,
                       m.name            as major,
                       dls.date,
                       ml.name           as bidang_ekerjaan,
                       msl.text          as uraina_1,
                       msl1.text         as uraian_2,
                       dls.other
                from master_data md
                         inner join tutor t
                                    on md.iduka_id = t.iduka_id
                         inner join iduka i
                                    on t.iduka_id = i.id
                         inner join user_details ud
                                    on md.user_public_id = ud.user_public_id
                         inner join tp t2 on md.tp_id = t2.id
                         inner join major m on t.major_id = m.id
                         left join data_laporan_siswa dls
                                   on md.user_public_id = dls.user_public_id
                         left join master_laporan ml
                                   on dls.master_laporan_id = ml.id
                         left join master_sub_laporan msl
                                   on dls.master_sub_laporan_id = msl.id
                         left join master_sub_laporan_1 msl1
                                   on dls.master_sub_laporan_1_id = msl1.id
                where t.deleted_at is null
                  and md.deleted_at is null
                  and t.teacher_id = $id
                order by t2.id DESC, i.name
        ")
            ->getResult();
    }

    public function findStudentReport($id): array
    {
        return $this->db()->query("
        select ud.user_public_id as id,
               ud.user_id        as nis,
               ud.name,
               i.name            as iduka
        from tutor
                 inner join iduka i on tutor.iduka_id = i.id
                 inner join master_data md on i.id = md.iduka_id
                 inner join user_details ud on md.user_public_id = ud.user_public_id
        where tutor.teacher_id = $id
        order by i.id
        ")->getResult();
    }
}