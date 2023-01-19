<?php

namespace App\Models;
use CodeIgniter\Model;

class TypeSlideModel extends Model
{
    protected $table = 'type_slide';
    protected $primaryKey = 'id_typel';

    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['name'];
    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    
    
}