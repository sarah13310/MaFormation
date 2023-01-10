<?php

namespace App\Controllers;

require_once($_SERVER['DOCUMENT_ROOT'] . '/php/functions/util.php');

use App\Libraries\TrainingHelper;

// Le 10/01/2023
class Training extends BaseController
{
    public function index()
    {
        $data = [
            "title" => "Les formations"
        ];
        return view('Training/index.php', $data);
    }

    public function details($id)
    {
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

            $data=[
                "title"=>$training['title'],

            ];
        }
        return view('Payment/paymentcard.php', $data);
    }
}
