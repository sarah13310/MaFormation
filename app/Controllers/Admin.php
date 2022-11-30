<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UserHasCertificateModel;
use App\Models\CertificateModel;


class Admin extends BaseController
{
    public function index()
    {
        $data = [
            "title" => "Administration"
        ];
        return view('Admin/index.php', $data);
    }

    public function profile()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('user');
        $id = 2;
        
        $builder->where('id_user', $id);
        $query   = $builder->get();
        $user = $query->getResultArray();
        $user=$user[0]; // juste le premier 

        /* compétences certificats*/
        $builder->select('certificate.name');
        $builder->join('user_has_certificate', 'user_has_certificate.id_user = user.id_user');
        $builder->join('certificate', 'user_has_certificate.id_certificate = certificate.id_certificate');
        
        $query = $builder->get();
        $certificates = $query->getResultArray();
        $skills = [];
        foreach ($certificates as $certificate){
            $skills[]= $certificate['name'];  
        }

        $builder->select('company.name, company.address,company.city ,company.cp');
        $builder->join('user_has_company', 'user_has_company.id_user = user.id_user');
        $builder->join('company', 'user_has_company.id_company=company.id_company');
        $query = $builder->get();
        $companies = $query->getResultArray();
        
        $jobs = [];
        foreach ($companies as $company){
            $jobs[]=["name"=> $company['name'],
            "address"=> $company['address']."<br>".$company['city'].", ".$company['cp']];  
        }
        /*$jobs = [
            ["nom" => "Spotify New York", "adresse" => "170 William Street<br>New York, NY 10038-344-678-001"],
            ["nom" => "Plaisance", "adresse" => "55 George Street<br>New York, NY 10036-344-978-006"],
            ["nom" => "Shazam Limited", "adresse" => "236 Gloria Street<br>New York, NY 10037-555-978-016"],
        ];*/
        /*$skills = [
            ["nom"=>"UI UIX"],
            ["nom"=>"Design Pattern"],
            ["nom"=>"C++"],
            ["nom"=>"Php"],
            ["nom"=>"Javascript"],
        ];*/
        $data = [
            "title" => "Mode Super Administrateur",
            "user" => $user,
            "jobs" => $jobs,
            "skills" => $skills,
        ];


        return view('Admin/profile.php', $data);
    }
}
