<?php

namespace App\Models;

use CodeIgniter\Model;

class PublicationHasArticleModel extends Model
{
    protected $table = 'publication_has_article';
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id_publication',
        'id_article',
    ];
}
