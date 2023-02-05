<?php

namespace App\Controllers;

// Date 22-12-2022
// le 05-02-2023
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
        if ($this->isPost()) {

            $id = $this->request->getVar('id_user');         
            $user= $this->user_model->getUserById($id);
            $certificates=$this->user_model->getCertificates($id);
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
                "former" => $user,
                "skills" => $skills,
            ];
            return view('Former/list_former_cv.php', $data);
        }
    }

    /**
     * rdv
     * 
     * Création Modification des rdv
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
     * page_modify
     * Création des pages associées à la formation
     * @return void
     */
    public function page_modify()
    {
        $id_training = session()->id_training;
        //
        $trainings = $this->training_model->getTrainingsTitle();
        //
        $user = $this->user_model->getUserSession();
        //
        $categories = $this->category_model->getCategories();
        $id_page = 0;
        //        
        $data = [
            "title" => "Création contenu de page",
            "id_user" => $user['id_user'],
            "user" => $user,
            "categories" => $categories,
            "id_training" => $id_training,
            "trainings" => $trainings,
            "headerColor" => getTheme(session()->type, "header"),
            "buttonColor" => getTheme(session()->type, "button"),
            "id_page" => $id_page,
            "content" => "",
            "page_title"=>"",
            "modalDelete" => modalDelete(),
            "action"=>"",
        ];

        if ($this->isPost()) {
            //
            $title_training = $this->request->getVar("title");
            // on utilise les modèles pour renseigner nos tables de formation, pages ...  
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
        return view('Training/page_modify.php', $data);
    }

    
}
