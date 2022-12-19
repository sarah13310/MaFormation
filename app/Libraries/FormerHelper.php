<?php
namespace App\Libraries;


class FormerHelper{

    function getFormers(){
        
        $db      = \Config\Database::connect();
        $builder = $db->table('user');        
        $builder->where('type', FORMER);
        $query   = $builder->get();
        return  ["formers"=>$query->getResultArray(), "builder"=>$builder];
    }
   
}