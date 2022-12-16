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

    public function list_articles_home()
    {
        $title = "Liste des articles";
        $db      = \Config\Database::connect();
        $builder = $db->table('article');   
        
        $status=1;
        
        $builder->where('status', $status);
        $query   = $builder->get();
        $articles = $query->getResultArray();

        $listarticles = [];

        foreach ($articles as $article) {
            $listarticles[] = [
                "id_article" => $article['id_article'],
                "subject" => $article['subject'],
                "description" => $article['description'],
                "datetime" => $article['datetime'],
            ];
        }

        /* auteur de l'article*/

        $builder->select('user.name,user.firstname');

        for ($i = 0; $i < count($listarticles); $i++) {
            $builder->where('article.id_article', $listarticles[$i]['id_article']);
            $builder->join('user_has_article', 'user_has_article.id_article = article.id_article');
            $builder->join('user', 'user_has_article.id_user = user.id_user');

            $query = $builder->get();
            $user = $query->getResultArray();

            $authors = [];
            foreach ($user as $u) {
                $authors[] = [
                    "name" => $u['name'],
                    "firstname" => $u['firstname'],
                ];
            }

            $listarticles[$i]["user"] = $authors;
        }

        $data = [
            "title" => $title,
            "listarticles" => $listarticles,
        ];

        return view('Articles/list_article.php', $data);
    }


    public function details_former_home()
    {
        $title = "Cv du formateur";

        if ($this->request->getMethod() == 'post') {

            $mail = $this->request->getVar('mail');

            $db      = \Config\Database::connect();
            $builder = $db->table('user');
            $builder->where('mail', $mail);
            $query   = $builder->get();
            $former = $query->getResultArray();


            $id = $former[0]['id_user'];


            $builder->where('user.id_user', $id);
            $builder->join('user_has_certificate', 'user_has_certificate.id_user = user.id_user');
            $builder->join('certificate', 'user_has_certificate.id_certificate = certificate.id_certificate');

            $query = $builder->get();
            $certificates = $query->getResultArray();

            $skills = [];
            foreach ($certificates as $certificate) {
                $skills[] = [
                    "name" => $certificate['name'],
                    "content" => $certificate['content'],
                    "date" => $certificate['date'],
                    "organism" => $certificate['organism'],
                    "address" => $certificate['address'],
                    "city" => $certificate['city'],
                    "cp" => $certificate['cp'],
                    "country" => $certificate['country'],
                ];
            }

            $data = [
                "title" => $title,
                "former" => $former,
                "skills" => $skills,
            ];

            return view('Former/list_former_cv.php', $data);
        }
    }
}
