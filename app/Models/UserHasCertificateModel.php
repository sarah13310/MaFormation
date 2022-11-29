<?php

namespace App\Models;
use CodeIgniter\Model;

class UserHasCertificateModel extends Model
{
    protected $table = 'user_has_certificate';    
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id_user', 'id_certificate'];      
}