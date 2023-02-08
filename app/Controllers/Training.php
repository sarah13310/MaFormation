<?php

namespace App\Controllers;

// Le 12/01/2023
// Le 20/01/2023 modification avec helper

class Training extends BaseController
{
    /**
     * __construct
     * Constructeur
     * @return void
     */
    public function __construct()
    {
       helper(['util']); // déclaration des fonctions helper
    }

    /**
     * list
     * liste des formations (profil utilisateur)
     * @return void
     */
    public function list()
    {
        $user = $this->getUserSession();
        $trainings = $this->training_model->getFilterTrainings();
        $list_training = [];

        foreach ($trainings as $training) {
            $list_training[] = [
                "id_training" => $training['id_training'],
                "title" => $training['title'],
                "date" => dateTimeFormat($training['date']),
                "description" => textEllipsis($training['description'], 20),
            ];
        }
        $data = [
            "title" => "Liste des formations",
            "trainings" => $list_training,
            "user" => $user,
            "theme_button" => getTheme($user['type'], "button"),
            "headerColor" => getTheme($user['type'], "header"),
        ];
        return view('Training/training_list.php', $data);
    }
    /**
     * list
     * liste des formations (page Home)
     * @return void
     */
    public function home()
    {
        helper(['util']);
        $trainings = $this->training_model->getFilterTrainings();
        $list_training = [];

        foreach ($trainings as $training) {
            if ($training['image_url'] == null) {
                $training['image_url'] = constant('DEFAULT_IMG_TRAINING');
            }
            $list_training[] = [
                "id_training" => $training['id_training'],
                "title" => $training['title'],
                "date" => dateTimeFormat($training['date']),
                "description" => textEllipsis($training['description'], 30),
                //"full_description" => $training['description'],
                "image_url" => $training['image_url'],
            ];
        }
        $data = [
            "title" => "Liste des formations",
            "trainings" => $list_training,
            "buttonColor" => getTheme(session()->type, "button"),
            "headerColor" => getTheme(session()->type, "header"),
        ];
        return view('Training/training_list_home.php', $data);
    }

    public function details($id = 0)
    {
        if ($this->isPost()) {
            $id = $this->request->getVar('id_training');
        }

        $training = $this->training_model->getTrainingById($id);
        $training = $training[0];

        $image_url = $training['image_url'];
        if ($image_url == null) {
            $training['image_url'] = constant('DEFAULT_IMG_TRAINING');
        }

        $data = [
            "title" => "Détail de la formation",
            "id" => $id,
            "training" => $training,
            "date" => dateTimeFormat($training['date']),
        ];
        return view('Training/training_details.php', $data);
    }


    /**
     * payment
     * 
     * @return void
     */
    public function payment()
    {

        if ($this->isPost()) {
            $id = $this->request->getVar('id_training');
            $training = $this->training_model->getTrainingById($id);
            $training = $training[0];

            $data = [
                "title" => $training['title'],
            ];
        }
        return view('Payment/paymentcard.php', $data);
    }


    /**
     * training
     * Tableau des formations (dashboard)
     * @return void
     */
    public function dashboard_training()
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
                "date" => dateTimeFormat($training['date']),
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


    public function view()
    {
        // on récupère les informations utilisateur de la session active    
        $user = $this->getUserSession();

        if ($this->isPost()) {
            $id = $this->request->getVar('id_training');
            $training = $this->training_model->getTrainingById($id);

            if ($training) {
                $training = $training[0];
                $pages = $this->page_model->getPages($training['id_training']);
                $list_description = [];
                $list_images = [];

                foreach ($pages as $page) {
                    $list_description[] = $page['content'];
                    if ($page['image_url'] == null) {
                        $page['image_url'] = base_url() . "/assets/chapter.svg";
                    }
                    $list_images[] = $page['image_url'];
                }
                $descriptions = json_encode($list_description);
                $images = json_encode($list_images);

                $data = [
                    "title" => $training['title'],
                    "training" => $training,
                    "date" => dateTimeFormat($training['date']),
                    "count" => count($pages),
                    "pages" => $pages,
                    "descriptions" => $descriptions,
                    "images" => $images,
                    "user" => $user,
                    "theme_button" => getTheme($user['type'], "button"),
                ];
                return view('Training/training_view.php', $data);
            } else {
                return view('errors/html/error_404.php');
            }
        }
    }


    /**
     * add_page
     * Ajoute une nouvelle page
     * @return void
     */
    public function add_page()
    {
        // on récupère les informations utilisateur de la session active    
        $user = $this->getUserSession();
        //
        if ($this->isPost()) {

            $id_training = $this->request->getVar('id_training');
            $title_page = $this->request->getVar('title_page');
            $title_training = $this->request->getVar('title');
            $content = $this->request->getVar('content');
            $image_url = $this->request->getVar('image_url');

            $dataNew = [

                'id_training' => $id_training,
                'title' => $title_page,
                'content' => $content,
                'image_url' => $image_url,
            ];

            $id_page = $this->page_model->insert($dataNew);
            $dataHas = [
                'id_training' => $id_training,
                'id_page' => $id_page,
            ];
            $this->training_has_page_model->save($dataHas);

            $title = "Gestion des pages";
            $pages = $this->training_model->getFilterPages($id_training);
            $data = [
                "title" => $title,
                "title_training" => $title_training,
                "user" => $user,
                "buttonColor" => getTheme($user['type'], "button"),
                "headerColor" => getTheme($user['type'], "header"),
                "pages" => $pages,
                "id_training" => $id_training,
                "modalDelete" => modalDelete(),
            ];
            return view('Admin/dashboard_page.php', $data);
        } else {
            $trainings = $this->training_model->getFilterTrainings();
            $categories = $this->category_model->getCategories();
            $title = "Création de la page";
            $data = [
                "title" => $title,
                "id_training" => session()->id_training,
                "title_training" => session()->title_training,
                "user" => $user,
                "buttonColor" => getTheme($user['type'], "button"),
                "headerColor" => getTheme($user['type'], "header"),
                "modalDelete" => modalDelete(),
                "id_page" => 0,
                "trainings" => $trainings,
                "categories" => $categories,
                "page_title" => "",
                "content" => "",
                "action" => "add",
            ];
            return view('Training/page_modify.php', $data);
        }
    }

    /**
     * modify_page
     * Affiche les données une page à modifier
     * @return void
     */
    public function modify_page()
    {
        // on récupère les informations utilisateur de la session active    
        $user = $this->getUserSession();
        //        
        if ($this->isPost()) {
            $id_page = $this->request->getVar('id_page');
            $id_training = $this->request->getVar('id_training');
            $title_training = $this->request->getVar('title');
            $content = $this->request->getVar('content');
            $image_url = $this->request->getVar('image_url');
            $title_page = $this->request->getVar('title_page');
            if ($title_page == null)
                $title_page = "";

            //
            // on recupère la page par l'id dans la table            
            $page=$this->page_model->getPageById($id_page);
            $page=$page[0];
            if (!$content){
                $content=$page['content'];
            }
            /*if ($page) {
                $page = $page[0]; // on prend juste la page désirée
                $title_page = $page['title'];
                $content = $page['content'];
                $image_url = $page['image_url'];
            }*/
            $categories = $this->category_model->getCategories();
            // on prépare les données pour la page html
            $training = $this->training_model->getTrainingById($id_training);
            $trainings = $this->training_model->getTrainingsTitle();
            $title = "Modification de la page";
            //
            $data = [
                "title" => $title,
                "page_title" => $title_page,
                "title_training" => $title_training,
                "user" => $user,
                "buttonColor" => getTheme($user['type'], "button"),
                "headerColor" => getTheme($user['type'], "header"),
                // "training" => $training[0],
                "id_training" => $id_training,
                "categories" => $categories,
                "id_page" => $id_page,
                "content" => $content,
                "image_url" => $image_url,
                "trainings" => $trainings,
                "modalDelete" => modalDelete(),
                "action" => "",
            ];
            return view('Training/page_modify.php', $data);
        }
    }

    public function save_page()
    {
        // on récupère les informations utilisateur de la session active    
        $user = $this->getUserSession();
        //
        if ($this->isPost()) {
            $id_page = $this->request->getVar('id_page');
            $id_training = $this->request->getVar('id_training');
            $title_training = $this->request->getVar('title');
            $content = $this->request->getVar('content');
            $image_url = $this->request->getVar('image_url');
            $title_page = $this->request->getVar('title_page');
            //
            $dataSave = [
                'id_page' => $id_page,
                'title' => $title_page,
                'id_training' => $id_training,
                'content' => $content,
                'image_url' => $image_url,
            ];
            // on modifie la page dans la table            
            $this->page_model->save($dataSave);
            // on refait la liste des pages
            $pages = $this->training_model->getFilterPages($id_training);
            $title = "Gestion des pages";
            //
            $data = [
                "title" => $title,
                "title_training" => $title_training,
                "user" => $user,
                "buttonColor" => getTheme($user['type'], "button"),
                "headerColor" => getTheme($user['type'], "header"),
                "pages" => $pages,
                "modalDelete" => modalDelete(),
                "action" => "",
            ];
            return view('Admin/dashboard_page.php', $data);
        }
    }

    /**
     * delete_page
     * Supprime une page
     * @return void
     */
    public function delete_page()
    {
        // on récupère les informations utilisateur de la session active    
        $user = $this->getUserSession();
        //
        if ($this->isPost()) {
            $id_page = $this->request->getVar('id');
            $id_training = $this->request->getVar('id2');
            //
            $deleteData = ['id_page' => $id_page];
            // on supprime la catégorie dans la table            
            $this->page_model->delete($deleteData);
            $deleteHasData = [
                'id_training' => $id_training,
                'id_page' => $id_page,
            ];
            $this->training_has_page_model->remove($deleteHasData);
            // on informe visuelement de la suppression     
            session()->setFlashdata('success', 'Page supprimée!');
            // on prépare les données pour la page html
            $pages = $this->training_model->getFilterPages($id_training);
            $data = [
                "title" => "Gestion des pages",
                "user" => $user,
                "buttonColor" => getTheme($user['type'], "button"),
                "headerColor" => getTheme($user['type'], "header"),
                "pages" => $pages,
                "id_training" => $id_training,
                "modalDelete" => modalDelete(),
            ];
            return view('Admin/dashboard_page.php', $data);
        }
    }

    /**
     * training_add
     * Création nouvelle formation
     * 
     * @return void
     */
    public function training_add()
    {
        $user = $this->user_model->getUserSession();
        $categories = $this->category_model->getCategories();

        $data = [
            "title" => "Création formation",
            "id_user" => $user['id_user'],
            "user" => $user,
            "categories" => $categories,
            'title_training' => "0",
            'id_page' => "0",
            'id_training' => "0",
            'content' => "",
            'buttonColor' => getTheme(session()->type, "button"),
        ];

        if ($this->isPost()) {

            $dateStart = $this->request->getVar('dateStart');
            $dateEnd = $this->request->getVar('dateEnd');
            $timeStart = $this->request->getVar('timeStart');
            $timeEnd = $this->request->getVar('timeEnd');
            $image_url = $this->request->getVar("image_url");

            if ($image_url == null) {
                $image_url = constant('DEFAULT_IMG_TRAINING');
            }
            if (!str_contains($image_url, base_url())) {
                $image_url = base_url() . "/assets//" . $image_url;
            }

            $dateTimeStart = date('Y-m-d H:i:s', strtotime($dateStart . ' ' . $timeStart));
            $dateTimeEnd = date('Y-m-d H:i:s', strtotime($dateEnd . ' ' . $timeEnd));
            $title = $this->request->getVar('title');
            $data_save = [
                "title" => $title,
                "description" => $this->request->getVar('description'),
                "date" => $dateTimeStart,
                "duration" => $dateTimeEnd,
                "rating" => 0,
                "id_bill" => 0,
                "id_type_slide" => 0,
                "status" => 0,
                "id_tag" => 0,
                "image_url" => $image_url,
            ];
            $types = [
                ["id" => 1, "name" => "Introduction"],
                ["id" => 2, "name" => "Chapitre"],
                ["id" => 3, "name" => "Conclusion"],
                ["id" => 4, "name" => "Annexe"],
            ];
            $data['types'] = $types;

            $rules = [
                'title' => 'required|min_length[3]|max_length[40]',
            ];
            $error = [
                'title' => [
                    'required' => "Titre vide!",
                    'min_length' => "Titre trop court",
                    'max_length' => "Titre trop long",
                ],
            ];

            if (!$this->validate($rules, $error)) {
                $data['validation'] = $this->validator;
            } else {
                if ($this->training_model->isExist($title) === true) {
                    // la formation existe déjà avec ce titre
                    // alors on doit avertir le formateur
                    $session_add = [
                        "description" => $this->request->getVar('description'),
                        "dateStart" => $dateStart,
                        "dateEnd" => $dateEnd,
                        "timeStart" => $timeStart,
                        "timeEnd" => $timeEnd,
                    ];
                    $data["warning"] = "true";
                    session()->set($session_add);
                    return view('Training/training_add.php', $data);
                } else {
                    $last_id = $this->training_model->add($data_save);
                    $this->training_model->setTrainingSession($data_save);

                    $trainings = $this->training_model->fillOptionsTraining($last_id);
                    session()->set("id_training", $last_id);

                    $data["trainings"] = $trainings;
                    $data['title'] = "Création contenu";
                    $data['title_training'] = session()->title_training;

                    return view('Training/page_modify.php', $data);
                }
            }
        }
        return view('Training/training_add.php', $data);
    }

    /**
     * training_save
     * Sauvegarde des pages associées à la formation
     * @return void
     */
    public function training_save()
    {
        $id_training = session()->id_training;

        if ($this->isPost()) {
            $action = $this->request->getVar("action");
            $dataSave = [
                "id_page" => $this->request->getVar("id_page"),
                "id_training" => $id_training,
                "title" => $this->request->getVar("page_title"),
                "content" => $this->request->getVar("content"),
                "image_url" => $this->request->getVar("image_url"),
            ];
            // insérer page dans la base de données
            $last_id = $this->page_model->save($dataSave);

            // table intermédiaire training_has_page
            $dataInt = [
                "id_training" => $id_training,
                "id_page" => $last_id,
            ];
            $this->training_has_page_model->save($dataInt);
            $pages = $this->training_model->getFilterPages($id_training);

            $data = [
                'title' => "Gestion des pages",
                'user' => $this->getUserSession(),
                "id_training" => $id_training,
                'pages' => $pages,
                "buttonColor" => getTheme(session()->type, "button"),
                "headerColor" => getTheme(session()->type, "header"),
            ];
            return view('Admin/dashboard_page.php', $data);
        }
    }
    /**
     * delete_training
     * Supprime une formation 
     * @return void
     */
    public function delete_training()
    {
        $title = "Tableau des formations";
        // on récupère les informations utilisateur de la session active    
        $user = $this->getUserSession();

        if ($this->isPost()) {
            $id_training = $this->request->getVar('id_training');
            $this->training_model->deleteTraining($id_training);
        }
        /* on rafaichit la liste des formations */
        $trainings = $this->training_model->getFilterTrainings();
        /** on mappe la liste */
        $listraining = [];
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
        /** on prépare les données pour la page html */
        $data = [
            "title" => $title,
            "trainings" => $listraining,
            "user" => $user,
            "buttonColor" => getTheme(session()->type, "button"),
            "headerColor" => getTheme(session()->type, "header"),
        ];
        return view('Admin/dashboard_training_admin.php', $data);
    }

    
}
