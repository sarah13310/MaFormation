<?php

namespace App\Controllers;

class Training extends BaseController
{
    public function index()
    {
        $data=["title"=>"Les formations"      
        ];
        return view('Training/index.php', $data);
    }
}
?>
