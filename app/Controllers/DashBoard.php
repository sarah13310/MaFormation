<?php

namespace App\Controllers;

use App\Libraries\ArticleHelper;

class DashBoard extends BaseController
{

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

        $data = [
            "title" => $title,
            "listformers" => $listformers,
            "jobs" => $jobs,
        ];

        return view('Admin/list_former_admin.php', $data);
    }

    public function listpublishes()
    {

        $title = "Liste des publications";

        $db      = \Config\Database::connect();
        $builder = $db->table('publication');
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

        $data = [
            "title" => $title,
            "listpublishes" => $listpublishes,
        ];


        return view('Admin/list_publishes_admin.php', $data);
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

        $data = [
            "title" => $title,
            "listarticles" => $listarticles,
        ];

        return view('Admin/list_article_admin.php', $data);
    }


    public function listformerpublishes()
    {

        $title = "Liste des publications";

        $db      = \Config\Database::connect();
        $builder = $db->table('user');

        $builder->select('publication.id_publication,publication.subject,publication.description,publication.datetime');

        $builder->where('user.id_user', '36');
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

            $builder->where('user.id_user', '36');
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
        ];


        return view('Former/list_publishes_former.php', $data);
    }

    public function listformerarticles()
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

        $data = [
            "title" => $title,
            "listarticles" => $listarticles,
        ];

        return view('Former/list_article_former.php', $data);
    }


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

        $user = $this->getUserSession();

        $data = [
            "title" => $title,
            "listformers" => $listformers,
            "jobs" => $jobs,
            "user" => $user,
        ];

        return view('Admin/list_privileges.php', $data);
    }
}
