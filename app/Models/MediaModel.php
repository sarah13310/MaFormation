<?php

namespace App\Models;

use CodeIgniter\Model;

class MediaModel extends Model
{
    protected $table = 'media';
    protected $primaryKey = 'id_media';

    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'name',
        'description',
        'author',
        'url',
        'image_url',
        'type',
        'status',
        'id_tag'
    ];

    /**
     * getVideos
     * 
     * Retourne indirectement toutes les vidéos disponibles
     *
     * @return un tableau associatif à deux éléments
     * clef builder  =>permet d'utiliser en dehors le résultat de la requête
     * clef books =>retourne les vidéos
     */
    function getVideos()
    {
        $builder = $this->db->table('media');
        $builder->where('type', VIDEO);
        $query   = $builder->get();
        $videos = $query->getResultArray();
        return [
            'builder' => $builder,
            'videos' => $videos,
        ];
    }

    /**
     * getTitleAllVideos
     * 
     * Retourne indirectement toutes les vidéos disponibles
     *
     * @return un tableau de vidéos
     */
    function getTitleAllVideos()
    {
        $builder = $this->db->table('media');
        $builder->where('type', VIDEO);
        $query   = $builder->get();
        $videos = $query->getResultArray();
        return $videos;
    }

    /**
     * getBooks
     * 
     * Retourne indirectement tous les livres disponibles
     *
     * @return un tableau associatif à deux éléments
     * clef builder  =>permet d'utiliser en dehors le résultat de la requête
     * clef books =>retourne les livres
     */
    function getBooks()
    {
        $builder = $this->db->table('media');
        $builder->where('type', BOOK);
        $query   = $builder->get();
        $books = $query->getResultArray();
        return [
            'builder' => $builder,
            'books' => $books,
        ];
    }

    /**
     * getTitleAllBooks
     * 
     * Retourne indirectement tous les livres disponibles
     *
     * @return un tableau de livres
     */
    function getTitleAllBooks()
    {
        $builder = $this->db->table('media');
        $builder->where('type', BOOK);
        $query   = $builder->get();
        $books = $query->getResultArray();
        return $books;
    }

    /**
     * returnDataMedias
     *
     * Retourne les données médias dans une liste
     * @param  array $list
     * @param  array $data
     * @return un tableau d'une liste de médias 
     */
    function returnDataMedias($list,$data)
    {
        foreach ($data as $d) {
            if($d['image_url']==null || $d['image_url']=""){
                if ($d['type']==BOOK){
                    $d['image_url']=constant('DEFAULT_IMG_BOOK');
                }
                if ($d['type']==VIDEO){
                    $d['image_url']=constant('DEFAULT_IMG_VIDEO');
                }
            }
            $list[] = [
                "id_media" => $d['id_media'],
                "name" => $d['name'],
                "description" => $d['description'],
                "author" => $d['author'],
                "url" => $d['url'],
                "image_url" => $d['image_url'],
            ];
        }
        return $list;
    }

    /**
     * getAuthorsMedias
     *
     * Récupère les noms des auteurs de tout les médias dans une liste
     * @param  array $list
     * @param  $builder
     * @return un tableau des noms des auteurs
     */
    function getAuthorsMedias($list,$builder)
    {
        $builder->select('user.name,user.firstname');

        for ($i = 0; $i < count($list); $i++) {
            $builder->where('media.id_media', $list[$i]['id_media']);
            $builder->join('user_has_media', 'user_has_media.id_media = media.id_media');
            $builder->join('user', 'user_has_media.id_user = user.id_user');
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
     * getAuthorMedias
     *
     * Récupère le nom de l'auteur de ce média
     * @param  int $session (utilisateur connecté)
     * @param  $builder
     * @param  int $type (type du média)
     * @return le nom de l'auteur
     */
    function getAuthorMedias($session,$builder,$type)
    {
        $builder->where("user.id_user", $session['id_user']);
        $builder->join('user_has_media', 'user_has_media.id_user = user.id_user');
        $builder->join('media', 'user_has_media.id_media = media.id_media');
        $builder->where('media.type', $type);
        $query   = $builder->get();
        $medias = $query->getResultArray();
        return $medias;
    }       

    /**
     * ValidatedMedias
     *
     * Récupère les médias validés
     * @param  int $type (type du média)
     * @return un tableau de médias
     */
    function ValidatedMedias($type)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('media');
        $builder->where('status', VALIDE);
        $builder->where('type', $type);
        $query   = $builder->get();
        $medias = $query->getResultArray();
        return $medias;
    }

    /**
     * isExist
     *
     * Vérifie l'existence du média
     * @param  string $url (url du média)
     * @return bool 
     * vrai => le média existe déjà 
     * faux => le média n'est pas présent dans la table
     */
    function isExist($url)
    {
        $builder = $this->db->table('media');
        $builder->where('url', $url);
        $query   = $builder->get();
        $items = $query->getResultArray();
        return (count($items) == 0) ? false : true;
    }


}
