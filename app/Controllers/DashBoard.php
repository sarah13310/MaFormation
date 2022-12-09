<?php

namespace App\Controllers;

class DashBoard extends BaseController
{

    public function listformers()
    {

        $title = "Liste des formateurs";

        $db      = \Config\Database::connect();
        $builder = $db->table('user');

        $type = 7;
        $builder->where('type', $type);
        $query   = $builder->get();
        $formers = $query->getResultArray();

        $listformers = [];

        foreach ($formers as $former) {
            $listformers[] = [
                "id_user" => $former['id_user'],
                "name" => $former['name'],
                "firstname" => $former['firstname'],
                "address" => $former['address'],
                "city" => $former['city'],
                "cp" => $former['cp'],
                "country" => $former['country'],
                "mail" => $former['mail'],
                "phone" => $former['phone'],
            ];
        }


        /* compétences certificats*/

        $builder->select('certificate.name,certificate.content,certificate.date,certificate.organism,certificate.address,certificate.city,certificate.cp,certificate.country');


        $skills = [];

        for ($i = 0; $i < count($listformers); $i++) {
            $builder->where('user.id_user', $listformers[$i]['id_user']);
            $builder->join('user_has_certificate', 'user_has_certificate.id_user = user.id_user');
            $builder->join('certificate', 'user_has_certificate.id_certificate = certificate.id_certificate');

            $query = $builder->get();
            $certificates = $query->getResultArray();

            $certi = [];
            foreach ($certificates as $certificate) {
                $certi[] = [
                    "name" => $certificate['name'],
                    "content" => $certificate['content'],
                    "date" => $certificate['date'],
                    "organism" => $certificate['organism'],
                    "address" => $certificate['address'],
                    "city" => $certificate['city'],
                    "cp" => $certificate['cp'],
                    "country" => $certificate['country'],
                ];
            }

            $listformers[$i]["skills"] = $certi;
        }


        $builder->select('company.name, company.address,company.city ,company.cp,company.country');
        $builder->join('user_has_company', 'user_has_company.id_user = user.id_user');
        $builder->join('company', 'user_has_company.id_company=company.id_company');
        $query = $builder->get();
        $companies = $query->getResultArray();

        $jobs = [];
        foreach ($companies as $company) {
            $jobs[] = [
                "name" => $company['name'],
                "address" => $company['address'],
                "city" => $company['city'],
                "cp" => $company['cp'],
                "country" => $company['country'],
            ];
        }

        $data = [
            "title" => $title,
            "listformers" => $listformers,
            "jobs" => $jobs,
        ];

        return view('Admin/list_former_admin.php', $data);
    }

    private function getUserSession()
    {
        $user = [
            'id_user' => session()->get('id_user'),
            'name' => session()->get('name'),
            'firstname' => session()->get('firstname'),
            'mail' => session()->get('mail'),
            'password' => session()->get('password'),
            'type' => session()->get('type'),
            'image_url' => session()->get('image_url'),
            'gender' => session()->get('gender'),
            'isLoggedIn' => true,
        ];        
        return $user;
    }

    public function privileges()
    {

        $title = "Liste des privilèges";

        $db      = \Config\Database::connect();
        $builder = $db->table('user');

        $type = 3;
        $typed = 5;
        $builder->where('type', $type);
        $builder->orWhere('type', $typed);
        $query   = $builder->get();
        $formers = $query->getResultArray();

        $listformers = [];

        foreach ($formers as $former) {
            $listformers[] = [
                "id_user" => $former['id_user'],
                "name" => $former['name'],
                "firstname" => $former['firstname'],
                "address" => $former['address'],
                "city" => $former['city'],
                "cp" => $former['cp'],
                "country" => $former['country'],
                "mail" => $former['mail'],
                "phone" => $former['phone'],
                "type" => $former['type'],
                "rights"=>$former['rights'],
            ];
        }


        /* compétences certificats*/

        $builder->select('certificate.name,certificate.content,certificate.date,certificate.organism,certificate.address,certificate.city,certificate.cp,certificate.country');


        $skills = [];

        for ($i = 0; $i < count($listformers); $i++) {
            $builder->where('user.id_user', $listformers[$i]['id_user']);
            $builder->join('user_has_certificate', 'user_has_certificate.id_user = user.id_user');
            $builder->join('certificate', 'user_has_certificate.id_certificate = certificate.id_certificate');

            $query = $builder->get();
            $certificates = $query->getResultArray();

            $certi = [];
            foreach ($certificates as $certificate) {
                $certi[] = [
                    "name" => $certificate['name'],
                    "content" => $certificate['content'],
                    "date" => $certificate['date'],
                    "organism" => $certificate['organism'],
                    "address" => $certificate['address'],
                    "city" => $certificate['city'],
                    "cp" => $certificate['cp'],
                    "country" => $certificate['country'],
                ];
            }

            $listformers[$i]["skills"] = $certi;
        }


        $builder->select('company.name, company.address,company.city ,company.cp,company.country');
        $builder->join('user_has_company', 'user_has_company.id_user = user.id_user');
        $builder->join('company', 'user_has_company.id_company=company.id_company');
        $query = $builder->get();
        $companies = $query->getResultArray();

        $jobs = [];
        foreach ($companies as $company) {
            $jobs[] = [
                "name" => $company['name'],
                "address" => $company['address'],
                "city" => $company['city'],
                "cp" => $company['cp'],
                "country" => $company['country'],
            ];
        }

        $user=$this->getUserSession();

        $data = [
            "title" => $title,
            "listformers" => $listformers,
            "jobs" => $jobs,
            "user"=>$user,
        ];

        return view('Admin/list_privileges.php', $data);
    }
}
