<?php

namespace App\Controllers;

// le 20/01/2023
// le 05/02/2023
class News extends BaseController
{
    
    /**
     * articles_edit
     * Edition de l'article
     * @return void
     */
    public function articles_edit()
    {
        //        
        $user = $this->user_model->getUserSession();
        //        
        $categories = $this->category_model->getCategories();
        //        
        $publishes = $this->publication_model->getFilterPublishes(ALL);

        $publishes = $this->publication_model->getPublishesbyAuthor($user['id_user']);

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

        if ($this->isPost()) {

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
    
    /**
     * publishes_edit
     * Edition de la publication
     * @return void
     */
    public function publishes_edit()
    {
        $user = $this->user_model->getUserSession();
        //
        $categories = $this->category_model->getCategories();
        //
        $articles = $this->article_model->getFilterArticles();
        //
        $articles = $this->article_model->getArticlesbyAuthor(0, $user['id_user']);

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

        if ($this->isPost()) {
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
    
    /**
     * list_articles_home
     * Menu Articles => affiche de tous les articles validés
     * @return void
     */
    public function list_articles_home()
    {
        $title = "Liste des articles";

        $public = $this->article_model->getArticles();

        $builder = $public['builder'];

        $articles = $this->article_model->getFilterArticles(VALIDE);

        $listarticles = [];

        $listarticles = $this->article_model->returnDataArticles($listarticles, $articles);

        $listarticles = $this->article_model->getAuthorsArticles($listarticles, $builder);

        $data = [
            "title" => $title,
            "listarticles" => $listarticles,
        ];
        return view('Articles/list_article.php', $data);
    }
        
    /**
     * home_article_details
     * fonction commune pour articles validés
     * @param  mixed $title
     * @param  mixed $id
     * @return array
     */
    private function home_article_details($title, $id = 0)
    {

        $public = $this->article_model->getArticlesbyId($id);

        $builder = $public['builder'];

        $article = $public['article'];

        $image_url = $article['image_url'];

        if ($image_url == null or $image_url === "") {
            $article['image_url'] = constant('DEFAULT_IMG_ARTICLES');
        }

        $author = $this->article_model->getAuthorArticles($builder, $id);

        $data = [
            "title" => $title,
            "article" => $article,
            "author" => $author,
        ];

        return $data;
    }
        
    /**
     * get_details_article_home
     * Carousel des articles validés (page home)
     * @param  mixed $id
     * @return array
     */
    public function get_details_article_home($id)
    {
        $title = "Détails de l'article";
        if ($id) {
            $data = $this->home_article_details($title, $id);
        }
        return view('Articles/list_article_details.php', $data);
    }
    
    /**
     * details_article_home
     * Détail de la liste article (page home)
     * @return array
     */
    public function details_article_home()
    {
        $title = "Détails de l'article";

        if ($this->isPost() ) {
            $id = $this->request->getVar('id_article');
            $data = $this->home_article_details($title, $id);            
            return view('Articles/list_article_details.php', $data);
        }
    }
    
    /**
     * list_publishes_home
     * Menu publication =>La liste des publication 
     * @return void
     */
    public function list_publishes_home()
    {
        $title = "Liste des publications";

        $public = $this->publication_model->getPublishes();

        $publishes = $this->publication_model->getFilterPublishes(VALIDE);

        $listpublishes = [];

        $listpublishes = $this->publication_model->returnDataPublishes($listpublishes, $publishes);

        $listpublishes = $this->publication_model->getAuthorsPublishes($listpublishes);

        $data = [
            "title" => $title,
            "listpublishes" => $listpublishes,
        ];

        return view('Publishes/list_publishes.php', $data);
    }
    
    /**
     * details_publishes_home
     * Détails des publications
     * @return void
     */
    public function details_publishes_home()
    {
        $title = "Détails de la publication";

        if ($this->isPost() ) {

            $id = $this->request->getVar('id_publication');

            $publication = $this->publication_model->getPublisheById($id);

            $image_url = $publication['image_url'];
            if ($image_url == null or $image_url === "") {
                $publication['image_url'] = base_url() . "/assets/publication.svg";
            }

            $articles =  $this->publication_model->getFilterArticles($id);

            $listarticles = [];

            $listarticles= $this->article_model->returnDataArticles($listarticles,$articles);

            $id_user = $publication['id_user'];

            $author = $this->publication_model->getAuthorPublishes($id_user);

            $data = [
                "title" => $title,
                "publication" => $publication,
                "listarticles" => $listarticles,
                "author" => $author,
            ];

            return view('Publishes/list_publishes_details.php', $data);
        }
    }
    
    /**
     * delete_article
     * suppression de l'article en fonction de son Id 
     * @return void
     */
    public function delete_article()
    {
        if ($this->isPost() ) {
            $id = $this->request->getVar('id_article');

            $this->article_model->deleteArticle($id);
        }
        return redirect()->to(previous_url());
    }
     
    /**
     * delete_publish
     * suppression de la publication en fonction de son Id    
     * @return void
     */
    public function delete_publish()
    {
        if ($this->isPost() ) {
            $id = $this->request->getVar('id_publication');
            $this->publication_model->deletePublishe($id);
        }
        return redirect()->to(previous_url());
    }

}
