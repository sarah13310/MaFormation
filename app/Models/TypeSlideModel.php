<?php

namespace App\Models;
use CodeIgniter\Model;
// le 05/02/2023
class TypeSlideModel extends Model
{
    protected $table = 'type_slide';
    protected $primaryKey = 'id_typel';

    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['name'];
       
    
}