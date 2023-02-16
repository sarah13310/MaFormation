<?php

namespace App\Models;

use CodeIgniter\Model;
// le 05/02/2023
class ContactModel extends Model
{
    protected $table = 'contact';
    protected $primaryKey = 'id_contact';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_contact',
        'object',
        'content',
        'datetime',
        'name'
    ];
}
