<?php

namespace App\Controllers;

class Media extends BaseController
{
    public function books()
    {
        $data=["title"=>"Livres"      
        ];
        return view('Media/books.php', $data);
    }
    
    public function videos()
    {
        $data=["title"=>"Vidéos"      
        ];
        return view('Media/videos.php', $data);
    }
}
?>
