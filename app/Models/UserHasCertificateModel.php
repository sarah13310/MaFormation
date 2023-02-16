<?php

namespace App\Models;
use CodeIgniter\Model;
// le 05/02/2023
class UserHasCertificateModel extends Model
{
    protected $table = 'user_has_certificate';    
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id_user', 'id_certificate'];      
}