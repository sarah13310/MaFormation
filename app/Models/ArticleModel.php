<?php

namespace App\Models;
use CodeIgniter\Model;

class ArticleModel extends Model
{
    protected $table = 'article';
    protected $primaryKey = 'id_article';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_article',
        'subject',
        'description',
        'image_url',
        'datetime',
        'media_id_media',
        'status',
        'id_tag',
    ];
}
