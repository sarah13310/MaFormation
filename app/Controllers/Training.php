<?php

namespace App\Controllers;

require_once($_SERVER['DOCUMENT_ROOT'] . '/php/functions/util.php');

use App\Libraries\UserHelper;
use App\Libraries\TrainingHelper;
use App\Libraries\PageHelper;

// Le 12/01/2023
class Training extends BaseController
{

    public function list()
    {
        $user_helper = new UserHelper();
        $user = $user_helper->getUserSession();

        $training_helper = new TrainingHelper();
        $trainings = $training_helper->getFilterTrainings();
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
        //$user_helper= new UserHelper();
        //$user=$user_helper->getUserSession();

        $training_helper = new TrainingHelper();
        $trainings = $training_helper->getFilterTrainings();
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
            //"theme_button" => getTheme($user['type'], "button"),
            //"headerColor" => getTheme($user['type'],"header"),
        ];
        return view('Training/training_list_home.php', $data);
    }


    public function details($id = 0)
    {

        if ($this->request->getMethod() == 'post') {
            $id = $this->request->getVar('id_training');
        }

        $training_helper = new TrainingHelper();
        $training = $training_helper->getTrainingById($id);
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
        $training_helper = new TrainingHelper();
        if ($this->request->getMethod() == 'post') {
            $id = $this->request->getVar('id_training');
            $training = $training_helper->getTrainingById($id);
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

        $training_helper = new TrainingHelper();
        $page_helper = new PageHelper();
        if ($this->request->getMethod() == 'post') {
            $id = $this->request->getVar('id_training');
            $training = $training_helper->getTrainingById($id);

            if ($training) {
                $training = $training[0];
                $pages = $page_helper->getPageById($training['id_training']);
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
