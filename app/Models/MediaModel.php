<?php

namespace App\Models;
use CodeIgniter\Model;

class MediaModel extends Model
{
    protected $table = 'media';
    protected $primaryKey = 'id_media';

    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['name', 'url', 'type','status','status_id_status'];
    
    
}