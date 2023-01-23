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
        'image_url',
        'video_url'
    ];

    function add($post_data)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('page');
        $builder->insert($post_data);
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

    function getPageById($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('page');        
        $builder->where("id_page", $id);
        $query = $builder->get();
        return $query->getResultArray()[0];
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
