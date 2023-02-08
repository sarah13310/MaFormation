<?php

namespace App\Models;

use CodeIgniter\Model;

class UserHasTrainingModel extends Model
{
    protected $table = 'user_has_training';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_user',
        'id_training'
    ];

    public function getFormer($id_user)
    {
        $builder = $this->db->table('user_has_training');
        $builder->where('id_user', $id_user);
        $query   = $builder->get();
        return $query->getResultArray();
    }

    public function getTraining($id_training)
    {
        $builder = $this->db->table('user_has_training');
        $builder->where('id_training', $id_training);
        $query   = $builder->get();
        return $query->getResultArray();
    }
}
