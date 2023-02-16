<?php

namespace App\Models;
use CodeIgniter\Model;
// le 05/02/2023
class CompanyModel extends Model
{
    protected $table = 'company';
    protected $primaryKey = 'id_company';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;   
    protected $allowedFields = ['id_company', 'name', 'address', 'city', 'cp','country','siret','kbis','user_id_user' ];
   
    
}