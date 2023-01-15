<?php

namespace App\Models;

use CodeIgniter\Model;

define("TYPE_SUPER_ADMIN", "3");
define("TYPE_ADMIN", "5");
define("TYPE_FORMER", "7");
define("TYPE_USER",     "9");
define("TYPE_COMPANY",   "11");

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
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

    protected function passwordHash(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
}
