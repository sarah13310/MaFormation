<?php

namespace App\Libraries;

use CodeIgniter\Database\MySQLi\Builder;

class BillHelper
{    
    /**
     * getFilterBill
     *
     * Retourne les factures en fonction du profil utilisateur 
     * ou toutes les factures sans filtre
     * @param  int  $id_user (identification de l'utilisateur ou ALL)
     * @return array tableau des factures
     */
    function getFilterBill(int $id_user = ALL)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('user_has_bill');
        if ($id_user != ALL) {
            $builder->where('id_user', $id_user);
        }
        $builder->select("bill.id_bill, bill.ref_name, bill.status,bill.datetime,bill.price");
        $builder->join("bill","user_has_bill.id_bill=bill.id_bill");
        $query = $builder->get();
        $user = $query->getResultArray();
        return $user;
    }
}
