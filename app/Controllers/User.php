<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    public function login()
    {
        $data = [
            "title" => "Connexion",
            'isLoggedIn' => false,
        ];
        helper(['form']);

        if ($this->request->getMethod() == 'post') {
            //let's do the validation here
            $rules = [
                'email' => 'required|min_length[6]|max_length[50]|valid_email',
                'password' => 'required|min_length[8]|max_length[255]',
            ];

            $error = [
                'email' => [
                    'required' => "Adresse mail vide!",
                    'valid_email' => 'Format mail incorrect.',
                ],
                'password' => ['required' => "Mode de passe requis!"],
            ];

            if (!$this->validate($rules, $error)) {
                $data['validation'] = $this->validator;
            } else {
                $model = new UserModel();
                $user = $model->where('mail', $this->request->getVar('email'))->first();

                if (!$user) {
                    session()->setFlashdata('infos', 'Cet utilisateur n\'existe pas');
                } else {
                    $pw = $this->request->getVar('password');
                    $pwh = $user['password'];

                    if (password_verify($pw, $pwh)) {
                        $this->setUserSession($user);
                        return redirect()->to("dashboard");
                    }
                }
            }
        }
        return view('Login/login', $data);
    }

    private function setUserSession($user)
    {
        $data = [
            'id' => $user['id_user'],
            'firstname' => $user['firstname'],
            'lastname' => $user['lastname'],
            'email' => $user['email'],
            'isLoggedIn' => true,
        ];
        session()->set($data);
        return true;
    }  

    public function forgetpassword()
    {
        $data = [
            "title" => "Mot de passe oublié"
        ];
        return view('Login/forgetpassword.php', $data);
    }

    public function signin()
    {
        $data = ["title" => "Inscription"];
        helper(['form']);

        if ($this->request->getMethod() == 'post') {

            $index = $this->request->getVar('index');
            $main = true;
            $sub = true;

            $rules = [
                'name' => 'required|min_length[3]|max_length[20]',
                'firstname' => 'required|min_length[3]|max_length[20]',
                'address' => 'required|min_length[3]|max_length[128]',
                'city' => 'required|min_length[3]|max_length[64]',
                'cp' => 'required|min_length[3]|max_length[16]',
                'phone' => 'required|min_length[3]|max_length[16]',
                'mail' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[user.mail]',
                'password' => 'required|min_length[8]|max_length[255]',
                'password_confirm' => 'matches[password]',
            ];
            $error = [
                'name' => ['required' => "Nom vide!"],
                'firstname' => ['required' => "Prénom vide!"],
                'address' => ['required' => "Adresse vide!"],
                'city' => ['required' => "Ville vide!"],
                'cp' => ['required' => "Code postal vide!"],
                'phone' => ['required' => "Numéro de téléphone vide!"],
                'mail' => ['required' => "Adresse mail vide!"],
                'password' => ['required' => "Mot de passe requis!"],
            ];

            $rulesf = [
                'f_name' => 'required|min_length[3]|max_length[20]',
                'f_content' => 'required|min_length[3]|max_length[128]',
                'f_date' => 'required|min_length[3]|max_length[128]',
                'f_location' => 'required|min_length[3]|max_length[128]',
            ];
            $errorf = [
                'f_name' => ['required' => "Nom de la certification vide!"],
                'f_content' => ['required' => "Contenu de la certification vide!"],
                'f_date' => ['required' => "Date de la certification vide!"],
                'f_location' => ['required' => "Lieu de la certification vide!"],
            ];
            $rulesc = [
                'c_name' => 'required|min_length[3]|max_length[20]',
                'c_address' => 'required|min_length[3]|max_length[128]',
                'c_city' => 'required|min_length[3]|max_length[64]',
                'c_cp' => 'required|min_length[3]|max_length[16]',
                'c_siret' => 'required|min_length[3]|max_length[64]',
                'c_kbis' => 'required|min_length[3]|max_length[64]',
            ];
            $errorc = [
                'c_name' => ['required' => "Nom de la compagnie vide!"],
                'c_address' => ['required' => "Adresse de la compagnie vide!"],
                'c_city' => ['required' => "Ville de la compagnie vide!"],
                'c_cp' => ['required' => "Code postal de la compagnie vide!"],
                'c_siret' => ['required' => "Siret de la compagnie vide!"],
                'c_kbis' => ['required' => "Kbis de la compagnie vide!"],
            ];

            if (!$this->validate($rules, $error)) {
                $data['validation'] = $this->validator;
                $main = false;
            }

            switch ($index) {
                case "1":
                    echo "<p>Veuillez sélectionner votre catégorie</p>";
                    break;
                case "2":
                    if (!$this->validate($rulesf, $errorf)) {
                        $data['validation'] = $this->validator;
                        $sub = false;
                    }
                    break;
                case "3":
                    if (!$this->validate($rulesc, $errorc)) {
                        $data['validation'] = $this->validator;
                        $sub = false;
                    }
                    break;
            }

            if ($main && $sub ) {
                return redirect()->to("/");
            }
        }
        return view('Login/signin', $data);
    }
}
