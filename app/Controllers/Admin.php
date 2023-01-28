<?php

namespace App\Controllers;

use App\Models\UserModel;


class Admin extends BaseController
{      
    /**
     * profileadmin
     *
     * @return void
     */
    public function profileadmin()
    {
        helper(['form', "util"]);
        $id = session()->get('id_user');

        $db      = \Config\Database::connect();
        $builder = $db->table('user');
        $builder->where('id_user', $id);
        $query   = $builder->get();
        $user = $query->getResultArray();
        $user = $user[0]; // juste le premier 

        /* compétences certificats */
        $builder->select('certificate.name');
        $builder->join('user_has_certificate', 'user_has_certificate.id_user = user.id_user');
        $builder->join('certificate', 'user_has_certificate.id_certificate = certificate.id_certificate');

        $query = $builder->get();
        $certificates = $query->getResultArray();
        $skills = [];
        foreach ($certificates as $certificate) {
            $skills[] = $certificate['name'];
        }

        $builder->select('company.name, company.address,company.city ,company.cp');
        $builder->join('user_has_company', 'user_has_company.id_user = user.id_user');
        $builder->join('company', 'user_has_company.id_company=company.id_company');
        $query = $builder->get();
        $companies = $query->getResultArray();
        $jobs = [];
        foreach ($companies as $company) {
            $jobs[] = [
                "name" => $company['name'],
                "address" => $company['address'] . "<br>" . $company['city'] . ", " . $company['cp']
            ];
        }
        $data = [
            "title" => "Mode Administrateur",
            "user" => $user,
            "jobs" => $jobs,
            "skills" => $skills,
        ];
        return view('Admin/profile_admin.php', $data);
    }
    
    /**
     * superprofile
     *
     * @return void
     */
    public function superprofile()
    {
        helper(['form']);
        
        $db      = \Config\Database::connect();
        $builder = $db->table('user');
        $id = session()->get('id_user');

        $builder->where('id_user', $id);
        $query   = $builder->get();
        $user = $query->getResultArray();
        $user = $user[0]; // juste le premier 

        /* compétences certificats*/
        $builder->select('certificate.name');
        $builder->join('user_has_certificate', 'user_has_certificate.id_user = user.id_user');
        $builder->join('certificate', 'user_has_certificate.id_certificate = certificate.id_certificate');

        $query = $builder->get();
        $certificates = $query->getResultArray();
        $skills = [];
        foreach ($certificates as $certificate) {
            $skills[] = $certificate['name'];
        }

        $builder->select('company.name, company.address,company.city ,company.cp');
        $builder->join('user_has_company', 'user_has_company.id_user = user.id_user');
        $builder->join('company', 'user_has_company.id_company=company.id_company');
        $query = $builder->get();
        $companies = $query->getResultArray();

        $jobs = [];
        foreach ($companies as $company) {
            $jobs[] = [
                "name" => $company['name'],
                "address" => $company['address'] . "<br>" . $company['city'] . ", " . $company['cp']
            ];
        }
        $data = [
            "title" => "Profil",
            "user" => $user,
            "jobs" => $jobs,
            "skills" => $skills,
        ];
        return view('Admin/super_profile.php', $data);
    }


    public function add_admin()
    {
        $this->verifySession();
        $user = $this->getUserSession();
        
        $data = [
            "title" => "Profil",
            "subtitle" => "Ajouter un administrateur",
            "user" => $user,
            "buttonColor" => getTheme(session()->type, "button"),
        ];

        if ($this->request->getMethod() == 'post') {
            //faisons la validation ici
            $rules = [
                'mail' => 'required|min_length[6]|max_length[50]|valid_email',
                'password' => 'required|min_length[8]|max_length[25]',
                'name' => 'required|min_length[3]|max_length[25]',
                'firstname' => 'required|min_length[2]|max_length[25]',
            ];

            $error = [
                'mail' => [
                    'required' => "Adresse mail vide!",
                    'valid_email' => 'Format mail incorrect.',
                    'min_length' => "Adresse mail trop courte",
                    'max_length' => "Adresse mail trop longue",
                ],
                'password' => [
                    'required' => "Mode de passe requis!",
                    'min_length' => "Mot de passe trop court",
                    'max_length' => "Mot de passe trop long",
                ],
                'name' => [
                    'required' => "Nom requis!",
                    'min_length' => "Nom trop court",
                    'max_length' => "Nom trop long",
                ],
                'firstname' => [
                    'required' => "Prénom requis!",
                    'min_length' => "Prénom trop court",
                    'max_length' => "Prénom trop long",
                ],
            ];

            if (!$this->validate($rules, $error)) {
                $data['validation'] = $this->validator;
            } else {

                $model = new UserModel();
                $user = $model->where('mail', $this->request->getVar('mail'))->first();
                if ($user) {
                    session()->setFlashdata('infos', 'Cet Administrateur existe déjà!');
                } else {
                    $rights = "1F 1F 1F 05 1F 05";

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
                        'newsletters' => true,
                        'country' => "France",
                        'type' => $this->request->getVar('type'),
                        'status' => 2,
                        'gender' => $this->request->getVar('gender'),
                    ];
                    $data['title'] = "Liste des privilèges";
                    $data['buttonColor'] = getTheme(session()->type, "button");
                    $model->save($newData);
                    session()->setFlashdata('succes', "Création réussie de l'administrateur");
                    return  redirect()->to(base_url('//superadmin/privileges'));
                }
            }
        }
        return view('Admin/add_admin.php', $data);
    }
}
