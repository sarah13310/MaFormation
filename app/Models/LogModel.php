<?php

namespace App\Models;

use CodeIgniter\Model;

class ArticleModel extends Model
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
