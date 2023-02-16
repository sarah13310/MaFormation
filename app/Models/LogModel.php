<?php

namespace App\Models;

use CodeIgniter\Model;
// le 05/02/2023
class LogModel extends Model
{
    protected $table = 'log';

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_user',
        'first_time',
        'last_time',
        'count_time',
        'status',
        
    ];
}
