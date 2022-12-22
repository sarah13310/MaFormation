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

        $builder->where('status', '1');
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


    public function details_article_home()
    {
        $title = "Détails de l'article";

        if ($this->request->getMethod() == 'post') {

            $id = $this->request->getVar('id_article');

            $db      = \Config\Database::connect();
            $builder = $db->table('article');
            $builder->where('id_article', $id);
            $query   = $builder->get();
            $article = $query->getResultArray();


            $builder->where('article.id_article', $id);
            $builder->join('user_has_article', 'user_has_article.id_article = article.id_article');
            $builder->join('user', 'user_has_article.id_user = user.id_user');

            $query = $builder->get();
            $user = $query->getResultArray();

            $author = [];
            foreach ($user as $u) {
                $author[] = [
                    "name" => $u['name'],
                    "firstname" => $u['firstname'],
                    "image_url" => $u['image_url'],
                ];
            }

            $data = [
                "title" => $title,
                "article" => $article,
                "author" => $author,
            ];

            return view('Articles/list_article_details.php', $data);
        }
    }

    public function list_publishes_home()
    {
        $title = "Liste des publication";
        $db      = \Config\Database::connect();
        $builder = $db->table('publication');

        $builder->where('status', '1');
        $query   = $builder->get();
        $publishes = $query->getResultArray();

        $listpublishes = [];

        foreach ($publishes as $publishe) {
            $listpublishes[] = [
                "id_publication" => $publishe['id_publication'],
                "subject" => $publishe['subject'],
                "description" => $publishe['description'],
                "datetime" => $publishe['datetime'],
            ];
        }

        /* auteur de l'article*/

        $builder->select('user.name,user.firstname');

        for ($i = 0; $i < count($listpublishes); $i++) {

            $builder->where('publication.id_publication', $listpublishes[$i]['id_publication']);
            $builder->join('publication_has_article', 'publication_has_article.id_publication = publication.id_publication');
            $builder->join('article', 'publication_has_article.id_article = article.id_article');
            $builder->join('user_has_article', 'user_has_article.id_article = article.id_article');
            $builder->join('user', 'user_has_article.id_user = user.id_user');
            $builder->groupBy('user.id_user');

            $query = $builder->get();
            $user = $query->getResultArray();

            $authors = [];
            foreach ($user as $u) {
                $authors[] = [
                    "name" => $u['name'],
                    "firstname" => $u['firstname'],
                ];
            }

            $listpublishes[$i]["user"] = $authors;
        }

        $data = [
            "title" => $title,
            "listpublishes" => $listpublishes,
        ];

        return view('Publishes/list_publishes.php', $data);
    }


    public function details_publishes_home()
    {
        $title = "Détails de la publication";

        if ($this->request->getMethod() == 'post') {

            $id = $this->request->getVar('id_publication');

            $db      = \Config\Database::connect();
            $builder = $db->table('publication');
            $builder->where('id_publication', $id);
            $query   = $builder->get();
            $publication = $query->getResultArray();


            $builder->select('article.id_article,article.subject,article.description,article.datetime');

            $builder->where('publication.id_publication', $id);
            $builder->join('publication_has_article', 'publication_has_article.id_publication = publication.id_publication');
            $builder->join('article', 'publication_has_article.id_article = article.id_article');

            $query = $builder->get();
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



            $builder->where('publication.id_publication', $id);
            $builder->join('publication_has_article', 'publication_has_article.id_publication = publication.id_publication');
            $builder->join('article', 'publication_has_article.id_article = article.id_article');
            $builder->join('user_has_article', 'user_has_article.id_article = article.id_article');
            $builder->join('user', 'user_has_article.id_user = user.id_user');
            $builder->groupBy('user.id_user');

            $query = $builder->get();
            $user = $query->getResultArray();

            $authors = [];
            foreach ($user as $u) {
                $authors[] = [
                    "name" => $u['name'],
                    "firstname" => $u['firstname'],
                    "image_url" => $u['image_url'],
                ];
            }

            $data = [
                "title" => $title,
                "publication" => $publication,
                "listarticles" => $listarticles,
                "authors" => $authors,
            ];



            return view('Publishes/list_publishes_details.php', $data);
        }
    }
}
