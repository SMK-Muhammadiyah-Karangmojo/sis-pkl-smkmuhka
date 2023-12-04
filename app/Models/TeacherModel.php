<?php

namespace App\Models;

use CodeIgniter\Model;

class TeacherModel extends Model
{
    protected $table = 'teacher';
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'nbm', 'hp', 'position', 'user_public_id'];

    public function findByUserPublicId($teacherId)
    {
        return $this->db->table('teacher')
            ->select('*')
            ->where('user_public_id', $teacherId)
            ->get()->getRow();
    }

    public function findAllByUserPublicId($teacherId): array
    {
        return $this->db->query('
                select t.name, t.position, t.nbm, i.name as idukaName, i.id as idukaId
                from tutor
                         inner join teacher t on tutor.teacher_id = t.user_public_id
                         inner join iduka i on tutor.iduka_id = i.id
                where tutor.teacher_id =' . $teacherId
        )->getResult();
    }
}