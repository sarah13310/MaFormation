<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index()
    {
        $data = [
            "title" => "Administration"
        ];
        return view('Admin/index.php', $data);
    }

    public function profile()
    {
        $jobs = [
            ["nom"=>"Spotify New York", "adresse"=> "170 William Street<br>New York, NY 10038-344-678-001"],
            ["nom"=>"Plaisance", "adresse" => "55 George Street<br>New York, NY 10036-344-978-006"],
            ["nom"=>"Shazam Limited", "adresse" => "236 Gloria Street<br>New York, NY 10037-555-978-016"],
        ];
        $data = [
            "title" => "Votre Profile",
            "name" => "Davis ",
            "firstname" => "Gina",
            "city" => "Paris",
            "country" => "France",
            "current_job" => "Formatrice Php",
            "jobs" => $jobs,
        ];
        return view('Admin/profile.php', $data);
    }
}
