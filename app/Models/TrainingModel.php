<?php

namespace App\Models;

use CodeIgniter\Model;

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
        $db      = \Config\Database::connect();
        //$this = $db->table('training');
        $this->insert($post_data);
        return $db->insertID();
    }

    function getTrainingSession()
    {
        $data = [
            'id_training' => session()->get('id_training'),
            'title' => session()->get('title'),
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
            'title' => $training['title'],
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
        //$this = $db->table('training');
        //$this->select("*");
        $this->where("id_training", $id);
        $query = $this->get();
        return $query->getResultArray();
    }

    function getTrainingsTitle($status = ALL)
    {
        //$db      = \Config\Database::connect();
        //$this = $db->table('training');

        $this->select("id_training, title");
        $query = $$this->get();
        return $query->getResultArray();
    }

    public function getFilterTrainings($status = ALL, $limit = -1)
    {
       // $db      = \Config\Database::connect();
        //$this = $db->table('training');
        $this->select("id_training, title,date, description, image_url");
        if ($status != ALL) {
            $this->where("status", $status);
        }
        if ($limit != -1) {
            $this->limit($limit);
        }
        $query = $this->get();
        return $query->getResultArray();
    }

    function isExist($title)
    {
        //$db      = \Config\Database::connect();
        //$this = $db->table('training');
        $this->where("title", $title);
        $query = $this->get();
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
}
