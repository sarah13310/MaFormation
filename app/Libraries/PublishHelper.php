<?php

namespace App\Libraries;

class PublishHelper
{
    function getPublishes()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('publication');
        $query   = $builder->get();
        $publishes = $query->getResultArray();
        return [
            'builder' => $builder,
            'publishes' => $publishes,
        ];
    }

    function getFilterPublishes($filter=VALIDE)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('publication');
        if ($filter!=ALL){
            $builder->where('status', $filter); 
        }
        $query   = $builder->get();
        $publishes = $query->getResultArray();
        return $publishes;
    }

    function isExist($subject)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('publication');
        $builder->where('subject', $subject);
        $query   = $builder->get();
        $items = $query->getResultArray();
        return (count($items) == 0) ? false : true;
    }
}
