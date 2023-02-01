<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'id_category';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_category',
        'name'
    ];

    function getCategories()
    {  // On récupère toutes les catégories      
        $db      = \Config\Database::connect();
        $builder = $db->table('category');
        $query   = $builder->get();
        return  $query->getResultArray();
    }
}
