<?php

namespace App\Controllers;

class User extends BaseController
{    
    public function customer()
    {
        $data=["title"=>"Adhérents particuliers"      
        ];
        return view('User/customer.php', $data);
    }

    public function business()
    {
        $data=["title"=>"Adhérents entreprise"      
        ];
        return view('User/business.php', $data);
    }
}
