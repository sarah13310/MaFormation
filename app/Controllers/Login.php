<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index()
    {
        $data=["title"=>"Connexion"      
        ];
        return view('Login/index.php', $data);
    }

    public function signin()
    {
        $data=["title"=>"Inscription"      
        ];
        return view('Login/signin.php', $data);
    }
}
?>
