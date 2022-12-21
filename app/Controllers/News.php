<?php

namespace App\Controllers;

use App\Libraries\ArticleHelper;
use App\Models\ArticleModel;
use App\Models\PublicationModel;
use App\Libraries\UserHelper;
use App\Libraries\CategoryHelper;
use App\Libraries\PublishHelper;
use App\Models\PublicationHasArticleModel;
use App\Models\TagModel;
use App\Models\UserHasArticleModel;

class News extends BaseController
{
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
        $user_has_article = new UserHasArticleModel();
        //
        $user_helper = new UserHelper();
        $user = $user_helper->getUserSession();
        //
        $category_helper = new CategoryHelper();
        $categories = $category_helper->getCategories();
        //
        $publishe_helper = new PublishHelper();
        $publishes = $publishe_helper->getValidatePublishes();

        $data = [
            "title" => "Création Article",
            "subtitle" => "Création et mise en ligne de vos articles.",
            "user" => $user,
            "categories" => $categories,
            "publishes" => $publishes,
        ];

        if (isset($data['warning'])) {
            unset($data['warning']);
        }

        if (isset(session()->success)){
            session()->remove('succes');
        }

        if ($this->request->getMethod() == 'post') {

            $ispublished = ($this->request->getVar('publish') == true) ? EN_COURS : BROUILLON;
            $dataSave['subject'] = $this->request->getVar('subject');
            $dataSave['description'] = $this->request->getVar('description');
            $dataSave['category'] = $this->request->getVar('category');
            $dataSave['datetime'] = date("Y-m-d H:i:s");
            $dataSave['media_id_media'] = 0;
            $dataSave['status'] = $ispublished;
            $subject =  $dataSave['subject'] . trim("");

            $rules = [
                'subject' => 'required|min_length[6]|max_length[30]',
            ];
            $error = [
                'subject' => [
                    'required' => "Article vide!",
                    'min_length' => "Sujet trop court",
                    'max_length' => "Sujet trop long",
                ],
            ];

            if (!$this->validate($rules, $error)) {
                $data['validation'] = $this->validator;
            } else {
                $article_helper = new ArticleHelper();
                if ($article_helper->isExist($subject) == true) {
                    if (strlen($subject) > 0)
                        $data["warning"] = "Cet Article existe déjà!";
                } else {
                    // on sauve en premier le tag
                    $tag_model = new TagModel();
                    $data_tag["id_category"] = $dataSave['category'];
                    $id_tag = $tag_model->insert($data_tag);
                    $dataSave['id_tag'] = $id_tag;
                    // ensuite la table article
                    $id_article = $article->insert($dataSave);
                    $datatemp = [
                        'id_user' => session()->id_user,
                        'id_article' => $id_article,
                    ];
                    // en dernier la table intermédiaire
                    $user_has_article->save($datatemp);
                    session()->setFlashdata('success', 'Article en cours de validation...');
                }
            }
        }
        return view('Articles/articles_edit.php', $data);
    }

    public function publishes_edit()
    {
        $publish = new PublicationModel();
        $user_helper = new UserHelper();
        $user = $user_helper->getUserSession();
        $category_helper = new CategoryHelper();
        $categories = $category_helper->getCategories();

        $data = [
            "title" => "Création Publication",
            "subtitle" => "Création et mise en ligne de vos publications.",
            "user" => $user,
            "categories" => $categories,
        ];

        if (isset($data['warning'])) {
            unset($data['warning']);
        }

        if (isset(session()->success)){
            session()->remove('success');
        }
        
        if ($this->request->getMethod() == 'post') {
            $ispublished = ($this->request->getVar('publish') == true) ? EN_COURS : BROUILLON;
            $dataSave['subject'] = $this->request->getVar('subject');
            $dataSave['description'] = $this->request->getVar('description');
            $dataSave['category'] = $this->request->getVar('category');
            $dataSave['articles'] = $this->request->getVar('articles');
            $dataSave['datetime'] = date("Y-m-d H:i:s");
            $dataSave['article_id_article'] = 0;
            $dataSave['status'] = $ispublished;
            $subject =  $dataSave['subject'] . trim("");
            //
            $rules = [
                'subject' => 'required|min_length[6]|max_length[30]',
            ];
            $error = [
                'subject' => [
                    'required' => "Publication vide!",
                    'min_length' => "Sujet trop court",
                    'max_length' => "Sujet trop long",
                ],
            ];
            //
            if (!$this->validate($rules, $error)) {
                $data['validation'] = $this->validator;
            } else {
                $publishe_helper = new PublishHelper();
                if ($publishe_helper->isExist($dataSave['subject']) == true) {
                    if (strlen($subject) > 0) {
                        $data["warning"] = "Cette publication existe déjà!";
                    }
                } else {
                    // on sauve en premier le tag
                    $tag_model = new TagModel();
                    $data_tag["id_category"] = $dataSave['category'];
                    $id_tag = $tag_model->insert($data_tag);
                    $dataSave['id_tag'] = $id_tag;
                    // ensuite on enrichit la table publication    
                    $id_publication = $publish->insert($dataSave);
                    // en dernier on fait le lien entre article et publication
                    $publication_has_article = new PublicationHasArticleModel();
                    $data_temp = [
                        'id_publication' => $id_publication,
                    ];
                    $list_articles = [];

                    foreach ($list_articles as $article) {
                        $data_temp['id_article'] = $article['id_article'];
                        $publication_has_article->insert($data_temp);
                    }
                    session()->setFlashdata('success', 'Publication en cours de validation...');
                }
            }
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
}
