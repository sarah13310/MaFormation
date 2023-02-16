<?php

namespace App\Models;

use CodeIgniter\Model;
// le 05/02/2023
class TagModel extends Model
{
    protected $table = 'tag';
    protected $primaryKey = 'id_tag';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_tag',
        'id_category',
    ];
}
