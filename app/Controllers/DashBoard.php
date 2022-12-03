<?php

namespace App\Controllers;

class DashBoard extends BaseController
{    
    public function index()
    {
        $data=["title"=>"Tableau de bord"      
        ];
        return view('Dashboard/index.php', $data);
    }

    public function listformers(){

        $title = "Liste des formateurs";

        $db      = \Config\Database::connect();
        $builder = $db->table('user');

        $type=7;
        $builder->where('rights',$type);
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
        $builder->select('*');
        $builder->join('user_has_certificate', 'user_has_certificate.id_user = user.id_user');
        $builder->join('certificate', 'user_has_certificate.id_certificate = certificate.id_certificate');

        $query = $builder->get();
        $certificates = $query->getResultArray();
        $skills = [];
        foreach ($certificates as $certificate) {
            $skills[] = ["name" => $certificate['name'],
                        "content" => $certificate['content'],
                        "date" => $certificate['date'],
                        "organism" => $certificate['organism'],
                        "address" => $certificate['address'],
                        "city" => $certificate['city'],
                        "cp" => $certificate['cp'],
                        "country" => $certificate['country'],
                        ];
        }

        $skills=$skills[0];


        $data = [
            "title" => $title,
            "listformers" => $listformers,
            "skills" => $skills,
        ];

        return view('Former/list_former_admin.php', $data);
    }
}
