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
        'type',
        'status',
        'id_tag'
    ];

    function getVideos()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('media');
        $builder->where('type', '1');
        $query   = $builder->get();
        $videos = $query->getResultArray();
        return [
            'builder' => $builder,
            'videos' => $videos,
        ];
    }

    function getTitleAllVideos()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('media');
        $builder->where('type', '1');
        $query   = $builder->get();
        $videos = $query->getResultArray();
        return $videos;
    }

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

    function returnDataMedias($list,$data)
    {
        foreach ($data as $d) {
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

    function ValidatedMedias($type)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('media');
        $builder->where('status', '1');
        $builder->where('type', $type);
        $query   = $builder->get();
        $medias = $query->getResultArray();
        return $medias;
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
