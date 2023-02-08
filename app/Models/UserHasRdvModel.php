<?php

namespace App\Models;

use CodeIgniter\Model;

class UserHasRdvModel extends Model
{
    protected $table = 'user_has_rdv';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_user',
        'id_rdv',
    ];
}
