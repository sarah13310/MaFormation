<?php

namespace App\Models;
use CodeIgniter\Model;

class TrainingHasPageModel extends Model
{
    protected $table = 'training_has_page';
    protected $allowedFields = ['id_training', 'id_page'];
    
}