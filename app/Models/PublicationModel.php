<?php

namespace App\Models;

use CodeIgniter\Model;

class PublicationModel extends Model
{
    protected $table = 'publication';
    protected $primaryKey = 'id_publication';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_publication',
        'subject',
        'description',
        'image_url',
        'datetime',
        'status',
        'id_tag',
    ];
}
