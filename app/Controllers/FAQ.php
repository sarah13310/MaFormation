<?php

namespace App\Controllers;

class FAQ extends BaseController
{
    
    public function index()
    {
        $data=["title"=>"F.A.Q."      
        ];
        return view('FAQ/index.php', $data);
    }
}
