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

    public function articlesedit()
    {
        $data=[
            "title"=>"Articles", 
            "subtitle"=>"Création et modification de vos articles.",     
        ];
        return view('Articles/articles_edit.php', $data);
    }

    public function publishesedit()
    {
        $data=[
            "title"=>"Publications"   ,
            "subtitle"=>"Création et modification de vos publications.",     
        ];
        return view('Publishes/publishes_edit.php', $data);
    }

}
?>
