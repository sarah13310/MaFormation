<?php

namespace App\Libraries;

class ArticleHelper
{
    function getArticles()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('article');
        $query   = $builder->get();
        $articles = $query->getResultArray();
        return [
            'builder' => $builder,
            'articles' => $articles,
        ];
    }

    function getTitleAllArticles()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('article');
        $query   = $builder->get();
        $articles = $query->getResultArray();
        return $articles;
    }

    function getFilterArticles($filter = VALIDE)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('article');
        if ($filter!=ALL){
            $builder->where('status', $filter);
        }
        $query   = $builder->get();
        $articles = $query->getResultArray();
        return $articles;
    }

    function isExist($subject)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('article');
        $builder->where('subject', $subject);
        $query   = $builder->get();
        $items = $query->getResultArray();
        return (count($items) == 0) ? false : true;
    }
}