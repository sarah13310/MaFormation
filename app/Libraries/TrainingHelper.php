<?php
namespace App\Libraries;

use App\Controllers\Training;

class TrainingHelper{

    function add($post_data)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('training');
        $builder->insert($post_data);
        return $db->insertID();
    }

    function getTrainingSession(){
        $data = [
            'id_training' => session()->get('id_training'),
            'title' => session()->get('title'),
            'description' => session()->get('description'),
            'date' =>session()->get('date'),
            'duration' => session()->get('duration'),
            'rating' =>session()->get('rating'),          
        ];
        return $data;
    }

    function setTrainingSession($training){
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

    function getTrainingsTitle($status=ALL){
        $db      = \Config\Database::connect();
        $builder = $db->table('training');
        
        $builder->select("id_training, title");
        $query = $builder->get();
        return $query->getResultArray();        
    }

    function getFilterTrainings($status=ALL, $limit=-1){
        $db      = \Config\Database::connect();
        $builder = $db->table('training');        
        $builder->select("id_training, title");
        if ($status!=ALL){
            $builder->where("status", $status);
        }
        if ($limit!=-1){
            $builder->limit($limit);
        }
        $query = $builder->get();
        return $query->getResultArray();        
    }

    function isExist($title){
        $db      = \Config\Database::connect();
        $builder = $db->table('training');
        $builder->where("title", $title);
        $query = $builder->get();
        return ($query->getResultArray()==null)?false:true; 
    }

    function fillOptionsTraining($index){
        $trainings=$this->getTrainingsTitle();
        $str="";        
        foreach ($trainings as $training){        
            $id=$training['id_training'];
            $selected=($id==$index)?"selected":"";
            $str.="<option value='".$training['id_training']."' ".$selected.">".$training['title']."</option>";
        }
        return $str;
    }
   
}