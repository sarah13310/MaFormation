<?php

namespace App\Controllers;

class Former extends BaseController
{
    public function index()
    {
        $data=["title"=>"Les formateurs"      
        ];
        return view('Former/index.php', $data);
    }
}
?>
