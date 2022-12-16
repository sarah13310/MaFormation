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

        return ['builder'=>$builder,
                'articles'=>$articles,
                ];
    }
}
