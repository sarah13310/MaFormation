<?php

namespace App\Controllers;

class DashBoard extends BaseController
{    
    public function index()
    {
        $data=["title"=>"Tableau de bord"      
        ];
        return view('Dashboard/index.php', $data);
    }
}
