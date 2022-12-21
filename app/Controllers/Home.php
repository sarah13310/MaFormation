<?php

namespace App\Controllers;

use App\Models\LettersModel;

class Home extends BaseController
{
    public function index()
    {
        helper(['form']);

        if ($this->request->getMethod() == 'post') {

            $rules = [
                'mail' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[user.mail]',
            ];

            $error = [
                'mail' => ['required' => "Adresse mail vide!"],
            ];

            if (!$this->validate($rules, $error)) {
                $data['validation'] = $this->validator;
            } else {
                $model = new LettersModel();

                $newData = [
                    'mail' => $this->request->getVar('mail'),
                ];


                $model->save($newData);
            }
        }

        $data = [
            "title" => "Accueil"
        ];
        return view('Home/index.php', $data);
    }

    public function faq()
    {
        $data = [
            "title" => "FAQ"
        ];
        return view('FAQ/index.php', $data);
    }

    public function funding()
    {
        $data = [
            "title" => "Financement"
        ];
        return view('Funding/index.php', $data);
    }
}
