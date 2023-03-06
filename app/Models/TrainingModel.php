<?php

namespace App\Models;

use CodeIgniter\Model;
// Le 16/02/2023
class TrainingModel extends Model
{
    protected $table = 'training';
    protected $primaryKey = 'id_training';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'title',
        "description",
        'image_url',
        "date",
        "duration",
        "rating",
        "id_bill",
        "id_type_slide",
        "status",
        "id_tag"
    ];

    function add($post_data)
    {
        $builder = $this->db->table('training');
        $builder->insert($post_data);
        return $this->db->insertID();
    }

    function getTrainingSession()
    {
        $data = [
            'id_training' => session()->get('id_training'),
            'title' => session()->get('title_training'),
            'description' => session()->get('description'),
            'date' => session()->get('date'),
            'duration' => session()->get('duration'),
            'rating' => session()->get('rating'),
        ];
        return $data;
    }

    function setTrainingSession($training)
    {
        $data = [
            //'id_training' => $training['id_training'],
            'title_training' => $training['title'],
            'description' => $training['description'],
            'date' => $training['date'],
            'duration' => $training['duration'],
            'rating' => $training['rating'],
        ];
        session()->set($data);
    }

    function getTrainingById($id)
    {
        //$db      = \Config\Database::connect();
        $builder = $this->db->table('training');
        $builder->where("id_training", $id);
        $query = $builder->get();
        return $query->getResultArray();
    }

    function getTrainingsTitle($status = ALL)
    {
        //$db      = \Config\Database::connect();
        $builder = $this->db->table('training');
        $builder->select("id_training, title");
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getFilterTrainings($status = ALL, $limit = -1)
    {
        //$db      = \Config\Database::connect();
        $builder = $this->db->table('training');
        $builder->select("id_training, title,date, description, image_url, status");
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
        //$db      = \Config\Database::connect();
        $builder = $this->db->table('training');
        $builder->where("title", $title);
        $query = $builder->get();
        return ($query->getResultArray() == null) ? false : true;
    }

    function fillOptionsTraining($index)
    {
        $trainings = $this->getTrainingsTitle();
        $str = "";
        foreach ($trainings as $training) {
            $id = $training['id_training'];
            $selected = ($id == $index) ? "selected" : "";
            $str .= "<option value='" . $training['id_training'] . "' " . $selected . ">" . $training['title'] . "</option>";
        }
        return $str;
    }


    public function getFilterPages($id_training, $limit = -1)
    {
        //$db      = \Config\Database::connect();
        $builder = $this->db->table('training_has_page');
        $builder->select("page.id_page, page.title, page.content, page.image_url,page.video_url");
        $builder->join('page', 'page.id_page=training_has_page.id_page');
        $builder->where("training_has_page.id_training", $id_training);

        if ($limit != -1) {
            $builder->limit($limit);
        }
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function deleteTraining($id_training){
        //$db      = \Config\Database::connect();
        $builder = $this->db->table('training');
        $builder->where("id_training", $id_training);
        $builder->delete();
    }
}
