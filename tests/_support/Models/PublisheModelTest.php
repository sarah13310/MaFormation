<?php

namespace Tests\Support\Models;

use CodeIgniter\Model;
// le 27/02/2023

class PublisheModelTest extends Model
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
    /**
     * getArticles
     * 
     * Retourne indirectement tous les articles disponibles
     *
     * @return un tableau associatif à deux éléments
     * clef builder  =>permet d'utiliser en dehors le résultat de la requête
     * clef articles =>retourne les articles
     */
    function getPublishes()
    {
        $builder = $this->db->table('publication');
        $query   = $builder->get();
        $articles = $query->getResultArray();
        return [
            'builder' => $builder,
            'articles' => $articles,
        ];
    }

    /**
     * getArticlesbyId
     * 
     * Retourne indirectement tous les articles disponibles
     *
     * @return un tableau associatif à deux éléments
     * clef builder  =>permet d'utiliser en dehors le résultat de la requête
     * clef articles =>retourne les articles
     */
    function getPublishebyId($id)
    {
        $builder = $this->db->table('publication');
        $builder->where('id_publication', $id);
        $query   = $builder->get();
        $article = $query->getResultArray();
        $article = $article[0];
        return [
            'builder' => $builder,
            'article' => $article,
        ];
    }

    
}
