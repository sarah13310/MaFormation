<?php

namespace App\Controllers;

class Media extends BaseController
{
    // Gestion des diapos
    public function slides()
    {
        $data=["title"=>"Diapos"      
        ];
        return view('/Media/slides.php', $data);
    }

    // Gestion des livres
    public function books()
    {
        $data=["title"=>"Livres"      
        ];
        return view('/Media/books.php', $data);
    }

    // Gestion des vidéos
    public function videos()
    {
        $data=["title"=>"Vidéos"      
        ];
        return view('/Media/videos.php', $data);
    }
}
?>
