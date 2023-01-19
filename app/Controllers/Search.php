<?php

namespace App\Controllers;

class Search extends BaseController
{
    public function resultdata()
    {


        
        $data = [
            "title" => "Résultat",
        ];

        return view('Home/result.php', $data);
    }

}
