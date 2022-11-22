<?php

namespace App\Controllers;

class Funding extends BaseController
{    
    public function index()
    {
        $data=["title"=>"Mon financement"      
        ];
        return view('Funding/index.php', $data);
    }
}
