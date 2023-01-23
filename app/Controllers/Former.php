<?php

namespace App\Controllers;



// Date 22-12-2022
class Former extends BaseController
{
    /**
     * list_former_home
     * 
     * Liste des formateurs page home
     * @return void
     */
    public function list_former_home()
    {
        $title = "Liste des formateurs";
        $public = $this->user_model->getFormers();
        $builder = $public["builder"];
        $formers = $public["formers"];
        $listformers = [];

        foreach ($formers as $former) {
            if ($former['image_url'] == null) {
                $former['image_url'] = base_url() . "/assets/Blank_nogender.svg";
            }
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
                "image_url" => $former['image_url'],
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
            "formers" => $listformers,
            "jobs" => $jobs,
        ];

        return view('Former/list_former.php', $data);
    }

    /**
     * details_former_home
     * 
     * Détails des formateurs
     * @return void
     */
    public function details_former_home()
    {

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
                "title" => "C.V. du formateur",
                "former" => $former,
                "skills" => $skills,
            ];
            return view('Former/list_former_cv.php', $data);
        }
    }

    /**
     * rdv
     * 
     * Planification des rdv
     * @return void
     */
    public function rdv()
    {
        $user = $this->user_model->getUserSession();
        $query = $this->rdv_model->where("id_user", $user['id_user'])->findAll();
        $events = [];

        $options = $this->category_model->getCategories();
        foreach ($query as $event) {
            $events[] = [
                "title" => "Infos",
                "dateStart" => $event['dateStart'],
                "dateEnd" =>  $event['dateEnd'],
            ];
        }
        $data = [
            "title" => "Planning des Rendez-vous",
            "id_user" => $user['id_user'],
            "events" => $events,
            "user" => $user,
            "options" => $options,
        ];
        return view('Former/rdv.php', $data);
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
        $options = $this->category_model->getCategories();

        $data = [
            "title" => "Création formation",
            "id_user" => $user['id_user'],
            "user" => $user,
            "options" => $options,
        ];

        if ($this->request->getMethod() == 'post') {

            $dateStart = $this->request->getVar('dateStart');
            $dateEnd = $this->request->getVar('dateEnd');
            $timeStart = $this->request->getVar('timeStart');
            $timeEnd = $this->request->getVar('timeEnd');
            $image_url = $this->request->getVar("image_url");

            if ($image_url == null) {
                $image_url = base_url() . "/assets/training.svg";
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
                    return view('Training/training_edit.php', $data);
                }
            }
        }
        return view('Training/training_add.php', $data);
    }

    /**
     * training_edit
     * Création des pages associées à la formation
     * @return void
     */
    public function training_edit()
    {

        $id_training = session()->get("id_training");
        $trainings = $this->training_model->fillOptionsTraining(session()->id_training);
        //
        $user = $this->user_model->getUserSession();
        //
        $categories = $this->category_model->getCategories();
        $id_page=0;
        //
        $types = [
            ["id" => 1, "name" => "Introduction"],
            ["id" => 2, "name" => "Chapitre"],
            ["id" => 3, "name" => "Conclusion"],
            ["id" => 4, "name" => "Annexe"],
        ];
        //
        $data = [
            "title" => "Création contenu de page",
            "id_user" => $user['id_user'],
            "user" => $user,
            "categories" => $categories,
            "types" => $types,
            "id_training" => $id_training,
            "trainings" => $trainings,
            "headerColor" => getTheme(session()->type, "header"),
            "id_page"=>$id_page,
            "title"=>"",
            "content"=>"",
        ];

        if ($this->request->getMethod() == 'post') {
            $this->request->getVar("");
            // on utilise les modèles pour renseigner nos tables de formation, pages ...
            //$this->training_model->save($dataSave);

            $action = $this->request->getVar('action');
            if ($action != null) {
                switch ($action) {
                    case "create":
                        break;
                    case "modify":
                        break;
                    case "delete":
                        break;
                    default:
                        break;
                }
            }
        }
        return view('Training/training_edit.php', $data);
    }

    /**
     * training_save
     * Sauvegarde des pages associées à la formation
     * @return void
     */
    public function training_save()
    {
        if ($this->isPost()) {
            $id_training = $this->request->getVar("id_training");

            $dataSave = [
                "id_page" => $this->request->getVar("id_page"),
                "id_training" => $this->request->getVar("id_training"),
                "title" => $this->request->getVar("title"),
                "content" => $this->request->getVar("content"),
                "image_url" => $this->request->getVar("image_url"),
            ];
            // insérer page dans la base de données
            $this->page_model->save($dataSave);

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

            $data = [
                'title'=>"Gestion des pages",
                'user' => $this->getUserSession(),
                "id_training" => $id_training,
                'pages' => $listPages,
                "buttonColor" => getTheme(session()->type, "button"),
                "headerColor" => getTheme(session()->type, "header"),
            ];
            return view('Admin/dashboard_page.php', $data);
        }
    }
}
