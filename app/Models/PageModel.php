<?php

namespace App\Models;

use CodeIgniter\Model;

class PageModel extends Model
{
    protected $table = 'page';
    protected $primaryKey = 'id_page';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_page',
        'title',
        'content',
        'id_training',
        'image_url',
        'video_url'
    ];

    function modify($post_data)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('page');
       // var_dump($post_data[$this->primaryKey]);
        if (($post_data[$this->primaryKey]==='0') || (!isset($post_data[$this->primaryKey]))){
            //echo("insert");
            $builder->insert($post_data);            
        }
        else{
           // echo("update");
            $builder->where($this->primaryKey, $post_data[$this->primaryKey]);
            $builder->update($post_data);
        }
        return $db->insertID();
    }

    function getPageSession()
    {
        $data = [
            'id_training' => session()->get('id_training'),
            'title' => session()->get('title'),
            'description' => session()->get('description'),
            'date' => session()->get('date'),
            'rating' => session()->get('rating'),
        ];
        return $data;
    }

    function setPageSession($page)
    {
        $data = [
            'id_training' => $page['id_training'],
            'title' => $page['title'],
            'description' => $page['description'],
            'date' => $page['date'],
            'duration' => $page['duration'],
            'rating' => $page['rating'],
        ];
        session()->set($data);
    }

    /**
     * getPageById
     *
     * @param  int $id
     * @return array
     */
    function getPageById($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('page');
        $builder->where("id_page", $id);
        $query = $builder->get();
        return $query->getResultArray();
    }

    /**
     * getPages
     *
     * @param  int $id
     * on passe en argument l'id de formation
     * @return array
     * on récupère les pages associées à cet id formation
     */
    function getPages($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('page');
        $builder->where("id_training", $id);
        $query = $builder->get();
        return $query->getResultArray();
    }

    function getPageTitle($status = ALL)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('page');
        $builder->select("id_page, title");
        $query = $builder->get();
        return $query->getResultArray();
    }

    function getFilterPage($status = ALL, $limit = -1)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('page');
        if ($status != ALL) {
            $builder->where("status", $status);
        }
        if ($limit != -1) {
            $builder->limit($limit);
        }
        $query = $builder->get();
        return $query->getResultArray();
    }

    function isExist($title)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('page');
        $builder->where("title", $title);
        $query = $builder->get();
        return ($query->getResultArray() == null) ? false : true;
    }
}
