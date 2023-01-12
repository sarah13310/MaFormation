<?php

namespace App\Libraries;

class BookHelper
{
    function getBooks()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('media');
        $builder->where('type', '2');
        $query   = $builder->get();
        $books = $query->getResultArray();
        return [
            'builder' => $builder,
            'books' => $books,
        ];
    }

    function getTitleAllBooks()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('media');
        $builder->where('type', '2');
        $query   = $builder->get();
        $books = $query->getResultArray();
        return $books;
    }

    function isExist($url)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('media');
        $builder->where('url', $url);
        $query   = $builder->get();
        $items = $query->getResultArray();
        return (count($items) == 0) ? false : true;
    }

}
