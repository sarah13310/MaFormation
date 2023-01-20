<?php

namespace App\Controllers;

// le 20/01/2023
class News extends BaseController
{

    public function articles_edit()
    {        
        //        
        $user = $this->user_model->getUserSession();
        //        
        $categories = $this->category_model->getCategories();
        //        
        $publishes = $this->publication_model->getFilterPublishes(ALL);

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

        if (isset(session()->success)) {
            session()->remove('succes');
        }

        if ($this->request->getMethod() == 'post') {     
            

            $ispublished = ($this->request->getVar('publish') == true) ? EN_COURS : BROUILLON;
            switch (session()->type) {
                case ADMIN:
                case SUPER_ADMIN:
                    $ispublished = VALIDE;
                    break;
            }
            $dataSave['subject'] = $this->request->getVar('subject');
            $dataSave['description'] = $this->request->getVar('description');
            $id_publish = $this->request->getVar('select_training'); // on récupère l'id de la publication
            $dataSave['category'] = $this->request->getVar('category'); // on la categorie
            $dataSave['datetime'] = date("Y-m-d H:i:s"); // on horodate 
            $dataSave['image_url'] = $this->request->getVar('image_url');
            //$dataSave['media_id_media'] = 0;
            $dataSave['status'] = $ispublished; // status de la publication
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
                
                if ($this->article_model->isExist($subject) == true) {
                    if (strlen($subject) > 0)
                        $data["warning"] = "Cet Article existe déjà!";
                } else {
                    // on sauve en premier le tag
                    
                    $data_tag["id_category"] = $dataSave['category'];
                    $id_tag = $this->tag_model->insert($data_tag);
                    $dataSave['id_tag'] = $id_tag;
                    // ensuite la table article
                    $id_article = $this->article_model->insert($dataSave);
                    $datatemp = [
                        'id_user' => session()->id_user,
                        'id_article' => $id_article,
                    ];
                    // en avant-dernier la table intermédiaire user_has_article
                    $this->user_has_article_model->save($datatemp);
                    // en dernier la table intermédiaire publication_has_article
                    if ($id_publish > 0) {
                        $datatemp2 = [
                            'id_publication' => $id_publish,
                            'id_article' => $id_article,
                        ];
                        $this->article_has_publication_model->save($datatemp2);
                    }
                    session()->setFlashdata('success', 'Article en cours de validation...');
                }
            }
        }
        return view('Articles/articles_edit.php', $data);
    }

    public function publishes_edit()
    {                
        $user = $this->user_model->getUserSession();        
        $categories = $this->category_model->getCategories();
        $articles = $this->article_model->getFilterArticles();

        $data = [
            "title" => "Création Publication",
            "subtitle" => "Création et mise en ligne de vos publications.",
            "user" => $user,
            "categories" => $categories,
            "articles" => $articles,
        ];

        if (isset($data['warning'])) {
            unset($data['warning']);
        }
        if (isset(session()->success)) {
            session()->remove('success');
        }

        if ($this->request->getMethod() == 'post') {
            $ispublished = ($this->request->getVar('publish') == true) ? EN_COURS : BROUILLON;

            switch (session()->type) {
                case ADMIN:
                case SUPER_ADMIN:
                    $ispublished = VALIDE;
                    break;
            }
            $dataSave['subject'] = $this->request->getVar('subject');
            $dataSave['description'] = $this->request->getVar('description');
            $dataSave['category'] = $this->request->getVar('category');
            $dataSave['datetime'] = date("Y-m-d H:i:s");
            $dataSave['article_id_article'] = 0;
            $dataSave['status'] = $ispublished;
            $subject =  $dataSave['subject'] . trim("");
            $dataSave['image_url'] = $this->request->getVar('image_url');
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
                
                if ($this->publication_model->isExist($dataSave['subject']) == true) {
                    if (strlen($subject) > 0) {
                        $data["warning"] = "Cette publication existe déjà!";
                    }
                } else {
                    // on sauve en premier le tag
                    
                    $data_tag["id_category"] = $dataSave['category'];
                    $id_tag = $this->tag_model->insert($data_tag);
                    $dataSave['id_tag'] = $id_tag;
                    // ensuite on enrichit la table publication    
                    $id_publication = $this->publication_model->insert($dataSave);
                    // en dernier on fait le lien entre article et publication
                    
                    $data_temp = [
                        'id_publication' => $id_publication,
                    ];
                    //
                    $list_articles = $this->request->getVar('list_articles');
                    if ($list_articles) {
                        foreach ($list_articles as $article) {
                            $data_temp['id_article'] = $article;
                            $this->article_has_publication_model->insert($data_temp);
                        }
                    }
                    //
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
            if ($article['image_url'] == null) {
                $article['image_url'] = base_url() . "/assets/article.svg";
            }
            $listarticles[] = [
                "id_article" => $article['id_article'],
                "subject" => $article['subject'],
                "description" => $article['description'],
                "datetime" => $article['datetime'],
                "image_url" => $article['image_url'],
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

    private function home_article_details($title, $id = 0)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('article');
        $builder->where('id_article', $id);
        $query   = $builder->get();
        $article = $query->getResultArray();
        $article = $article[0];

        $image_url = $article['image_url'];

        if ($image_url == null or $image_url === "") {
            $article['image_url'] = base_url() . "/assets/article.svg";
        }

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

        return $data;
    }

    public function get_details_article_home($id)
    {
        $title = "Détails de l'article";
        if ($id) {
            $data = $this->home_article_details($title, $id);
        }
        return view('Articles/list_article_details.php', $data);
    }

    public function details_article_home()
    {
        $title = "Détails de l'article";

        if ($this->request->getMethod() == 'post') {
            $id = $this->request->getVar('id_article');
            $data = $this->home_article_details($title, $id);
            return view('Articles/list_article_details.php', $data);
        }
    }

    public function list_publishes_home()
    {
        $title = "Liste des publications";
        $db      = \Config\Database::connect();
        $builder = $db->table('publication');

        $builder->where('status', '1');
        $query   = $builder->get();
        $publishes = $query->getResultArray();

        $listpublishes = [];

        foreach ($publishes as $publishe) {
            $image_url = $publishe['image_url'];

            if ($image_url == null or $image_url === "") {
                $publishe['image_url'] = base_url() . "/assets/publication.svg";
            }
            $listpublishes[] = [
                "id_publication" => $publishe['id_publication'],
                "subject" => $publishe['subject'],
                "description" => $publishe['description'],
                "datetime" => $publishe['datetime'],
                "image_url" => $publishe['image_url'],
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
            $publication = $publication[0];
            $image_url = $publication['image_url'];
            if ($image_url == null or $image_url === "") {
                $publication['image_url'] = base_url() . "/assets/publication.svg";
            }

            $builder->select('article.id_article,article.subject,article.description,article.datetime,article.image_url');
            $builder->where('publication.id_publication', $id);
            $builder->join('publication_has_article', 'publication_has_article.id_publication = publication.id_publication');
            $builder->join('article', 'publication_has_article.id_article = article.id_article');

            $query = $builder->get();
            $articles = $query->getResultArray();

            $listarticles = [];

            foreach ($articles as $article) {
                $image_url = $article['image_url'];
                if ($image_url == null or $image_url === "") {
                    $article['image_url'] = base_url() . "/assets/article.svg";
                }
                $listarticles[] = [
                    "id_article" => $article['id_article'],
                    "subject" => $article['subject'],
                    "description" => $article['description'],
                    "datetime" => $article['datetime'],
                    "image_url" => $article['image_url'],
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

    // suppression de l'article en fonction de son Id
    public function delete_article()
    {
        if ($this->request->getMethod() == 'post') {
            $id = $this->request->getVar('id_article');
            
            $this->article_model->deleteArticle($id);
        }
        return redirect()->to(previous_url());
    }

    // suppression de la publication en fonction de son Id
    public function delete_publish()
    {        
        if ($this->request->getMethod() == 'post') {
            $id = $this->request->getVar('id_publication');            
            $this->publication_model->deletePublishe($id);
        }
        return redirect()->to(previous_url());
    }
}
