<?php

namespace App\Controllers;

use App\Libraries\UserHelper;
use App\Libraries\ArticleHelper;
use App\Libraries\BookHelper;
use App\Libraries\VideoHelper;

require_once($_SERVER['DOCUMENT_ROOT'] . '/php/functions/util.php');
class DashBoard extends BaseController
{
    public function listformerarticles()
    {
        $user_helper = new UserHelper();
        // on récupère la sessions associé à cet utilisateur
        $session = $user_helper->getUserSession();
        // on récupère la requete pour user
        $public = $user_helper->getFilterUser();
        //
        $title = "Liste des articles";
        $builder = $public['builder'];
        $builder->where("user.id_user", $session['id_user']);
        $builder->join('user_has_article', 'user_has_article.id_user = user.id_user');
        $builder->join('article', 'user_has_article.id_article = article.id_article');
        $query   = $builder->get();
        $articles = $query->getResultArray();
        $listarticles = [];
        //
        foreach ($articles as $article) {
            $listarticles[] = [
                "id_article" => $article['id_article'],
                "subject" => $article['subject'],
                "description" => $article['description'],
                "datetime" => $article['datetime'],
            ];
        }
        //
        $data = [
            "title" => $title,
            "listarticles" => $listarticles,
            "user" => $session,
        ];
        return view('Former/list_article_former.php', $data);
    }

    public function listformerpublishes()
    {
        $user_helper = new UserHelper();
        $user = $user_helper->getUserSession();
        //
        $title = "Liste des publications";
        $db      = \Config\Database::connect();
        $builder = $db->table('user');
        $builder->select('publication.id_publication,publication.subject,publication.description,publication.datetime');
        $builder->where('user.id_user', $user['id_user']);
        $builder->join('user_has_article', 'user_has_article.id_user = user.id_user');
        $builder->join('article', 'user_has_article.id_article = article.id_article');
        $builder->join('publication_has_article', 'publication_has_article.id_article = article.id_article');
        $builder->join('publication', 'publication_has_article.id_publication = publication.id_publication');
        $builder->groupBy('publication.id_publication');
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

        for ($i = 0; $i < count($listpublishes); $i++) {

            $builder->select('article.id_article,article.subject,article.description,article.datetime');
            $builder->where('user.id_user',  $user['id_user']);
            $builder->join('user_has_article', 'user_has_article.id_user = user.id_user');
            $builder->join('article', 'user_has_article.id_article = article.id_article');
            $builder->join('publication_has_article', 'publication_has_article.id_article = article.id_article');
            $builder->join('publication', 'publication_has_article.id_publication = publication.id_publication');
            $builder->where('publication.id_publication', $listpublishes[$i]['id_publication']);
            $query = $builder->get();
            $articles = $query->getResultArray();

            $news = [];
            foreach ($articles as $article) {
                $news[] = [
                    "id_article" => $article['id_article'],
                    "subject" => $article['subject'],
                    "description" => $article['description'],
                    "datetime" => $article['datetime'],
                ];
            }
            $listpublishes[$i]["article"] = $news;
        }


        $data = [
            "title" => $title,
            "listpublishes" => $listpublishes,
            "user" => $user,
        ];

        return view('Former/list_publishes_former.php', $data);
    }

    public function listformers()
    {


        $title = "Liste des formateurs";
        $db      = \Config\Database::connect();
        $builder = $db->table('user');
        $type = 7;
        $builder->where('type', $type);
        $query   = $builder->get();
        $formers = $query->getResultArray();

        $listformers = [];

        foreach ($formers as $former) {
            $listformers[] = [
                "id_user" => $former['id_user'],
                "name" => $former['name'],
                "firstname" => $former['firstname'],
                "address" => $former['address'],
                "city" => $former['city'],
                "cp" => $former['cp'],
                "country" => $former['country'],
                "mail" => $former['mail'],
                "phone" => $former['phone'],
            ];
        }
        /* compétences certificats*/
        $builder->select('certificate.name,certificate.content,certificate.date,certificate.organism,certificate.address,certificate.city,certificate.cp,certificate.country');
        $skills = [];

        for ($i = 0; $i < count($listformers); $i++) {
            $builder->where('user.id_user', $listformers[$i]['id_user']);
            $builder->join('user_has_certificate', 'user_has_certificate.id_user = user.id_user');
            $builder->join('certificate', 'user_has_certificate.id_certificate = certificate.id_certificate');

            $query = $builder->get();
            $certificates = $query->getResultArray();

            $certi = [];
            foreach ($certificates as $certificate) {
                $certi[] = [
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
            $listformers[$i]["skills"] = $certi;
        }
        $builder->select('company.name, company.address,company.city ,company.cp,company.country');
        $builder->join('user_has_company', 'user_has_company.id_user = user.id_user');
        $builder->join('company', 'user_has_company.id_company=company.id_company');
        $query = $builder->get();
        $companies = $query->getResultArray();

        $jobs = [];
        foreach ($companies as $company) {
            $jobs[] = [
                "name" => $company['name'],
                "address" => $company['address'],
                "city" => $company['city'],
                "cp" => $company['cp'],
                "country" => $company['country'],
            ];
        }
        $user_helper = new UserHelper();
        $user = $user_helper->getUserSession();
        $data = [
            "title" => $title,
            "listformers" => $listformers,
            "jobs" => $jobs,
            "user" => $user,
            "headerColor" => getTheme($user['type'], "header"),
        ];

        return view('Admin/list_former_admin.php', $data);
    }

    public function privileges()
    {
        $user_helper = new UserHelper();
        $title = "Liste des privilèges";
        $db      = \Config\Database::connect();
        $builder = $db->table('user');
        $type = 3;
        $typed = 5;
        $builder->where('type', $type);
        $builder->orWhere('type', $typed);
        $query   = $builder->get();
        $formers = $query->getResultArray();
        $listformers = [];

        foreach ($formers as $former) {
            $listformers[] = [
                "id_user" => $former['id_user'],
                "name" => $former['name'],
                "firstname" => $former['firstname'],
                "address" => $former['address'],
                "city" => $former['city'],
                "cp" => $former['cp'],
                "country" => $former['country'],
                "mail" => $former['mail'],
                "phone" => $former['phone'],
                "type" => $former['type'],
                "rights" => $former['rights'],
            ];
        }

        /* compétences certificats*/
        $builder->select('certificate.name,certificate.content,certificate.date,certificate.organism,certificate.address,certificate.city,certificate.cp,certificate.country');
        $skills = [];

        for ($i = 0; $i < count($listformers); $i++) {
            $builder->where('user.id_user', $listformers[$i]['id_user']);
            $builder->join('user_has_certificate', 'user_has_certificate.id_user = user.id_user');
            $builder->join('certificate', 'user_has_certificate.id_certificate = certificate.id_certificate');
            $query = $builder->get();
            $certificates = $query->getResultArray();

            $certi = [];
            foreach ($certificates as $certificate) {
                $certi[] = [
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
            $listformers[$i]["skills"] = $certi;
        }
        //
        $builder->select('company.name, company.address,company.city ,company.cp,company.country');
        $builder->join('user_has_company', 'user_has_company.id_user = user.id_user');
        $builder->join('company', 'user_has_company.id_company=company.id_company');
        $query = $builder->get();
        $companies = $query->getResultArray();
        //
        $jobs = [];
        foreach ($companies as $company) {
            $jobs[] = [
                "name" => $company['name'],
                "address" => $company['address'],
                "city" => $company['city'],
                "cp" => $company['cp'],
                "country" => $company['country'],
            ];
        }
        $user = $user_helper->getUserSession();
        //
        $data = [
            "title" => $title,
            "listformers" => $listformers,
            "jobs" => $jobs,
            "user" => $user,
            "type=" => $user['type'],
            "headerColor" => getTheme(session()->type, "header"),
        ];
        return view('Admin/list_privileges.php', $data);
    }


    public function listarticles()
    {
        $title = "Liste des articles";

        $article_helper = new ArticleHelper();
        $public = $article_helper->getArticles();
        $builder = $public['builder'];
        $articles = $public['articles'];
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
        $user_helper = new UserHelper();
        $user = $user_helper->getUserSession();
        $data = [
            "title" => $title,
            "listarticles" => $listarticles,
            "user" => $user,
            "type" => session()->type,
            "headerColor" => getTheme(session()->type, "header"),
        ];
        return view('Admin/list_article_admin.php', $data);
    }

    public function listpublishes()
    {

        $title = "Liste des publications";

        $db      = \Config\Database::connect();
        $builder = $db->table('publication');
        $query   = $builder->get();
        $publishes = $query->getResultArray();
        //
        $listpublishes = [];
        foreach ($publishes as $publishe) {
            $listpublishes[] = [
                "id_publication" => $publishe['id_publication'],
                "subject" => $publishe['subject'],
                "description" => $publishe['description'],
                "datetime" => $publishe['datetime'],
            ];
        }

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

            /* auteur de l'article*/
            $authors = [];
            foreach ($user as $u) {
                $authors[] = [
                    "name" => $u['name'],
                    "firstname" => $u['firstname'],
                ];
            }
            $listpublishes[$i]["user"] = $authors;

            $builder->select('article.id_article,article.subject,article.description,article.datetime');


            $builder->where('publication.id_publication', $listpublishes[$i]['id_publication']);
            $builder->join('publication_has_article', 'publication_has_article.id_publication = publication.id_publication');
            $builder->join('article', 'publication_has_article.id_article = article.id_article');

            $query = $builder->get();
            $articles = $query->getResultArray();

            $news = [];
            foreach ($articles as $article) {
                $news[] = [
                    "id_article" => $article['id_article'],
                    "subject" => $article['subject'],
                    "description" => $article['description'],
                    "datetime" => $article['datetime'],
                ];
            }

            $listpublishes[$i]["article"] = $news;
        }
        $user_helper = new UserHelper();
        $user = $user_helper->getUserSession();

        $data = [
            "title" => $title,
            "listpublishes" => $listpublishes,
            "user" => $user,
        ];


        return view('Admin/list_publishes_admin.php', $data);
    }

    public function previewarticle()
    {
        $title = "Aperçu de l'article";

        if ($this->request->getMethod() == 'post') {

            $id = $this->request->getVar('id_article');

            $db      = \Config\Database::connect();
            $builder = $db->table('article');
            $builder->where('id_article', $id);
            $query   = $builder->get();
            $article = $query->getResultArray();
            $article = $article[0];

            $user_helper = new UserHelper();
            $user = $user_helper->getUserSession();
            if ($article["image_url"] == null) {
                $article["image_url"] = base_url() . "/assets/article.svg";
            }
            $data = [
                "title" => $title,
                "article" => $article,
                "user" => $user,
            ];
            return view('Articles/preview_article.php', $data);
        }
    }

    public function previewpublish()
    {
        $title = "Aperçu de la publication";

        if ($this->request->getMethod() == 'post') {

            $id = $this->request->getVar('id_publication');

            $db      = \Config\Database::connect();
            $builder = $db->table('publication');
            $builder->where('id_publication', $id);
            $query   = $builder->get();
            $publication = $query->getResultArray();
            $user_helper = new UserHelper();
            $user = $user_helper->getUserSession();

            if ($user["image_url"] == null) {
                $user["image_url"] = base_url() . "/assets/publication.svg";
            }
            $data = [
                "title" => $title,
                "publication" => $publication,
                "user" => $user,
            ];
            return view('Publishes/preview_publish.php', $data);
        }
    }

    public function listvideos()
    {
        $title = "Liste des vidéos";

        $video_helper = new VideoHelper();
        $public = $video_helper->getVideos();
        $builder = $public['builder'];
        $videos = $public['videos'];
        $listvideos = [];

        foreach ($videos as $video) {
            $listvideos[] = [
                "id_media" => $video['id_media'],
                "name" => $video['name'],
                "description" => $video['description'],
                "author" => $video['author'],
                "url" => $video['url'],
            ];
        }

        /* auteur de l'article*/
        $builder->select('user.name,user.firstname');

        for ($i = 0; $i < count($listvideos); $i++) {
            $builder->where('media.id_media', $listvideos[$i]['id_media']);
            $builder->join('user_has_media', 'user_has_media.id_media = media.id_media');
            $builder->join('user', 'user_has_media.id_user = user.id_user');
            $query = $builder->get();
            $user = $query->getResultArray();

            $authors = [];
            foreach ($user as $u) {
                $authors[] = [
                    "name" => $u['name'],
                    "firstname" => $u['firstname'],
                ];
            }
            $listvideos[$i]["user"] = $authors;
        }

        $user_helper = new UserHelper();
        $user = $user_helper->getUserSession();
        $data = [
            "title" => $title,
            "listvideos" => $listvideos,
            "user" => $user,
            "type" => session()->type,
        ];
        return view('Admin/list_videos_admin.php', $data);
    }

    public function listbooks()
    {
        $title = "Liste des livres";

        $book_helper = new BookHelper();
        $public = $book_helper->getBooks();
        $builder = $public['builder'];
        $books = $public['books'];
        $listbooks = [];

        foreach ($books as $book) {
            $listbooks[] = [
                "id_media" => $book['id_media'],
                "name" => $book['name'],
                "description" => $book['description'],
                "author" => $book['author'],
                "url" => $book['url'],
            ];
        }

        /* auteur de l'article*/
        $builder->select('user.name,user.firstname');

        for ($i = 0; $i < count($listbooks); $i++) {
            $builder->where('media.id_media', $listbooks[$i]['id_media']);
            $builder->join('user_has_media', 'user_has_media.id_media = media.id_media');
            $builder->join('user', 'user_has_media.id_user = user.id_user');
            $query = $builder->get();
            $user = $query->getResultArray();

            $authors = [];
            foreach ($user as $u) {
                $authors[] = [
                    "name" => $u['name'],
                    "firstname" => $u['firstname'],
                ];
            }
            $listbooks[$i]["user"] = $authors;
        }

        $user_helper = new UserHelper();
        $user = $user_helper->getUserSession();
        $data = [
            "title" => $title,
            "listbooks" => $listbooks,
            "user" => $user,
            "type" => session()->type,
        ];
        return view('Admin/list_books_admin.php', $data);
    }

    public function listformervideos()
    {
        $user_helper = new UserHelper();
        // on récupère la sessions associé à cet utilisateur
        $session = $user_helper->getUserSession();
        // on récupère la requete pour user
        $public = $user_helper->getFilterUser();
        //
        $title = "Liste des videos";
        $builder = $public['builder'];
        $builder->where("user.id_user", $session['id_user']);
        $builder->join('user_has_media', 'user_has_media.id_user = user.id_user');
        $builder->join('media', 'user_has_media.id_media = media.id_media');
        $builder->where('media.type', VIDEO);
        $query   = $builder->get();
        $videos = $query->getResultArray();

        $listvideos = [];
        //
        foreach ($videos as $video) {
            $listvideos[] = [
                "id_media" => $video['id_media'],
                "name" => $video['name'],
                "description" => $video['description'],
                "author" => $video['author'],
                "url" => $video['url'],
            ];
        }

        $data = [
            "title" => $title,
            "listvideos" => $listvideos,
            "user" => $session,
        ];
        return view('Admin/list_videos_admin.php', $data);
    }

    public function listformerbooks()
    {
        $user_helper = new UserHelper();
        // on récupère la sessions associé à cet utilisateur
        $session = $user_helper->getUserSession();
        // on récupère la requete pour user
        $public = $user_helper->getFilterUser();
        //
        $title = "Liste des livres";
        $builder = $public['builder'];
        $builder->where("user.id_user", $session['id_user']);
        $builder->join('user_has_media', 'user_has_media.id_user = user.id_user');
        $builder->join('media', 'user_has_media.id_media = media.id_media');
        $builder->where('media.type', BOOK);
        $query   = $builder->get();
        $books = $query->getResultArray();

        $listbooks = [];
        //
        foreach ($books as $book) {
            $listbooks[] = [
                "id_media" => $book['id_media'],
                "name" => $book['name'],
                "description" => $book['description'],
                "author" => $book['author'],
                "url" => $book['url'],
            ];
        }

        $data = [
            "title" => $title,
            "listbooks" => $listbooks,
            "user" => $session,
        ];
        return view('Admin/list_books_admin.php', $data);
    }
}
