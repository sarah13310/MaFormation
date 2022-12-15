<?php

namespace App\Models;
use CodeIgniter\Model;

class ArticleModel extends Model
{
    protected $table = 'article';
    protected $primaryKey = 'former_id';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id_article', 'subject', 'description', 'datetime', 'media_id_media','status'];   
   
    
}