<?php

namespace Tests\Support\Models;

use CodeIgniter\Model;
// le 27/02/2023

class ArticleModelTest extends Model
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
        $builder = $this->db->table('article');
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
    function getArticlesbyId($id)
    {
        $builder = $this->db->table('article');
        $builder->where('id_article', $id);
        $query   = $builder->get();
        $article = $query->getResultArray();
        $article = $article[0];
        return [
            'builder' => $builder,
            'article' => $article,
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
        $builder = $this->db->table('article');
        $query   = $builder->get();
        $articles = $query->getResultArray();
        return $articles;
    }

    /**
     * getFilterArticles
     *
     * Récupère les articles en fonction du filtre 
     * @param  int $filter (valeur par défault VALIDE)
     * @return un tableau d'articles avec une gestion de filtres multiples
     */
    function getFilterArticles($filter = VALIDE,  $limit = ALL, $orderby = NONE)
    {
        $builder = $this->db->table('article');
        if ($filter !== ALL) {
            $builder->where('status', $filter);
        }
        if ($limit !== ALL) {
            $builder->limit($limit);
        }
        if ($orderby !== NONE) {
            $builder->orderBy('datetime', $orderby);
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
        $builder = $this->db->table('article');
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
    function deleteArticle($id)
    {
        $builder = $this->db->table('article');
        $builder->where("id_article", $id);
        $builder->delete();
    }

    /**
     * returnDataArticles
     *
     * Retourne les données articles dans une liste
     * @param  array $list
     * @param  array $data
     * @return un tableau d'une liste d'articles 
     */
    function MapArticles($list, $data)
    {
        foreach ($data as $d) {
            if ($d['image_url'] == null) {
                $d['image_url'] = constant('DEFAULT_IMG_TRAINING');
            }
            $list[] = [
                "id_article" => $d['id_article'],
                "subject" => $d['subject'],
                "description" => $d['description'],
                "datetime" => $d['datetime'],
                "image_url" => $d['image_url'],
                "status" => $d['status'],
            ];
        }
        return $list;
    }

    /**
     * getAuthorsArticles
     *
     * Récupère les noms des auteurs de tout les articles dans une liste
     * @param  array $list
     * @param  $builder
     * @return un tableau des noms des auteurs
     */
    function getAuthorsArticles($list, $builder)
    {
        $builder->select('user.name,user.firstname');

        for ($i = 0; $i < count($list); $i++) {
            $builder->where('article.id_article', $list[$i]['id_article']);
            $builder->join('user_has_article', 'user_has_article.id_article = article.id_article');
            $builder->join('user', 'user_has_article.id_user = user.id_user');
            $query = $builder->get();
            $user = $query->getResultArray();
            
            $authors = [];
            if (count($user)==0){
                $authors[] = [
                    "name" => "non défini",
                    "firstname" => "",
                    "image_url" => constant('DEFAULT_IMG_TRAINING'),
                ];
            }
            
            foreach ($user as $u) {                
                $authors[] = [
                    "name" => $u['name'],
                    "firstname" => $u['firstname'],
                ];
            }
            $list[$i]["user"] = $authors;
        }

        return $list;
    }

    /**
     * getAuthorArticles
     *
     * Récupère le nom de l'auteur de cet article en fonction de l'id de l'article
     * @param  $builder
     * @param  int $id 
     * @return le nom de l'auteur
     */
    function getAuthorArticles($builder, $id)
    {
        $builder->where('article.id_article', $id);
        $builder->join('user_has_article', 'user_has_article.id_article = article.id_article');
        $builder->join('user', 'user_has_article.id_user = user.id_user');
        $query = $builder->get();
        $user = $query->getResultArray();
        
        if (count($user)==0){
            $author[] = [
                "name" => "non défini",
                "firstname" => "",
                "image_url" => constant('DEFAULT_IMG_TRAINING'),
            ];
        }
        $author = [];
        foreach ($user as $u) {
            if ($u['name']==null || strlen($u['name']<2)){
                $u['name']="non défini";
                $u['firstname']="";
            }
            $author[] = [
                "name" => $u['name'],
                "firstname" => $u['firstname'],
                "image_url" => $u['image_url'],
            ];
        }

        return $author;
    }

    /**
     * getArticlesbyAuthor
     *
     * Récupère les articles avec l'id de l'auteur
     * @param  $builder
     * @param  int $id
     * @return la liste des articles
     */
    function getArticlesbyAuthor($builder, $id)
    {
        $builder = $this->db->table('user');
        $builder->where("user.id_user", $id);
        $builder->join('user_has_article', 'user_has_article.id_user = user.id_user');
        $builder->join('article', 'user_has_article.id_article = article.id_article');
        $query   = $builder->get();
        $articles = $query->getResultArray();

        return $articles;
    }
}
