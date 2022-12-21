<?php

namespace App\Models;

use CodeIgniter\Model;

class UserHasArticleModel extends Model
{
    protected $table = 'user_has_article';

    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_user',
        'id_article',
    ];
}
