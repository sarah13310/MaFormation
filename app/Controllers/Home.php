<?php

namespace App\Controllers;

class Home extends BaseController
{
    
    public function index()
    {
        $data=["title"=>"Accueil"      
        ];
        return view('Home/index.php', $data);
    }
}
