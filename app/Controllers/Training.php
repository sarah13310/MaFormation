<?php

namespace App\Controllers;

// Le 12/01/2023
// Le 20/01/2023 modification avec helper

class Training extends BaseController
{
    public function __construct(){
      helper(['util']); // déclaration des fonctions helper
    }
    /* liste des formations (profil utilisateur)*/
    public function list()
    {
        $user = $this->user_model->getUserSession();
        $trainings= $this->training_model->getFilterTrainings();            
        $list_training = [];

        foreach ($trainings as $training) {
            $list_training[] = [
                "id_training" => $training['id_training'],
                "title" => $training['title'],
                "date" => dateTimeFormat($training['date']),
                "description" => textEllipsis($training['description'], 20),
            ];
        }
        $data = [
            "title" => "Liste des formations",
            "trainings" => $list_training,
            "user" => $user,
            "theme_button" => getTheme($user['type'], "button"),
            "headerColor" => getTheme($user['type'], "header"),
        ];
        return view('Training/training_list.php', $data);
    }

    public function home()
    {
        helper(['util']);

        $trainings = $this->training_model->getFilterTrainings();

        $list_training = [];

        foreach ($trainings as $training) {
            if ($training['image_url'] == null) {
                $training['image_url'] = base_url() . "/assets/training.svg";
            }
            $list_training[] = [
                "id_training" => $training['id_training'],
                "title" => $training['title'],
                "date" => dateTimeFormat($training['date']),
                "description" => textEllipsis($training['description'], 30),
                //"full_description" => $training['description'],
                "image_url" => $training['image_url'],
            ];
        }
        $data = [
            "title" => "Liste des formations",
            "trainings" => $list_training,
            "buttonColor" => getTheme(session()->type, "button"),
            "headerColor" => getTheme(session()->type,"header"),
        ];
        return view('Training/training_list_home.php', $data);
    }


    public function details($id = 0)
    {

        if ($this->request->getMethod() == 'post') {
            $id = $this->request->getVar('id_training');
        }

        $training=$this->training_model->getTrainingById($id);
        $training = $training[0];

        $image_url = $training['image_url'];
        if ($image_url == null) {
            $training['image_url'] = base_url() . "/assets/training.svg";
        }

        $data = [
            "title" => "Détail de la formation",
            "id" => $id,
            "training" => $training,
            "date" => dateTimeFormat($training['date']),
        ];
        return view('Training/training_details.php', $data);
    }



    public function payment()
    {   
        
        if ($this->request->getMethod() == 'post') {
            $id = $this->request->getVar('id_training');
            $training=$this->training_model->getTrainingById($id);
            $training = $training[0];

            $data = [
                "title" => $training['title'],

            ];
        }
        return view('Payment/paymentcard.php', $data);
    }

    public function view()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('user');
        $id = session()->get('id_user');

        $builder->where('id_user', $id);
        $query   = $builder->get();
        $user = $query->getResultArray();
        $user = $user[0]; // juste le premier        
        
        if ($this->request->getMethod() == 'post') {
            $id = $this->request->getVar('id_training');
            $training = $this->training_model->getTrainingById($id);

            if ($training) {
                $training = $training[0];
                $pages = $this->page_model->getPageById($training['id_training']);
                $list_description = [];
                $list_images = [];

                foreach ($pages as $page) {
                    $list_description[] = $page['content'];
                    if ($page['image_url'] == null) {
                        $page['image_url'] = base_url() . "/assets/chapter.svg";
                    }
                    $list_images[] = $page['image_url'];
                }
                $descriptions = json_encode($list_description);
                $images = json_encode($list_images);

                $data = [
                    "title" => $training['title'],
                    "training" => $training,
                    "date" => dateTimeFormat($training['date']),
                    "count" => count($pages),
                    "pages" => $pages,
                    "descriptions" => $descriptions,
                    "images" => $images,
                    "user" => $user,
                    "theme_button" => getTheme($user['type'], "button"),
                ];
                return view('Training/training_view.php', $data);
            } else {
                return view('errors/html/error_404.php');
            }
        }
    }
}
