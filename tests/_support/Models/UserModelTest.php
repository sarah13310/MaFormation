<?php

namespace Tests\Support\Models;

use CodeIgniter\Model;

// le 27/02/2023
class UserModelTest extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_user',
        'name',
        'firstname',
        'address',
        'city',
        'cp',
        'country',
        'rights',
        'mail',
        'password',
        'phone',
        "image_url",
        "newsletters",
        "gender",
        "birthday",
        "ratings",
        "type",
        "status",

    ];
    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    // mise à jour horodatage
    protected function beforeInsert(array $data)
    {
        $data = $this->passwordHash($data);
        return $data;
    }

    // mise à jour horodatage
    protected function beforeUpdate(array $data)
    {
        //$data = $this->passwordHash($data);
        return $data;
    }

    /**
     * passwordHash
     * Génère la mot de passe pour l'utilisateur
     * Retourne un tableau
     * @param  mixed $data
     * @return array
     */
    protected function passwordHash(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    /**
     * getFilterUser
     * Récupère la liste de tous les utilisateurs par défaut
     * On peut filter par l'ID pour rechercher un utilisateur en particulier
     * Retourne un tableau composite
     * builder retourne un objet builder
     * user retourne le résultat de la requête: un utilisateur ou plusieurs
     * @param  int $id_user
     * @return array
     */
    function getFilterUser($id_user = ALL)
    {
        $builder = $this->db->table('user');
        if ($id_user != ALL) {
            $builder->where('id_user', $id_user);
        }
        $query = $builder->get();
        $user = $query->getResultArray();
        return ["builder" => $builder, "user" => $user];
    }

    /**
     * getUserById
     *
     * @param  int $id_user
     * @return array
     */
    function getUserById($id_user)
    {
        $builder = $this->db->table('user');
        $builder->where('id_user', $id_user);
        $query = $builder->get();
        return $query->getResultArray();
    }


    /**
     * getUserSession
     * Récupère les informations de la session utitisateur en cours
     * Retourne un tableau
     * @return array
     */
    public function getUserSession()
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


    /**
     * setUserSession
     * Récupère les données de la base et les transfert à la session utilisateur en cours   
     * Retourne rien
     * @param  mixed $user
     * @return void
     */
    function setUserSession($user)
    {
        $user['image_url'] = defaultImage($user, 'DEFAULT_IMG_BLANK');

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


    /**
     * getInfosCertificates
     * récupère juste les noms des certificats en fonction de l'ID 
     * Retourne un tableau
     * @param  int $id
     * @return array
     */
    function getInfosCertificates($id)
    {
        $builder = $this->db->table('user');
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


    /**
     * getCertificates
     * récupère les certificats en fonction de l'ID    
     * sous forme de tableau
     * @param  int $id
     * @return array
     */
    function getCertificates($id)
    {
        $builder = $this->db->table('user');
        $builder->select('certificate.*');
        $builder->where('user.id_user', $id);
        $builder->join('user_has_certificate', 'user_has_certificate.id_user = user.id_user');
        $builder->join('certificate', 'user_has_certificate.id_certificate = certificate.id_certificate');
        $query = $builder->get();
        $skills = $query->getResultArray();
        return $skills;
    }

    function getCompanyById($id)
    {
        $builder = $this->db->table('user');
        $builder->select('company.name, company.address, company.city ,company.cp');
        $builder->where('user.id_user', $id);
        $builder->join('user_has_company', 'user_has_company.id_user = user.id_user');
        $builder->join('company', 'user_has_company.id_company=company.id_company');
        $query = $builder->get();
        return $query->getResultArray();
    }
    /**
     * getInfosCompany
     *
     * récupère les informations des entreprises en fonction de l'ID     
     * @param  int $id
     * 
     * @param  bool $single
     * @return void
     */
    function getInfosCompany($id, $single = true)
    {
        $builder = $this->db->table('user');
        $builder->select('company.name, company.address, company.city ,company.cp');
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


    /**
     * setCompanySession
     *
     * @param  array $user
     *  argument tableau utitlisateur
     * @param  mixed $company
     *  argument tableau entreprise
     * @return void
     */
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
        $builder = $this->db->table('certificate');
        $builder->where('id_certificate', $id);
        $builder->delete();
    }

    /**
     * getFormers
     * Liste des formateurs
     * @return void
     */
    function getFormers()
    {
        $builder = $this->db->table('user');
        $builder->where('type', FORMER);
        $query   = $builder->get();
        return  ["formers" => $query->getResultArray(), "builder" => $builder];
    }

    /**
     * getUserbyType
     * La liste des utilisateurs suivant le profil avec un id ou tous
     * @param  int $type
     * @param  int $id
     * @return array
     */
    function getUserbyType($type, $id = ALL)
    {
        $builder = $this->db->table('user');
        if ($id !== ALL) {
            $builder->where('id', $id);
        }
        $builder->where('type', $type);
        $query   = $builder->get();
        return $query->getResultArray();
    }


    /**
     * getUserByMail
     *
     * @param  string $mail
     * @return array
     */
    function getUserByMail($mail)
    {
        $builder = $this->db->table('user');
        $builder->where('mail', $mail);
        $query   = $builder->get();
        return $query->getResultArray();
    }

    /**
     * modifyPassword
     *
     * @param  int $id
     * @param  int $password
     * @return bool
     */
    function modifyPassword($data)
    {

        $builder = $this->db->table('user');
        $builder->set('password', $data['password']);
        $builder->where('id_user', $data['id_user']);
        $builder->update();
    }
}
