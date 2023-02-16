<?php

namespace App\Models;

use CodeIgniter\Model;

// le 03/02/2023
// le 05/02/2023
class BillModel extends Model
{
    protected $table = 'bill';
    protected $primaryKey = 'id_bill';
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $allowedFields = ['id_bill', 'ref_name', 'status', 'content', 'datetime', 'video_url', 'extern_link_id_media', 'media_id_media', 'status', 'status_id_status'];
    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];
    protected $useSoftDeletes = false;

    function getFilterBill($id = ALL)
    {
        $builder = $this->db->table('bill');
        if ($id !== ALL) {
            $builder->where('id_bill', $id);
        }
        $query   = $builder->get();
        return $query->getResultArray();
    }
}
