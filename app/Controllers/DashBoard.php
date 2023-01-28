<?php

namespace App\Controllers;




class DashBoard extends BaseController
{
    public function listformerarticles()
    {

        // on récupère la sessions associé à cet utilisateur
        $session = $this->user_model->getUserSession();
        // on récupère la requete pour user
        $public = $this->user_model->getFilterUser();
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
        $user = $this->user_model->getUserSession();
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

        $user = $this->user_model->getUserSession();
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
        $user = $this->user_model->getUserSession();
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

        $public = $this->article_model->getArticles();
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

        $user = $this->user_model->getUserSession();
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

        $user = $this->user_model->getUserSession();

        $data = [
            "title" => $title,
            "publishes" => $listpublishes,
            "user" => $user,
            "headerColor" => getTheme(session()->type, "header"),
        ];
        return view('Admin/list_publishes_admin.php', $data);
    }

    public function previewarticle()
    {
        $title = "Aperçu de l'article";
        if ($this->isPost()) {

            $id = $this->request->getVar('id_article');

            $db      = \Config\Database::connect();
            $builder = $db->table('article');
            $builder->where('id_article', $id);
            $query   = $builder->get();
            $article = $query->getResultArray();
            $article = $article[0];


            $user = $this->user_model->getUserSession();
            if ($article["image_url"] == null) {
                $article["image_url"] = base_url() . "/assets/article.svg";
            }
            $data = [
                "title" => $title,
                "article" => $article,
                "user" => $user,
                "buttonColor" => getTheme(session()->type, "button"),
            ];
            return view('Articles/preview_article.php', $data);
        }
    }

    public function previewpublish()
    {
        $title = "Aperçu de la publication";

        if ($this->isPost()) {

            $id = $this->request->getVar('id_publication');
            $publication = $this->publication_model->getPublisheById($id);

            $user = $this->user_model->getUserSession();

            if ($user["image_url"] == null) {
                $user["image_url"] = base_url() . "/assets/Blank.png";
            }

            if ($publication["image_url"] == null) {
                $publication["image_url"] = base_url() . "/assets/publication.svg";
            }

            $data = [
                "title" => $title,
                "publication" => $publication,
                "user" => $user,
                "buttonColor" => getTheme(session()->type, "button"),
            ];
            return view('Publishes/preview_publish.php', $data);
        }
    }

    public function listmedias($type)
    {
        switch ($type) {
            case VIDEO:
                $title = "Liste des vidéos";
                $public = $this->media_model->getVideos();
                $builder = $public['builder'];
                $medias = $public['videos'];
                break;
            case BOOK:
                $title = "Liste des livres";
                $public = $this->media_model->getBooks();
                $builder = $public['builder'];
                $medias = $public['books'];
                break;
        }

        $listmedias = [];
        $listmedias = $this->media_model->returnDataMedias($listmedias, $medias);

        $listmedias = $this->media_model->getAuthorsMedias($listmedias, $builder);

        $user = $this->user_model->getUserSession();
        $data = [
            "title" => $title,
            "listmedias" => $listmedias,
            "user" => $user,
            "type" => session()->type,
        ];
        return view('Admin/list_medias_admin.php', $data);
    }

    public function listformermedias($type)
    {

        // on récupère la sessions associé à cet utilisateur
        $session = $this->user_model->getUserSession();
        // on récupère la requete pour user
        $public = $this->user_model->getFilterUser();

        switch ($type) {
            case VIDEO:
                $title = "Liste des vidéos";
                break;
            case BOOK:
                $title = "Liste des livres";
                break;
        }

        $builder = $public['builder'];
        $medias = $this->media_model->getAuthorMedias($session, $builder, $type);
        $listmedias = [];
        $listmedias = $this->media_model->returnDataMedias($listmedias, $medias);

        $data = [
            "title" => $title,
            "listmedias" => $listmedias,
            "user" => $session,
            "type" => session()->type,
        ];
        return view('Former/list_medias_former.php', $data);
    }


    public function dashboard_article()
    {
        $title = "Tableau des articles";

        $public = $this->article_model->getArticles();
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
            $author = [];
            if ($user == null) {
                $author = [
                    "name" => "Inconnu",
                    "firstname" => "",
                ];
            } else {
                $user = $user[0];
                $author = [
                    "name" => $user['name'],
                    "firstname" => $user['firstname'],
                ];
            }
            $listarticles[$i]["author"] = $author;
        }

        $user = $this->user_model->getUserSession();
        $data = [
            "title" => $title,
            "articles" => $listarticles,
            "user" => $user,
            "type" => session()->type,
            "headerColor" => getTheme(session()->type, "header"),
            "buttonColor" => getTheme(session()->type, "button"),
        ];
        return view('Admin/dashboard_article_admin.php', $data);
    }
    // tableau de bord des publications
    public function dashboard_publishes()
    {
        $title = "Tableau des publications";
        $listpublishes = [];
        $publishes = $this->publication_model->getFilterPublishes();

        foreach ($publishes as $publishe) {
            $articles = $this->publication_model->getFilterArticles($publishe['id_publication']);
            //print_r($articles);
            $listpublishes[] = [
                "id_publication" => $publishe['id_publication'],
                "subject" => $publishe['subject'],
                "description" => $publishe['description'],
                "datetime" => $publishe['datetime'],
                "articles" => $articles,
                "user" => [],
            ];
        }
        //die();

        /* $builder->select('user.name,user.firstname');

        for ($i = 0; $i < count($listpublishes); $i++) {

            $builder->where('publication.id_publication', $listpublishes[$i]['id_publication']);
            $builder->join('publication_has_article', 'publication_has_article.id_publication = publication.id_publication');
            $builder->join('article', 'publication_has_article.id_article = article.id_article');
            $builder->join('user_has_article', 'user_has_article.id_article = article.id_article');
            $builder->join('user', 'user_has_article.id_user = user.id_user');
            $builder->groupBy('user.id_user');

            $query = $builder->get();
            $user = $query->getResultArray();
*/
        /* auteur de l'article*/
        $authors = [];
        /*foreach ($user as $u) {

                $authors[] = [
                    "name" => $u['name'],
                    "firstname" => $u['firstname'],
                ];
            }
            if (count($authors)==0){
                $authors[]="Inconnu";
            }*/

        /*$listpublishes[$i]["user"] = $authors;

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
*/

        $user = $this->user_model->getUserSession();

        $data = [
            "title" => $title,
            "publishes" => $listpublishes,
            "user" => $user,
            "buttonColor" => getTheme(session()->type, "button"),
            "headerColor" => getTheme(session()->type, "header"),
        ];
        return view('Admin/dashboard_publishes_admin.php', $data);
    }

    /**
     * training
     * Tableau des formations (dashboard)
     * @return void
     */
    public function training()
    {
        $title = "Tableau des formations";
        $user = $this->user_model->getUserSession();
        $trainings = $this->training_model->getFilterTrainings();
        $listraining = [];
        session()->title_training = "";
        session()->id_training = "";

        foreach ($trainings as $training) {
            $pages = [];
            $listraining[] = [
                "id_training" => $training['id_training'],
                "title" => $training['title'],
                "description" => $training['description'],
                "image_url" => $training['image_url'],
                "date" => $training['date'],
                "pages" => $pages,
            ];
        }
        $data = [
            "title" => $title,
            "trainings" => $listraining,
            "user" => $user,
            "buttonColor" => getTheme(session()->type, "button"),
            "headerColor" => getTheme(session()->type, "header"),
        ];
        return view('Admin/dashboard_training_admin.php', $data);
    }

    /**
     * preview_training
     *
     * @return void
     */
    public function preview_training()
    {
        $title = "Gestion des pages";
        $user = $this->user_model->getUserSession();
        $listPages = [];

        if ($this->isPost()) {
            $title_training = $this->request->getVar('title');
            $id_training = $this->request->getVar('id_training');
            $pages = $this->training_model->getFilterPages($id_training);
            // map sur le tableau si nécessaire
            foreach ($pages as $page) {

                $listPages[] = [
                    "id_page" => $page['id_page'],
                    "title" => $page['title'],
                    "content" => $page['content'],
                    "image_url" => $page['image_url'],
                    "video_url" => $page['video_url'],
                ];
            }
            
            session()->title_training = $title_training;
            session()->id_training = $id_training;
        }

        $data = [
            "title" => $title,
            "title_training" => $title_training,
            "pages" => $listPages,
            "user" => $user,
            "buttonColor" => getTheme(session()->type, "button"),
            "headerColor" => getTheme(session()->type, "header"),
            "id_training" => $id_training,
        ];
        return view('Admin/dashboard_page.php', $data);
    }
}
