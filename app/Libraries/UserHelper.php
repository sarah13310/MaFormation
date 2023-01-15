<?php

namespace App\Libraries;

use CodeIgniter\Database\MySQLi\Builder;

// le 15/01/2023
class UserHelper
{

    function getFilterUser($id_user = ALL)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('user');
        if ($id_user != ALL) {
            $builder->where('id_user', $id_user);
        }
        $query = $builder->get();
        $user = $query->getResultArray();
        return ["builder" => $builder, "user" => $user];
    }

    // Restitue les informations de session
    function getUserSession()
    {
        $user = [
            'type' => session()->type,
            'id_user' => session()->id_user,
            'name' => session()->name,
            'firstname' => session()->firstname,
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
            'isLoggedIn' => true,
        ];
        return $user;
    }

    // Associe les données de la base à la session en cours
    function setUserSession($user)
    {
        $data = [
            'type' => $user['type'],
            'id_user' => $user['id_user'],
            'name' => $user['name'],
            'firstname' => $user['firstname'],
            'mail' => $user['mail'],
            'password' => $user['password'],
            'image_url' => $user['image_url'],
            'address' => $user['address'],
            'cp' => $user['cp'],
            'city' => $user['city'],
            'country' => $user['country'],
            'phone' => $user['phone'],
            'gender' => $user['gender'],
            'birthday' => $user['birthday'],
            'ratings' => $user['ratings'],
            'site' => "www.maformation.com",
            'status' => $user['status'],
            'current_job' => $user['current_job'],
            'isLoggedIn' => true,
        ];
        session()->set($data);
        return true;
    }

    // récupère les noms des certificats en fonction de l'ID 
    function getInfosCertificates($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('user');
        $builder->select('certificate.name');
        $builder->where('user.id_user', $id);
        $builder->join('user_has_certificate', 'user_has_certificate.id_user = user.id_user');
        $builder->join('certificate', 'user_has_certificate.id_certificate = certificate.id_certificate');
        $query = $builder->get();
        $certificates = $query->getResultArray();
        $skills = [];
        foreach ($certificates as $certificate) {
            $skills[] = $certificate['name'];
        }
        return $skills;
    }

    // récupère les certificats en fonction de l'ID 
    function getCertificates($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('user');
        $builder->select('certificate.*');
        $builder->where('user.id_user', $id);
        $builder->join('user_has_certificate', 'user_has_certificate.id_user = user.id_user');
        $builder->join('certificate', 'user_has_certificate.id_certificate = certificate.id_certificate');
        $query = $builder->get();
        $skills = $query->getResultArray();
        return $skills;
    }

    // récupère les informations des entreprises en fonction de l'ID 
    function getInfosCompany($id, $single = true)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('user');
        $builder->select('company.name, company.address,company.city ,company.cp');
        $builder->where('user.id_user', $id);
        $builder->join('user_has_company', 'user_has_company.id_user = user.id_user');
        $builder->join('company', 'user_has_company.id_company=company.id_company');
        $query = $builder->get();
        $companies = $query->getResultArray();
        $jobs = [];

        if ($companies == null)
            return $jobs;

        if ($single) {
            $jobs[] = [
                "name" => $companies[0]['name'],
                "address" => $companies[0]['address'] . "<br>" . $companies[0]['city'] . ", " . $companies[0]['cp']
            ];
            return $jobs;
        }

        foreach ($companies as $company) {
            $jobs[] = [
                "name" => $company['name'],
                "address" => $company['address'] . "<br>" . $company['city'] . ", " . $company['cp']
            ];
        }
        return $jobs;
    }


    function setCompanySession($user, $company)
    {
        $data = [
            'user_name' => $user['name'],
            'user_firstname' => $user['firstname'],
            'user_mail' => $user['mail'],
            'user_address' => $user['address'],
            'user_cp' => $user['cp'],
            'user_city' => $user['city'],
            'user_phone' => $user['phone'],
            'user_password' => $user['password'],
            'company_name' => $company['name'],
            'company_address' => $company['address'],
            'company_cp' => $company['cp'],
            'company_city' => $company['city'],
            'company_kbis' => $company['kbis'],
            'company_siret' => $company['siret'],
        ];
        session()->set($data);
        return true;
    }

    // Suppression d'un certificat en fonction de son id
    function removeCertificate($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('certificate');
        $builder->where('id_certificate', $id);
        $builder->delete();
    }
}
