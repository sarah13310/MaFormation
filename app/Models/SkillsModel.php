<?php

namespace App\Models;
use CodeIgniter\Model;

class SkillsModel extends Model
{
    protected $table = 'skill';
    protected $allowedFields = ['id_user', 'skill_name'];
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    
}