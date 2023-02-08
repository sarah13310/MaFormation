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
    /**
     * getPublishes
     * 
     * Retourne indirectement tous les publications disponibles
     *
     * @return un tableau associatif à deux éléments
     * clef builder  =>permet d'utiliser en dehors le résultat de la requête
     * clef publishes =>retourne les publications
     */
    function getPublishes()
    {
        $builder = $this->db->table('publication');
        $query   = $builder->get();
        $publishes = $query->getResultArray();
        return [
            'builder' => $builder,
            'publishes' => $publishes,
        ];
    }
    /**
     * getPublisheById
     * 
     * Retourne indirectement tous les publications disponibles
     *
     * @return un tableau associatif à deux éléments
     * clef builder  =>permet d'utiliser en dehors le résultat de la requête
     * clef publishes =>retourne les publications
     */
    function getPublisheById($id)
    {        
        $builder = $this->db->table('publication');
        $builder->where("id_publication", $id);
        $query   = $builder->get();
        $publishes = $query->getResultArray();
        return $publishes[0];
    }
    /**
     * getFilterPublishes
     *
     * Récupère les publications en fonction du filtre 
     * @param  int $filter (valeur par défault VALIDE)
     * @return un tableau de publications avec une gestion de filtre
     */
    function getFilterPublishes($filter = ALL)
    {
        $builder = $this->db->table('publication');
        if ($filter != ALL) {
            $builder->where('status', $filter);
        }
        $query   = $builder->get();
        $publishes = $query->getResultArray();
        return $publishes;
    }
    /**
     * getArticlesByIdPublish
     *
     * Récupère les articles d'une publication
     * @param  int $id_publication (id de la publication)
     * @return un tableau d'articles
     */
    function getArticlesByIdPublish($id_publication)
    {
        $builder = $this->db->table('publication_has_article');
        $builder->select("article.* ");
        $builder->where('id_publication', $id_publication);
        $builder->join("article", "article.id_article=publication_has_article.id_article");
        $query   = $builder->get();
        $articles = $query->getResultArray();
        return $articles;
    }
    
    /**
     * getFilterPublishesArticles
     *
     * Récupère les articles associés à la publication 
     * @param  array $listpublishes
     * @param  int $id (id de l'utilisateur)
     * @return un tableau de articles avec une gestion de filtre
     */
    function getFilterPublishesArticles($listpublishes, $id = 0)
    {
        $builder = $this->db->table('publication');

        for ($i = 0; $i < count($listpublishes); $i++) {

            $builder->select('article.id_article,article.subject,article.description,article.datetime');
            $builder->where('publication.id_publication', $listpublishes[$i]['id_publication']);
            if ($id != 0) {
                $builder->where('publication.id_user',  $id);
            }
            $builder->join('publication_has_article', 'publication_has_article.id_publication = publication.id_publication');
            $builder->join('article', 'publication_has_article.id_article = article.id_article');
            $query = $builder->get();
            $articles = $query->getResultArray();

            $news = [];

            foreach ($articles as $article) {
                $news[] = [
                    "id_article" => $article['id_article'],
                    "subject" => $article['subject'],
                    "description" => $article['description'],
                    "datetime" => $article['datetime'],
                ];
            }
            $listpublishes[$i]["article"] = $news;
        }

        return $listpublishes;
    }

    /**
     * isExist
     *
     * Vérifie l'existence de la publication
     * @param  string $subject (sujet de la publication)
     * @return bool 
     * vrai => la publication existe déjà 
     * faux => la publication n'est pas présente dans la table
     */
    function isExist($subject)
    {
        $builder = $this->db->table('publication');
        $builder->where('subject', $subject);
        $query   = $builder->get();
        $items = $query->getResultArray();
        return (count($items) == 0) ? false : true;
    }
    /**
     * deletePublishe
     *
     * Suppression de la publication
     * @param  int $id (identifiant de la publication)
     * @return void
     */
    function deletePublishe($id)
    {
        $builder = $this->db->table('publication');
        $builder->where("id_publication", $id);
        $builder->delete();
    }
    /**
     * returnDataPublishes
     *
     * Retourne les données publicatons dans une liste
     * @param  array $list
     * @param  array $data
     * @return un tableau d'une liste de publicatons 
     */
    function MapPublishes($list, $data)
    {
        foreach ($data as $d) {
            $image_url = $d['image_url'];

            if ($image_url == null ) {
                $d['image_url'] = constant('DEFAULT_IMG_PUBLISHES');
            }
            $list[] = [
                "id_publication" => $d['id_publication'],
                "subject" => $d['subject'],
                "description" => $d['description'],
                "datetime" => $d['datetime'],
                "image_url" => $d['image_url'],
                "id_user" => $d['id_user'],
            ];
        }
        return $list;
    }

    /**
     * getAuthorsPublishes
     *
     * Récupère les noms des auteurs de toutes les publications dans une liste
     * @param  array $list
     * @return un tableau des noms des auteurs
     */
    function getAuthorsPublishes($list)
    {
        $builder = $this->db->table('user');
        $builder->select('user.name,user.firstname');

        for ($i = 0; $i < count($list); $i++) {

            $builder->where('user.id_user', $list[$i]['id_user']);
            $builder->groupBy('user.id_user');

            $query = $builder->get();
            $user = $query->getResultArray();

            $authors = [];
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
     * getAuthorPublishes
     *
     * Récupère le nom de l'auteur de cette publication
     * @param  int $id
     * @return le nom de l'auteur
     */
    function getAuthorPublishes($id)
    {
        $builder = $this->db->table('user');
        $builder->where('user.id_user', $id);
        $builder->groupBy('user.id_user');

        $query = $builder->get();
        $user = $query->getResultArray();

        $author = [];
        foreach ($user as $u) {
            $author[] = [
                "name" => $u['name'],
                "firstname" => $u['firstname'],
                "image_url" => $u['image_url'],
            ];
        }

        return $author;
    }

    /**
     * getPublishesbyAuthor
     *
     * Récupère les publications avec l'id de l'auteur
     * @param  int $id
     * @return la liste des publications
     */
    function getPublishesbyAuthor($id)
    {
        $builder = $this->db->table('publication');
        $builder->where('publication.id_user', $id);
        $builder->groupBy('publication.id_publication');
        $query   = $builder->get();
        $publishes = $query->getResultArray();

        return $publishes;
    }

}
