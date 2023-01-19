<?php

namespace App\Models;
use CodeIgniter\Model;

class UserHasTrainingModel extends Model
{
    protected $table = 'user_has_training';

    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['user_id_user', 'training_id_training'];
    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];
   
    
}