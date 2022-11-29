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
        "title" => $title,
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
        return view('Former/profile_view.php', $data);
    }

    public function profile_edit()
    {
        $data = profil_basic("Modification profil");
        return view('Former/profile_edit.php', $data);
    }
}
