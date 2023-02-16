<?php

namespace App\Models;
use CodeIgniter\Model;
// le 05/02/2023
class CategoryHasMediaModel extends Model
{
    protected $table = 'category_has_media';
    protected $allowedFields = ['id_category', 'name', 'id_user', 'id_media'];
    
}