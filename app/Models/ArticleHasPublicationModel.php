<?php

namespace App\Models;
use CodeIgniter\Model;
// le 05/02/2023
class ArticleHasPublicationModel extends Model
{
    protected $table = 'article_has_publication';
    protected $allowedFields = ['id_article', 'id_publication'];    
}