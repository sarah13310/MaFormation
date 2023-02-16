<?php

namespace App\Models;
use CodeIgniter\Model;
// le 05/02/2023
class StatusModel extends Model
{
    protected $table = 'status';
    protected $allowedFields = ['id_status', 'name'];
    
    
    
}