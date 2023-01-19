<?php

namespace App\Models;
use CodeIgniter\Model;

class ArticleModel extends Model
{
    protected $table = 'article';
    protected $primaryKey = 'id_article';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_article',
        'subject',
        'description',
        'image_url',
        'datetime',
        'media_id_media',
        'status',
        'id_tag',
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
    
    /**
     * getTitleAllArticles
     *
     * Retourne directement tous les articles disponibles
     * @return un tableau avec tous les articles
     * 
     */
    function getTitleAllArticles()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('article');
        $query   = $builder->get();
        $articles = $query->getResultArray();
        return $articles;
    }
    
    /**
     * getFilterArticles
     *
     * Récupère les articles en fonction du filtre 
     * @param  int $filter (valeur par défault VALIDE)
     * @return un tableau d'articles avec une gestion de filtre
     */
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
    
    /**
     * isExist
     *
     * Vérifie l'existence de l'article
     * @param  string $subject (sujet de l'article)
     * @return bool 
     * vrai => l'article existe déjà 
     * faux => l'article n'est pas présent dans la table
     */
    function isExist($subject)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('article');
        $builder->where('subject', $subject);
        $query   = $builder->get();
        $items = $query->getResultArray();
        return (count($items) == 0) ? false : true;
    }
    
    /**
     * deleteArticle
     *
     * Suppression de l'article
     * @param  int $id (identifiant de l'article)
     * @return void
     */
    function deleteArticle($id){
        $db = \Config\Database::connect();
        $builder = $db->table('article');
        $builder->where("id_article", $id);
        $builder->delete();
    }
}
