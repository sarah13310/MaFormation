<?php

namespace App\Models;

use CodeIgniter\Model;
// le 05/02/2023
class RdvModel extends Model
{
    protected $table = 'rdv';
    protected $primaryKey = 'id_rdv';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_training',       
        'dateStart',
        'dateEnd',       
        'id_user'
    ];
   
}
