<?php

namespace App\Models;

use CodeIgniter\Model;
// le 05/02/2023
class TagModel extends Model
{
    protected $table = 'tag';
    protected $primaryKey = 'id_tag';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_tag',
        'id_category',
    ];

    /**
     * getTagName
     *
     * @param  mixed $data
     * @return void
     */
    function getTagName($data)
    {

        $builder = $this->db->table('tag');

        $category = [];

        for ($i = 0; $i < count($data); $i++) {
            $category = [];
            $builder->where('id_tag', $data[$i]['id_tag']);
            $builder->join('category', 'category.id_category = tag.id_category');
            $query = $builder->get();
            $tag = $query->getResultArray();

            foreach ($tag as $t) {
                $category[] = [
                    "name" => $t['name'],
                ];
            }
            $data[$i]['tag'] = $category;
            // var_dump($category);
        }
        //die();
        return $data;
    }

    /**
     * FilterTag
     *
     * @param  mixed $data
     * @return void
     */
    function FilterTag($data)
    {
        $category = [];
        
        for ($i = 0; $i < count($data); $i++) {
            
                $tag = $data[$i]['tag'][0]['name'];
                $category[] = ["name" => $tag];
            
        }
        $category = array_unique($category, SORT_REGULAR);
        return $category;
    }

    /**
     * FilterAuthor
     *
     * @param  mixed $data
     * @return void
     */
    function FilterAuthor($data)
    {
        foreach ($data as $d) {
            $list[] = [
                "author" => $d['author'],
            ];
        }

        $author = array_unique($list, SORT_REGULAR);
        return $author;
    }

    /**
     * FilterDistributor
     *
     * C'est le filtre utilisateur formateur/adminitrateur qui diffuse un article/ une publication / une vidéo /un livre
     * @param  mixed $data
     * @return void
     */
    function FilterDistributor($data)
    {
        $distributor = [];

        for ($i = 0; $i < count($data); $i++) {
            $user_name = $data[$i]['user'][0]['name'];
            $user_firstname = $data[$i]['user'][0]['firstname'];
            $distributor[] = [
                "name" => $user_name,
                "firstname" => $user_firstname,
            ];
        }

        $distributor = array_unique($distributor, SORT_REGULAR);
        return $distributor;
    }

    /**
     * FilterFormer
     *
     * 
     * @param  mixed $data
     * @return void
     */
    function FilterFormer($data)
    {
        $former = [];

        for ($i = 0; $i < count($data); $i++) {
            $user_name = $data[$i]['name'];
            $user_firstname = $data[$i]['firstname'];
            $former[] = [
                "name" => $user_name,
                "firstname" => $user_firstname,
            ];
        }

        $former = array_unique($former, SORT_REGULAR);
        return $former;
    }

    /**
     * FilterCity
     *
     * @param  mixed $data
     * @return void
     */
    function FilterCity($data)
    {
        $city = [];

        for ($i = 0; $i < count($data); $i++) {
            $user_city = $data[$i]['user']['city'];
            $city[] = [
                "city" => $user_city,
            ];
        }

        $city = array_unique($city, SORT_REGULAR);
        return $city;
    }

    /**
     * FilterCp
     *
     * @param  mixed $data
     * @return void
     */
    function FilterCp($data)
    {
        $cp = [];

        for ($i = 0; $i < count($data); $i++) {
            $user_cp = $data[$i]['user']['cp'];
            $cp[] = [
                "cp" => $user_cp,
            ];
        }

        $cp = array_unique($cp, SORT_REGULAR);
        return $cp;
    }

    /**
     * FilterCompany
     *
     * @param  mixed $data
     * @return void
     */
    function FilterCompany($data)
    {
        $company = [];

        if ($data[0]['company'] != null) {

            for ($i = 0; $i < count($data); $i++) {
                $name_company = $data[$i]['company'][0]['name'];
                $company[] = [
                    "name" => $name_company,
                ];
            }

            $company = array_unique($company, SORT_REGULAR);
        }

        return $company;
    }

    /**
     * FilterStatus
     *
     * @param  mixed $data
     * @return void
     */
    function FilterStatus($data)
    {
        $builder = $this->db->table('status');

        $status = [];

        for ($i = 0; $i < count($data); $i++) {

            $builder->select('status.name');
            $builder->where('id_status', $data[$i]['status']);
            $query = $builder->get();
            $status_name = $query->getResultArray();

            $status[] = [
                "status" => $status_name[0]['name'],
            ];
        }

        $status = array_unique($status, SORT_REGULAR);


        return $status;
    }
}
