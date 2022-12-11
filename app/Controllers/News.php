<?php

namespace App\Controllers;
use App\Models\ArticleModel;
use App\Models\PublicationModel;

class News extends BaseController
{
    private function getUserSession()
    {
        $user = [
            'id_user' => session()->get('id_user'),
            'name' => session()->get('name'),
            'firstname' => session()->get('firstname'),
            'mail' => session()->get('mail'),
            'password' => session()->get('password'),
            'type' => session()->get('type'),
            'image_url' => session()->get('image_url'),
            'gender' => session()->get('gender'),
            'isLoggedIn' => true,
        ];
        return $user;
    }

    public function index()
    {
        $data = [
            "title" => "Articles"
        ];
        return view('Articles/index.php', $data);
    }

    public function publish()
    {
        $data = [
            "title" => "Publications"
        ];
        return view('Publishes/index.php', $data);
    }

    public function articles_edit()
    {
        $article = new ArticleModel();
        $user = $this->getUserSession();
        $data = [
            "title" => "Articles",
            "subtitle" => "Création et mise en ligne de vos articles.",
            "user" => $user,
        ];

        if ($this->request->getMethod() == 'post') {
            $ispublished = ($this->request->getVar('publish') == true) ? EN_COURS : BROUILLON;
            $dataSave['subject'] = $this->request->getVar('subject');
            $dataSave['description'] = $this->request->getVar('description');
            $dataSave['datetime'] = date("Y-m-d H:i:s");
            $dataSave['media_id_media'] = 0;
            $dataSave['status'] = $ispublished;
            $article->save($dataSave);
        }
        return view('Articles/articles_edit.php', $data);
    }


    public function publishes_edit()
    {
        $publish = new PublicationModel();
        $user = $this->getUserSession();
        $data = [
            "title" => "Publications",
            "subtitle" => "Création et mise en ligne de vos publications.",
            "user" => $user,
        ];

        if ($this->request->getMethod() == 'post') {
            $ispublished = ($this->request->getVar('publish') == true) ? EN_COURS : BROUILLON;
            $dataSave['subject'] = $this->request->getVar('subject');
            $dataSave['description'] = $this->request->getVar('description');
            $dataSave['datetime'] = date("Y-m-d H:i:s");
            $dataSave['article_id_article'] = 0;
            $dataSave['status'] = $ispublished;
            $publish->save($dataSave);
        }
        return view('Publishes/publishes_edit.php', $data);
    }
}
