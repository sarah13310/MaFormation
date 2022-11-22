<?php

namespace App\Controllers;

class Contact extends BaseController
{
    public function index()
    {
        $data=["title"=>"Me Contacter"      
        ];
        return view('Home/index.php',$data);
    }
}
?>
