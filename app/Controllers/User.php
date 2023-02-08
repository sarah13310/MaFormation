<?php

namespace App\Controllers;

// le 12/01/2023
// le 03/02/2023
// le 05/02/2023
class User extends BaseController
{
    public function __construct()
    {
        helper(['util']); // déclaration des fonctions helper
    }

    /* connexion utlitisateur */
    public function login()
    {
        helper(['form']);
        $data = [
            "title" => "Connexion",
            'isLoggedIn' => false,
        ];

        if ($this->isPost()) {
            //let's do the validation here

            $rules = [
                'mail' => 'required|min_length[6]|max_length[50]|valid_email',
                'password' => 'required|min_length[8]|max_length[30]',
            ];

            $error = [
                'mail' => [
                    'required' => "Adresse mail vide!",
                    'min_length' => 'Mail trop court',
                    'max_length' => 'Mail trop long',
                    'valid_email' => 'Format mail incorrect.',
                ],
                'password' => [
                    'required'  => "Mode de passe vide!",
                    'min_length' => 'Mot de passe trop court',
                    'max_length' => 'Mot de passe trop long',
                ],
            ];
            // on stock les informations dans la session
            $mail = $this->request->getVar('mail');
            $password = $this->request->getVar('password');
            session()->set('mail', $mail);
            session()->set('password', $password);

            if (!$this->validate($rules, $error)) {
                $data['validation'] = $this->validator;
            } else {
                $user = null;
                try {
                    $user = $this->user_model->getUserByMail($mail);
                    if ($user) {
                        $user = $user[0];
                    }
                } catch (\CodeIgniter\Database\Exceptions\DatabaseException $ex) {
                    session()->setFlashdata('infos', 'Connexion impossible!');
                    return view('/Login/login', $data);
                } finally {

                    if (!$user) {
                        session()->setFlashdata('infos', 'Cet utilisateur n\'existe pas');
                    } else {
                        $pw = $this->request->getVar('password');
                        $pwh = $user['password'];

                        if (password_verify($pw, $pwh)) { // vérifie si password ok et dispatche
                            $data = $this->dispatch($user);
                            $route = $data['route'];
                            return view($route, $data);
                        }
                    }
                }
            }
        }
        return view('Login/login', $data);
    }

    /**
     * dispatch
     * fonction de redirection suivant profil utilisateur 
     * @param  mixed $user
     * @return array
     */
    private function dispatch($user)
    {
        helper(['form', 'util']);

        $this->user_model->setUserSession($user);

        $type = $user['type'];

        if ($user['image_url'] == null)
            $user['image_url'] = constant('DEFAULT_IMG_BLANK');

        $jobs = $this->user_model->getInfosCompany($user['id_user']);
        $skills = $this->user_model->getInfosCertificates($user['id_user']);

        $data = [
            "user" => $user,
            "jobs" => $jobs,
            "skills" => $skills,
            "route" => "User/profile_user",
            "type" => $type,
            "buttonColor" => getTheme($type, "button"),
            "headerColor" => getTheme($type, "header"),
            "gender" => getGender($user['gender']),
            "birthday" => dateFormat($user['birthday']),
            "title" => getTypeName($type),
        ];
        return $data;
    }

    /**
     * saveCompany
     *
     * @param  mixed $data_user
     * @param  mixed $data_company
     * @param  mixed $kbis
     * @param  mixed $siret
     * @return void
     */
    private function saveCompany($data_user, $data_company, $kbis, $siret)
    {
        //table utilisateur
        $this->user_model->save($data_user);

        // table entreprise    
        $data_company['siret'] = $siret;
        $data_company['kbis'] = $kbis;
        $this->company_model->save($data_company);

        // table jointure
        $id_user = $this->user_model->getInsertID();
        $id_company = $this->company_model->getInsertID();
        $data_jointure = [
            "id_user" => $id_user,
            "id_company" => $id_company,
        ];
        $this->user_has_company_model->save($data_jointure);
    }

    /**
     * associateCompany
     *
     * @param  mixed $data_user
     * @param  mixed $id_company
     * @param  mixed $kbis
     * @param  mixed $siret
     * @return void
     */
    private function associateCompany($data_user, $id_company, $kbis, $siret)
    {
        //table utilisateur
        $this->user_model->save($data_user);

        // table jointure
        $id_user = $this->user_model->getInsertID();

        $data_jointure = [
            "id_user" => $id_user,
            "id_company" => $id_company,
        ];
        $this->user_has_company_model->save($data_jointure);
    }

    /**
     * ifNotExistCompany
     *
     * @param  mixed $data_company
     * @return void
     */
    private function ifNotExistCompany($data_company)
    {
        // on part du principe une seule société par ville
        // une évolution future: vérifier l'adresse        
        $company = $this->company_model->where("name", $data_company['name'])
            ->where("cp", $data_company['cp'])
            ->where("city", $data_company['city'])
            ->first();
        return $company;
    }

    public function confirmation()
    {
        helper(['form']);

        $data['title'] = "Inscrire entreprise";

        $data_user = [
            "name" => session()->get("user_name"),
            "firstname" => session()->get("user_firstname"),
            "address" => session()->get("user_address"),
            "cp" => session()->get("user_cp"),
            "city" => session()->get("user_city"),
            'phone' =>  session()->get('user_phone'),
            'password' =>  session()->get('user_password'),
            'mail' => session()->get('user_mail'),
        ];

        $data_company = [
            'name' => session()->get('company_name'),
            'address' => session()->get('company_address'),
            'city' => session()->get('company_city'),
            'cp' => session()->get('company_cp'),
        ];


        if ($this->isPost()) {

            $rulesconf = [
                'c_siret' => 'required|min_length[12]|max_length[14]',
                'c_kbis' => 'required|min_length[3]|max_length[64]',
            ];

            $errorconf = [
                'c_siret' => ['required' => "Siret de la compagnie vide!"],
                'c_kbis' => ['required' => "Kbis de la compagnie vide!"],
            ];

            $kbis = $this->request->getVar('c_kbis');
            $siret = $this->request->getVar('c_siret');

            if (!$this->validate($rulesconf, $errorconf)) {
                $data['validation'] = $this->validator;
                $data['title'] = "Inscrire société";
                return view('Login/confirmation', $data);
            } else {
                $company = $this->ifNotExistCompany($data_company);
                if ($company == null) { //la société n'existe pas on la rajoute
                    $this->saveCompany($data_user, $data_company, $kbis, $siret);
                } else { // la société existe donc on associe juste avec la table de jointure
                    $this->associateCompany($data_user, $company['id_company'], $kbis, $siret);
                }
                $data["title"] = "Login";
                return view('Login/login', $data);
            }
        }
    }

    /* profil utilisateur */
    public function profileuser()
    {
        helper(['form']);

        if ($this->isPost()) {
            // on met à jour les informations de session           
            session()->mail = $this->request->getVar('mail');
            session()->address = $this->request->getVar('address');
            session()->cp = $this->request->getVar('cp');
            session()->city = $this->request->getVar('city');
            session()->country = $this->request->getVar('country');
            session()->phone = $this->request->getVar('phone');
            session()->gender = $this->request->getVar('gender');
            session()->birthday = $this->request->getVar('birthday');
            session()->site = $this->request->getVar('site');

            // On met à jour les informations de session utilisateur
            $dataUpdate = [
                //'id_user' => session()->id_user,
                'mail' => session()->mail,
                'password' => session()->password,
                'image_url' => session()->image_url,
                'address' => session()->address,
                'cp' => session()->cp,
                'city' => session()->city,
                'country' => session()->country,
                'phone' => session()->phone,
                'gender' => session()->gender,
                'birthday' => session()->birthday,
                'site' => session()->site,
            ];

            $this->user_model->update(session()->id_user, $dataUpdate);
        }
        $user = $this->user_model->getUserSession();
        $skills = $this->user_model->getCertificates($user['id_user']);

        if ($user['image_url'] == null) {
            $user['image_url'] = constant('DEFAULT_IMG_BLANK');
        }
        $data = [
            "title" => getTypeName($user['type']),
            "user" => $user,
            "buttonColor" => getTheme($user['type'], "button"),
            "birthday" => dateFormat($user['birthday']),
            "gender" => getGender($user['gender']),
            "skills" => $skills,
        ];
        return view('User/profile_user.php', $data);
    }

    /**
     * forgetpassword
     * Mot de passe oublié
     * @return void
     */
    public function forgetpassword()
    {
        $data = [
            "title" => "Mot de passe oublié"
        ];
        return view('Login/forgetpassword.php', $data);
    }

    /**
     * logout
     * Deconnexion utilisateur 
     * @return void
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    /**
     * signin
     * Inscription utilisateur
     * @return void
     */
    public function signin()
    {
        $data = ["title" => "Inscription"];
        helper(['form']);

        if ($this->isPost()) {

            $index = $this->request->getVar('index');
            $check = $this->request->getVar('newsletters');
            $main = true;
            $sub = true;

            $rules = [
                'name' => 'required|min_length[3]|max_length[20]',
                'firstname' => 'required|min_length[3]|max_length[20]',
                'address' => 'required|min_length[3]|max_length[128]',
                'city' => 'required|min_length[3]|max_length[64]',
                'cp' => 'required|min_length[3]|max_length[16]',
                'country' => 'required|min_length[3]|max_length[16]',
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
                'country' => ['required' => "Pays vide!"],
                'phone' => ['required' => "Numéro de téléphone vide!"],
                'mail' => ['required' => "Adresse mail vide!"],
                'password' => ['required' => "Mot de passe requis!"],
            ];

            $rulesf = [
                'f_name' => 'required|min_length[3]|max_length[20]',
                'f_content' => 'required|min_length[3]|max_length[128]',
                'f_date' => 'required|min_length[3]|max_length[128]',
                'f_organism' => 'required|min_length[3]|max_length[128]',
                'f_address' => 'required|min_length[3]|max_length[128]',
                'f_city' => 'required|min_length[3]|max_length[64]',
                'f_cp' => 'required|min_length[3]|max_length[16]',
                'f_country' => 'required|min_length[3]|max_length[16]',
            ];

            $errorf = [
                'f_name' => ['required' => "Nom de la certification vide!"],
                'f_content' => ['required' => "Contenu de la certification vide!"],
                'f_date' => ['required' => "Date de la certification vide!"],
                'f_organism' => ['required' => "Organisme de la certification vide!"],
                'f_address' => ['required' => "Adresse de la certification vide!"],
                'f_city' => ['required' => "Ville de la certification vide!"],
                'f_cp' => ['required' => "Code postal de la certification vide!"],
                'f_country' => ['required' => "Pays de la certification vide!"],
            ];

            $rulesc = [
                'c_name' => 'required|min_length[3]|max_length[20]',
                'c_address' => 'required|min_length[3]|max_length[128]',
                'c_city' => 'required|min_length[3]|max_length[64]',
                'c_cp' => 'required|min_length[3]|max_length[16]',
            ];
            $errorc = [
                'c_name' => ['required' => "Nom de la compagnie vide!"],
                'c_address' => ['required' => "Adresse de la compagnie vide!"],
                'c_city' => ['required' => "Ville de la compagnie vide!"],
                'c_cp' => ['required' => "Code postal de la compagnie vide!"],
            ];

            if (!$this->validate($rules, $error)) {
                $data['validation'] = $this->validator;
                $main = false;
            }

            if (!$this->validate($rules, $error)) {
                $data['confirmation'] = $this->validator;
                $main = false;
            }

            switch ($index) {
                case "1":
                    echo "<p>Veuillez sélectionner votre catégorie</p>";
                    $sub = false;
                    break;
                case "2": // Formateurs
                    if (!$this->validate($rulesf, $errorf)) {
                        $data['validation'] = $this->validator;
                        $sub = false;
                    } else {
                        $rights = '00 16 05 05 1D 1D 05';
                    }
                    break;
                case "3": // Entreprises
                    if (!$this->validate($rulesc, $errorc)) {
                        $data['validation'] = $this->validator;
                        $sub = false;
                    } else {
                        $rights = '00 16 05 05 1D 1D 05';
                    }
                    break;
                case "4": // Particuliers
                    $rights = '00 00 1C 05 05 05';
                    break;
            }
            $ischecked = ($check == NULL) ? 0 : 1;

            if ($main && $sub) {

                $newData = [
                    'name' => $this->request->getVar('name'),
                    'firstname' => $this->request->getVar('firstname'),
                    'address' => $this->request->getVar('address'),
                    'city' => $this->request->getVar('city'),
                    'cp' => $this->request->getVar('cp'),
                    'country' => $this->request->getVar('country'),
                    'rights' => $rights,
                    'phone' => $this->request->getVar('phone'),
                    'mail' => $this->request->getVar('mail'),
                    'password' => $this->request->getVar('password'),
                    'type' => $this->request->getVar('type'),
                    'newsletters' => $ischecked,
                ];

                if ($index == 4) { //Particulier
                    $newData['type'] = USER;
                    $newData['status'] = 1;
                    $this->user_model->save($newData);
                }

                if ($index == 2) { // Formateur
                    $newData['type'] = FORMER;
                    $newData['status'] = 1;
                    $this->user_model->save($newData);
                    $id_user = $this->user_model->getInsertID();

                    $newDataf = [
                        'name' => $this->request->getVar('f_name'),
                        'content' => $this->request->getVar('f_content'),
                        'date' => $this->request->getVar('f_date'),
                        'organism' => $this->request->getVar('f_organism'),
                        'address' => $this->request->getVar('f_address'),
                        'city' => $this->request->getVar('f_city'),
                        'cp' => $this->request->getVar('f_cp'),
                        'country' => $this->request->getVar('f_country'),
                    ];
                    $this->certificat_model->save($newDataf);
                    $id_certificate = $this->certificat_model->getInsertID();

                    $newDatace = [
                        'id_user' => $id_user,
                        'id_certificate' => $id_certificate,
                    ];
                    $this->user_has_company_model->save($newDatace);
                }
                if ($index == 3) { //Entreprise
                    $newData['type'] = COMPANY;
                    $newData['status'] = 1;

                    $kbis = $this->request->getVar('c_kbis');
                    $siret = $this->request->getVar('c_siret');

                    $newDatac = [
                        'name' => $this->request->getVar('c_name'),
                        'address' => $this->request->getVar('c_address'),
                        'city' => $this->request->getVar('c_city'),
                        'cp' => $this->request->getVar('c_cp'),
                        'kbis' => $kbis,
                        'siret' => $siret,
                    ];

                    if (empty($kbis) || empty($siret)) {
                        $data['title'] = "Inscrire entreprise";
                        $this->user_model->setCompanySession($newData, $newDatac);
                        return view("Login/confirmation", $data);
                    } else {
                        $company = $this->ifNotExistCompany($newDatac);
                        if ($company == null) {
                            $this->saveCompany($newData, $newDatac, $kbis, $siret);
                        } else {
                            $this->associateCompany($newData, $company['id_company'], $kbis, $siret);
                        }
                    }
                }
                session()->setFlashdata('success', 'Inscription réussie');
                $data["title"] = "Login";
                return view("Login/login", $data);
                die();
            }
        }
        return view('Login/signin', $data);
    }

    /**
     * bill
     * liste des factures suivant profil utilisateur
     * @return void
     */
    public function bill()
    {
        $user = $this->user_model->getUserSession();
        $bills = [];
        switch (session()->type) {
            case USER:
            case COMPANY:
                $bills = $this->bill_model->getFilterBill($user['id_user']);
                break;
            case FORMER:
                break;
            case ADMIN:
            case SUPER_ADMIN:
                $bills = $this->bill_model->getFilterBill();
                break;
        }
        $data = [
            "title" => "Factures",
            "bills" => $bills,
            "user" => $user,
            "buttonColor" => getTheme($user['type'], "button"),
            "headerColor" => getTheme($user['type'], "header"),
        ];
        return view("Payment/bill.php", $data);
    }

    /**
     * modif_name
     * Modification du nom
     * @return void
     */
    public function modif_name()
    {

        if ($this->isPost()) {
            // on met à jour les informations de session
            session()->name = $this->request->getVar('name');
            session()->firstname = $this->request->getVar('firstname');
            $dataUpdate = [
                "name" => session()->name,
                "firstname" => session()->firstname,
            ];
            // On met à jour les informations utilisateur

            $this->user_model->update(session()->id_user, $dataUpdate);
        }
        $user = $this->user_model->getUserSession();
        $skills = $this->user_model->getCertificates($user['id_user']);
        if ($user['image_url'] == null) {
            $user['image_url'] = constant('DEFAULT_IMG_BLANK');
        }
        $data = [
            "title" => getTypeName($user['type']),
            "user" => $user,
            "buttonColor" => getTheme($user['type'], "button"),
            "birthday" => dateFormat($user['birthday']),
            "gender" => getGender($user['gender']),
            "skills" => $skills,
        ];
        return view('User/profile_user.php', $data);
    }

    /**
     * modif_contact
     * modifier les informations de contact
     * @return void
     */
    public function modif_contact()
    {
        helper(["form"]);

        $user = $this->user_model->getUserSession();

        if ($this->isPost()) {

            session()->name = $this->request->getVar('name');
            session()->firstname = $this->request->getVar('firstname');
            session()->address = $this->request->getVar('address');
            session()->city = $this->request->getVar('city');
            session()->cp = $this->request->getVar('cp');
            session()->country = $this->request->getVar('country');
            session()->phone = $this->request->getVar('phone');
            session()->mail = $this->request->getVar('mail');
            session()->birthday = $this->request->getVar('birthday');
            session()->gender = $this->request->getVar('gender');

            $updateData = [
                'name' => session()->name,
                'firstname' => session()->firstname,
                'address' => session()->address,
                'city' => session()->city,
                'cp' => session()->cp,
                'country' => session()->country,
                'phone' => session()->phone,
                'mail' => session()->mail,
                'birthday' => session()->birthday,
                'gender' => session()->gender,
            ];
            $this->user_model->update(session()->id_user, $updateData);

            session()->setFlashdata('success', 'Informations de contact modifiées');
        }
        $data = [
            "title" => "Informations de contact",
            "user" => $user,
            "buttonColor" => getTheme($user['type'], "button"),
        ];
        return view("User/modif_contact.php", $data);
    }

    /**
     * modif_perso
     * modifier les informations personnelles
     * @return void
     */
    public function modif_perso()
    {

        helper(["form"]);

        $user = $this->user_model->getUserSession();
        $data = [
            "title" => "Informations Personnelles",
            "user" => $user,
            "buttonColor" => getTheme($user['type'], "button"),
        ];
        if ($this->isPost()) {
            return view("User/modif_contact.php", $data);
        }
    }

    /**
     * modif_password
     * modifier le mot de passe
     * @return void
     */
    public function modif_password()
    {
        helper(["form"]);
        $user = $this->user_model->getUserSession();
        $data = [
            "title" => "Modification mot de passe",
            "user" => $user,
            "buttonColor" => getTheme($user['type'], "button"),
            "error" => "",
        ];
        // 
        if ($this->isPost()) {
            $oldpassword = $this->request->getVar('password');
            $newpassword = $this->request->getVar('newpassword');
            //
            if (password_verify($oldpassword, session()->password)) { // vérifie si password ok 
                $pwd = password_hash($newpassword, PASSWORD_DEFAULT);
                $dataSave = [
                    'id_user' => $user['id_user'],
                    'password' => $pwd,
                ];
                $this->user_model->modifyPassword($dataSave);
            } else {
                $data['error'] = "mot de passe invalide!";
            }
        }
        return view("User/modif_password.php", $data);
    }

    /**
     * modif_skill
     * modifier une compétence 
     * @return void
     */
    public function modif_skill()
    {
        helper(["form"]);
        // on récupère l'id de la session active
        $id = session()->get("id_user");
        // on récupère les informations utilisateur de la session active           
        $user = $this->user_model->getUserSession();
        $skills = $this->user_model->getCertificates($id);

        if ($this->isPost()) {

            $updateData = [
                'name' => $this->request->getVar('name'),
                'date' => $this->request->getVar('date'),
                'content' => $this->request->getVar('content'),
                'organism' => $this->request->getVar('organism'),
                'address' => $this->request->getVar('address'),
                'city' => $this->request->getVar('city'),
                'cp' => $this->request->getVar('cp'),
                'country' => $this->request->getVar('country'),
            ];

            $id_cetificate = $this->request->getVar('id_certificate');
            //on modifie la compétence dans la table certificate
            if ($id_cetificate) {
                $this->certificat_model->update($id_cetificate, $updateData);
            }
            // on met à jour la liste des compétences
            $skills = $this->user_model->getCertificates($id);
        }
        // on prépare les données pour la page html
        $data = [
            "title" => "Modification des compétences",
            "user" => $user,
            "buttonColor" => getTheme($user['type'], "button"),
            "headerColor" => getTheme($user['type'], "header"),
            "skills" => $skills,
        ];

        return view("User/modif_skill.php", $data);
    }

    /**
     * delete_skill
     * supprimer une compétence par son id
     * @param  int $id_skill
     * @return void
     */
    public function delete_skill($id_skill)
    {
        // on récupère l'id de la session active
        $id = session()->get("id_user");

        $user = $this->user_model->getUserSession();
        //on supprime le certificat dans la table certificate
        $this->user_model->removeCertificate($id_skill);
        // on met à jour la liste des compétences
        $skills = $this->user_model->getCertificates($id);
        // on prépare les données pour la page html
        $data = [
            "title" => "Modification des compétences",
            "user" => $user,
            "buttonColor" => getTheme($user['type'], "button"),
            "headerColor" => getTheme($user['type'], "header"),
            "skills" => $skills,
        ];
        // on supprime en fonction de l'id utilisateur

        $this->user_has_certificate_model->delete(['id_user', $id]);

        return view("User/modif_skill.php", $data);
    }

    /**
     * add_skill
     * ajouter une compétence
     * @return void
     */
    public function add_skill()
    {
        // on récupère les informations utilisateur de la session active        

        $user = $this->user_model->getUserSession();

        if ($this->isPost()) {

            $updateData = [
                'name' => $this->request->getVar('name'),
                'date' => $this->request->getVar('date'),
                'content' => $this->request->getVar('content'),
                'organism' => $this->request->getVar('organism'),
                'address' => $this->request->getVar('address'),
                'city' => $this->request->getVar('city'),
                'cp' => $this->request->getVar('cp'),
                'country' => $this->request->getVar('country'),
            ];
            // on ajoute la compétence dans la table certificate            
            $this->certificat_model->save($updateData);

            // on enrichit la table intermédaire pour faire la jonction
            $id_certificate = $this->certificat_model->getInsertID();
            $data2 = [
                "id_user" => session()->get('id_user'),
                "id_certificate" => $id_certificate,
            ];
            $this->user_has_certificate_model->save($data2);
            // on informe visuelement de l'ajout     
            session()->setFlashdata('success', 'Compétence ajoutée!');
        }
        // on prépare les données pour la page html
        $data = [
            "title" => "Ajouter des compétences",
            "user" => $user,
            "buttonColor" => getTheme($user['type'], "button"),
            "headerColor" => getTheme($user['type'], "header"),
        ];
        return view("User/add_skill.php", $data);
    }

    /**
     * save_photo
     * sauver une photo
     * @return void
     */
    function save_photo()
    {
        helper(['form']);

        $user = $this->user_model->getUserSession();

        if ($this->isPost()) {
            //on récupère le contenu base 64
            $photo = $this->request->getVar('photo');
            $file = "photo_0" . session()->id_user . ".jpeg";
            // on convertir le contenu base 64 en format jpeg
            $url_photo =  './assets/photos/' . $file;
            base64_to_jpeg($photo, $url_photo);
            // on déplace le fichier dans le répertoire photos
            //move_uploaded_file('./'.$file, $url_photo);
            session()->image_url = base_url() . "/assets/photos/" . $file;


            $dataUpdate = [
                "image_url" => base_url() . "/assets/photos/" . $file,
            ];
            $this->user_model->update($user['id_user'], $dataUpdate);
        }
        $skills = $this->user_model->getCertificates($user['id_user']);

        $data = [
            "title" => "Ajouter des compétences",
            "user" => $user,
            "buttonColor" => getTheme($user['type'], "button"),
            "headerColor" => getTheme($user['type'], "header"),
            "birthday" => dateFormat($user['birthday']),
            "gender" => getGender($user['gender']),
            "skills" => $skills,
        ];

        return view("User/profile_user.php", $data);
    }

    /**
     * parameters
     * page des paramètres (version beta)
     * @return void
     */
    function parameters()
    {
        helper(['form']);

        $user = $this->user_model->getUserSession();
        $data = [
            "title" => "Paramètres du profil",
            "user" => $user,
            "buttonColor" => getTheme($user['type'], "button"),
            "headerColor" => getTheme($user['type'], "header"),
        ];

        return view("User/parameters.php", $data);
    }

    /**
     * add_category
     * ajouter une catégorie
     * @return void
     */
    public function add_category()
    {
        // on récupère les informations utilisateur de la session active    
        $user = $this->user_model->getUserSession();

        if ($this->isPost()) {

            $newData = [
                'name' => $this->request->getVar('name'),
            ];
            // on ajoute la compétence dans la table certificate            
            $this->category_model->save($newData);
            // on informe visuelement de l'ajout     
            session()->setFlashdata('success', 'Catégorie ajoutée!');
        }
        // on prépare les données pour la page html
        $categories = $this->category_model->getCategories();
        $data = [
            "title" => "Gestion des catégories",
            "user" => $user,
            "buttonColor" => getTheme($user['type'], "button"),
            "headerColor" => getTheme($user['type'], "header"),
            "categories" => $categories,
        ];
        return view("User/add_category.php", $data);
    }

    /**
     * modify_category
     * modifier une catégorie
     * @return void
     */
    public function modify_category()
    {
        // on récupère les informations utilisateur de la session active    
        $user = $this->user_model->getUserSession();

        if ($this->isPost()) {
            $newData = [
                'id_category' => $this->request->getVar('id_category'),
                'name' => $this->request->getVar('name'),
            ];

            // on ajoute la compétence dans la table certificate            
            $this->category_model->save($newData);
            // on informe visuelement de l'ajout     
            session()->setFlashdata('success', 'Catégorie modifiée!');
        }
        // on prépare les données pour la page html
        $categories = $this->category_model->getCategories();
        $data = [
            "title" => "Gestion des catégories",
            "user" => $user,
            "buttonColor" => getTheme($user['type'], "button"),
            "headerColor" => getTheme($user['type'], "header"),
            "categories" => $categories,
        ];
        return view("User/add_category.php", $data);
    }

    /**
     * delete_category
     * suppression de la catégorie
     * @return void
     */
    public function delete_category()
    {
        // on récupère les informations utilisateur de la session active    
        $user = $this->user_model->getUserSession();
        //
        if ($this->isPost()) {
            $id_category = $this->request->getVar('id_category');

            $deleteData = ['id_category' => $id_category];
            // on supprime la catégorie dans la table            
            $this->category_model->delete($deleteData);
            // on informe visuelement de la suppression     
            session()->setFlashdata('success', 'Catégorie supprimée!');
        }
        // on prépare les données pour la page html
        $categories = $this->category_model->getCategories();

        $data = [
            "title" => "Gestion des catégories",
            "user" => $user,
            "buttonColor" => getTheme($user['type'], "button"),
            "headerColor" => getTheme($user['type'], "header"),
            "categories" => $categories,
        ];
        return view("User/add_category.php", $data);
    }

    /**
     * list_user
     * Liste des utilisateurs (particuliers ou entreprises)
     * @param  string $profil
     * @return void
     */
    public function list_user($profil)
    {
        $users = [];
        $title = "";
        $listuser = [];
        $company = [];

        switch ($profil) {
            case "user":
                $title = "Liste des particuliers";
                if (session()->type == ADMIN || session()->type == SUPER_ADMIN) {
                    $filter = ALL;
                }
                if (session()->type == FORMER) {
                    $filter = session()->id_user;
                }
                $users = $this->user_model->getUserbyType(USER, $filter);
                for ($i = 0; $i < count($users); $i++) {
                    $listuser[] = [
                        'user' => $users[$i],
                        'company' => [],
                    ];
                }
                break;

            case "company":
                $title = "Liste des entreprises";
                if (session()->type == ADMIN || session()->type == SUPER_ADMIN) {
                    $filter = ALL;
                }
                if (session()->type == FORMER) {
                    $filter = session()->id_user;
                }
                $users = $this->user_model->getUserbyType(COMPANY, $filter);

                for ($i = 0; $i < count($users); $i++) {
                    $company = $this->user_model->getCompanyById($users[$i]['id_user']);
                    // print_r($company);
                    // die();
                    $listuser[] = [
                        'user' => $users[$i],
                        'company' => $company[0],
                    ];
                }
                break;
        }
        $user = $this->user_model->getUserSession();
        //
        $data = [
            "title" => $title,
            "user" => $user, // le profil 
            "users" => $listuser, //la liste
            "buttonColor" => getTheme(session()->type, "button"),
            "headerColor" => getTheme(session()->type, "header"),
            "showDetails" => ($profil == "company" ? "" : "hidden"),
            "count" => count($company), // 
        ];
        return view("User/list_client.php", $data);
    }

    public function edit_rdv()
    {
        $user = $this->user_model->getUserSession();
        $query = $this->rdv_model->where("id_user", $user['id_user'])->findAll();
        $events = [];

        $options = $this->category_model->getCategories();
        foreach ($query as $event) {
            $events[] = [
                "title" => "Infos",
                "dateStart" => $event['dateStart'],
                "dateEnd" =>  $event['dateEnd'],
            ];
        }
        $legend = "";

        if (session()->type == USER) {

            $legend = "Sélectionner votre créneau horaire avec les disponiblités du formateur.";
        }
        if (session()->type == COMPANY) {

            $legend = "Sélectionner votre créneau horaire avec les disponiblités du formateur.";
        }
        if (session()->type == FORMER) {
            $legend = "Définissez votre créneau horaire.";
        }
        // Liste des formations disponibles
        $trainings=$this->training_model->getTrainingsTitle(VALIDE);
        //print_r($trainings);
        // Liste des formateurs
        $public=$this->user_model->getFormers();
        $formers=$public['formers'];
        $listformers=[];
        foreach ($formers as $former){
            $listformers[]=[
                "id_user"=>$former['id_user'],
                "name"=>$former['name'],
                "firstname"=>$former['firstname'],
            ];
        }
        //print_r($listformers);
        //die();
        $data = [
            "title" => "Gestion des rendez-vous",
            "id_user" => $user['id_user'],
            "events" => $events,
            "user" => $user,
            "options" => $options,
            "buttonColor" => getTheme($user['type'], "button"),
            "headerColor" => getTheme($user['type'], "header"),
            "legend" => $legend,
            "trainings"=>$trainings,
            "formers"=>$listformers,
        ];
        return view('User/rdv.php', $data);
    }

    public function list_rdv(){

    }

    public function save_rdv()
    {
        if ($this->isPost()) {
            $dateStart = $this->request->getVar('dateStart');
            $dateEnd = $this->request->getVar('dateEnd');
            $timeStart = $this->request->getVar('timeStart');
            $timeEnd = $this->request->getVar('timeEnd');
            $id_training = $this->request->getVar('id_training');
            $id_former = $this->request->getVar('id_former');
            $id_user = session()->id_user;

            $dataRdv = [
                'dateStart' => $dateStart,
                'dateEnd' => $dateEnd,
                'id_training' => $id_training,
                'id_user' => $id_user,
            ];
            
            $id_rdv=$this->rdv_model->insert($dataRdv);
            //
            //$id_former = $this->user_has_training_model->getFormer($id_training);
            $dataInt = [
                'id_former' => $id_former,
                'id_user' => $id_user,
            ];
            $this->user_has_user_model->save($dataInt);

            //il faut user_has_rdv
            $dataIntRdv = [
                'id_user' => $id_former,
                'id_rdv' => $id_rdv,
            ];
            $this->user_has_rdv_model->save($dataIntRdv);
            //return view('User/rdv.php', $data);
        }
    }
}
