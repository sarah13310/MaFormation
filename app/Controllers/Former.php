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

        $listformers = $this->user_model->MapFormer($listformers, $formers);

        /* compétences certificats*/

        $listformers = $this->user_model->getAllFormerCertificate($listformers, $builder);

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

        $listformers = $this->tag_model->getTagName($listformers);

        $tag = $this->tag_model->FilterTag($listformers);

        $former = $this->tag_model->FilterFormer($listformers);

        $former_json = json_encode($listformers);
        file_put_contents("former.json", $former_json);


        $data = [
            "title" => $title,
            "formers" => $listformers,
            "jobs" => $jobs,
            "tag" => $tag,
            "former" => $former,
            "former_json" => base_url() . "/former.json",
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
