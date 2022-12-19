<?php
namespace App\Libraries;


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
   
}