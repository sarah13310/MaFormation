<?php

namespace App\Controllers;

// le 03/02/2023

class Bill extends BaseController
{
    public function index()
    {
        $data=["title"=>"Facturation"      
        ];
        return view('Bill/index.php', $data);
    }
}
?>
