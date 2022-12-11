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

    protected $allowedFields = ['subject', 'description', 'datetime','article_id_article','status'];
   
    
}