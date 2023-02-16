<?php

namespace App\Models;

use CodeIgniter\Model;
// le 05/02/2023
class UserHasUserModel extends Model
{
    protected $table = 'user_has_user';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_former',
        'id_user',
    ];
}
