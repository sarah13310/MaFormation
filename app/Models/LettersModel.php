<?php

namespace App\Models;
use CodeIgniter\Model;

class LettersModel extends Model
{
    protected $table = 'letters';
    protected $primaryKey = 'id_letter';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
   
    protected $allowedFields = ['id_letter', 'mail' ];
   
    
}