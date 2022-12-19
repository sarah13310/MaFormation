<?php
namespace App\Libraries;

class CategoryHelper{

    function getCategories(){  // On récupère toutes les catégories      
        $db      = \Config\Database::connect();
        $builder = $db->table('category');                
        $query   = $builder->get();
        return  $query->getResultArray();
    }
   
}