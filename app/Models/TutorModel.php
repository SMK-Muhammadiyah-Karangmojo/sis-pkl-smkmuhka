<?php

namespace App\Models;

use CodeIgniter\Model;

class TutorModel extends Model
{
    protected $table = 'tutor';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['tp_id', 'teacher_id', 'iduka_id', 'major_id'];

    public function findByTpAndMajor($tp, $major): array
    {
        if ($tp && $major) {
            $response = $this->db->table('tutor t')
                ->select('t.id, tp.name as tp, ud.user_id as nbm, ud.name, i.name as iduka')
                ->join('tp', 't.tp_id = tp.id')
                ->join('user_details as ud', 't.teacher_id = ud.user_public_id')
                ->join('iduka i', 'i.id = t.iduka_id')
                ->where('t.tp_id', $tp)
                ->where('t.major_id', $major)
                ->where('t.deleted_at', null)
                ->orderBy('ud.name', 'ASC')
                ->get()->getResult();
        } else {
            $response = $this->db->table('tutor t')
                ->select('t.id, tp.name as tp, ud.user_id as nbm, ud.name, i.name as iduka')
                ->join('tp', 't.tp_id = tp.id')
                ->join('user_details as ud', 't.teacher_id = ud.user_public_id')
                ->join('iduka i', 'i.id = t.iduka_id')
                ->where('t.deleted_at', null)
                ->orderBy('ud.name', 'ASC')
                ->get()->getResult();
        }
        return $response;
    }

    public function findAllBy(): array
    {
        return $this->db->table('tutor t')
            ->select('t.id, tp.name as tp, ud.user_id as nbm, ud.name, i.name as iduka')
            ->join('tp', 't.tp_id = tp.id')
            ->join('user_details as ud', 't.teacher_id = ud.user_public_id')
            ->join('iduka i', 'i.id = t.iduka_id')
            ->where('t.deleted_at', null)
            ->get()->getResult();
    }

    public function findById($id)
    {
        return $this->db->table('tutor t')
            ->select('t.id,
                            tp.id as tpId, tp.name as tp, 
                            ud.user_public_id as userId, ud.user_id as nbm, ud.name,
                            i.id as idIduka, i.name as iduka, i.major_id,
                            major.id as majorId, major.name as jurusan')
            ->join('tp', 't.tp_id = tp.id')
            ->join('user_details as ud', 't.teacher_id = ud.user_public_id')
            ->join('iduka i', 'i.id = t.iduka_id')
            ->join('major', 'major.id = t.major_id')
            ->where('t.id', $id)
            ->where('t.deleted_at', null)
            ->get()
            ->getRow();
    }

    public function findByTeacherId($id): array
    {
        $tp = $this->db->table("tp")->get()->getLastRow();
        return $this->db->query("
                select t.id,
                       tp.id             as tp_id,
                       ud.user_public_id as user_id,
                       ud.user_id        as nbm,
                       ud.name,
                       i.id              as id_iduka,
                       i.name            as iduka,
                       di.address
                from tutor t
                         inner join tp on t.tp_id = tp.id
                         inner join user_details ud on t.teacher_id = ud.user_public_id
                         inner join iduka i on t.iduka_id = i.id
                        inner join detail_iduka di on i.id = di.id_iduka
                where t.teacher_id = $id
                  and t.tp_id = " . $tp->id . "
                  and t.deleted_at is null
              ")->getResult();
    }

    public function findByTp($tp): array
    {

        return $this->db->table('tutor')
            ->distinct('teacher.name')
            ->select('tutor.iduka_id, teacher.name, teacher.nbm, teacher.user_public_id, teacher.position')
            ->join('teacher', 'teacher.user_public_id = tutor.teacher_id')
            ->where('tutor.tp_id', $tp)
            ->where('tutor.deleted_at', null)
            ->get()->getResult();
    }

    public function findByTeacherIdAndTp($teacherId, $tp)
    {
        return $this->db->table('tutor')
            ->select('tutor.iduka_id as id, teacher.name, teacher.nbm, teacher.user_public_id, teacher.position')
            ->join('teacher', 'teacher.user_public_id = tutor.teacher_id')
            ->where('tutor.tp_id', $tp)
            ->where('tutor.teacher_id', $teacherId)
            ->get()->getRow();
    }
}