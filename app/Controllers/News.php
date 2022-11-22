<?php

namespace App\Controllers;

class News extends BaseController
{
    public function index()
    {
        $data=["title"=>"Articles"      
        ];
        return view('Articles/index.php', $data);
    }

    public function publish()
    {
        $data=["title"=>"Publications"      
        ];
        return view('Publishes/index.php', $data);
    }
}
?>
