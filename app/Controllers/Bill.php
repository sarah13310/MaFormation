<?php

namespace App\Controllers;

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
