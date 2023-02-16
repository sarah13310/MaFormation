<?php

namespace App\Models;

use CodeIgniter\Model;
// le 05/02/2023
class CertificateModel extends Model
{
    protected $table = 'certificate';
    protected $primaryKey = 'id_certificate';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_certificate',
        'name',
        'content',
        'date',
        'organism',
        'address',
        'city',
        'cp',
        'country'
    ];
}
