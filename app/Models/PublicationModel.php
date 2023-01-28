<?php

namespace App\Models;

use CodeIgniter\Model;

class PublicationModel extends Model
{
    protected $table = 'publication';
    protected $primaryKey = 'id_publication';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_publication',
        'subject',
        'description',
        'image_url',
        'datetime',
        'status',
        'id_tag',
        'id_user',
    ];

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

    function getPublisheById($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('publication');
        $builder ->where("id_publication",$id);
        $query   = $builder->get();
        $publishes = $query->getResultArray();
        return $publishes[0];        
    }

    function getFilterPublishes($filter=ALL)
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

    function getFilterArticles($id_publication){
        $db = \Config\Database::connect();
        $builder = $db->table('publication_has_article');        
        $builder->select("article.* ");
        $builder->where('id_publication', $id_publication);   
        $builder->join("article", "article.id_article=publication_has_article.id_article");
        $query   = $builder->get();
        $articles = $query->getResultArray();
        return $articles;
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

    function deletePublishe($id){
        
        $db = \Config\Database::connect();
        $builder = $db->table('publication');
        $builder->where("id_publication", $id);
        $builder->delete();
    }
}
