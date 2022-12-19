<?php

namespace App\Models;

use CodeIgniter\Model;

class TrainingModel extends Model
{
    protected $table = 'training';
    protected $primaryKey = 'id_training';

    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'title',
        "description",
        "date",
        "duration",
        "rating",
        "bill_id_bill",
        "type_slide_id_type",
        "status_id_status",
        "id_tag"
    ];
}
