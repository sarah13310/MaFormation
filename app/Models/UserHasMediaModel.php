<?php

namespace App\Models;
use CodeIgniter\Model;

class UserHasMediaModel extends Model
{
    protected $table = 'user_has_media';    
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id_user', 'id_media'];      
}