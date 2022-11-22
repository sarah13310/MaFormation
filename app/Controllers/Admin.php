<?php

namespace App\Controllers;

class Admin extends BaseController
{    
    public function index()
    {
        $data=["title"=>"Administration"      
        ];
        return view('Admin/index.php', $data);
    }
}
