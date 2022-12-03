<?php

namespace App\Controllers;

function profil_basic($title)
{

    $db      = \Config\Database::connect();
    $builder = $db->table('user');
    $id = 2;

    $builder->where('id_user', $id);
    $query   = $builder->get();
    $user = $query->getResultArray();
    $user = $user[0]; // juste le premier 

    $type=7;
        $builder->where('rights',$type);
        $query   = $builder->get();
        $formers = $query->getResultArray();
    
        $listformers = [];
    
        foreach ($formers as $former) {
            $listformers[] = ["name" => $former['name'],
                        "firstname" => $former['firstname'],
                        "address" => $former['address'],
                        "city" => $former['city'],
                        "cp" => $former['cp'],
                        "country" => $former['country'],
                        "mail" => $former['mail'],
                        "phone" => $former['country'],
                        ];
        }

    /* compétences certificats*/
    $builder->select('certificate.name');
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

    $builder->select('company.name, company.address,company.city ,company.cp');
    $builder->join('user_has_company', 'user_has_company.id_user = user.id_user');
    $builder->join('company', 'user_has_company.id_company=company.id_company');
    $query = $builder->get();
    $companies = $query->getResultArray();

    $jobs = [];
    foreach ($companies as $company) {
        $jobs[] = [
            "name" => $company['name'],
            "address" => $company['address'] ,
            "city" => $company['city'], 
            "cp" => $company['cp'],
            "country" => $company['country'],
        ];
    }

    $data = [
        "title" => $title,
        "listformers" => $listformers,
        "user" => $user,
        "jobs" => $jobs,
        "skills" => $skills,
    ];

    return $data;
}


class Former extends BaseController
{
    public function former_list()
    {
        $data = profil_basic("Liste des formateurs");
        return view('Former/list.php', $data);
    }
    
    public function former_view()
    {
        $data = profil_basic("Votre formateur");
        return view('Former/index.php', $data);
    }

    public function profile_view()
    {
        $data = profil_basic("Votre profil");
        return view('Former/profile_former.php', $data);
    }

}
