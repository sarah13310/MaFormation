<?php

namespace App\Models;
use CodeIgniter\Model;
// le 05/02/2023
class TrainingHasPageModel extends Model
{
    protected $table = 'training_has_page';
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_training', 'id_page'];
 
    function Remove($data){
        $db      = \Config\Database::connect();
        $builder = $db->table('training_has_page');
        $builder->where("id_training", $data["id_training"]);    
        $builder->where("id_page", $data["id_page"]);
        $builder->delete();
       
    }
}