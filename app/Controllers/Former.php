<?php

namespace App\Controllers;

use App\Models\RdvModel;
use App\Models\TrainingModel;
use App\Models\TrainingHasPageModel;
use App\Models\PageModel;

use App\Libraries\UserHelper;
use App\Libraries\FormerHelper;
use App\Libraries\CategoryHelper;
// Date 19-12-2022
class Former extends BaseController
{
    public function list_formers_home()
    {
        $title = "Liste des formateurs";
        $helper = new FormerHelper();
        $public = $helper->getFormers();
        $builder = $public["builder"];
        $formers = $public["formers"];
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

        return view('Former/list_former.php', $data);
    }


    public function details_former_home()
    {
        $title = "Cv du formateur";

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
                "title" => $title,
                "former" => $former,
                "skills" => $skills,
            ];
            return view('Former/list_former_cv.php', $data);
        }
    }

    public function rdv()
    {
        $user_info = new UserHelper();
        $user = $user_info->getUserSession();
        $rdv = new RdvModel();
        $query = $rdv->where("id_user", $user['id_user'])->findAll();
        $events = [];

        $category_infos = new CategoryHelper();
        $options = $category_infos->getCategories();
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

    public function training_edit()
    {
        $user_info = new UserHelper();
        $user = $user_info->getUserSession();

        $category_infos = new CategoryHelper();
        $options = $category_infos->getCategories();

        $types = [
            ["id" => 1, "name" => "Introduction"],
            ["id" => 2, "name" => "Chapitre"],
            ["id" => 3, "name" => "Conclusion"],
            ["id" => 4, "name" => "Annexe"],
        ];
        $data = [
            "title" => "Création formation",
            "id_user" => $user['id_user'],
            "user" => $user,
            "options" => $options,
            "types" => $types,
        ];

        if ($this->request->getMethod() == 'post') {
            // on utilise les modèles pour renseigner nos tables de formation, pages ...
            $training_model = new TrainingModel();
            $page_model = new PageModel();
            $training_has_model = new TrainingHasPageModel();
            $action = $this->request->getVar('action');
            if ($action != null) {
                switch ($action) {
                    case "create":
                        break;
                    case "modify":
                        break;
                    default:
                        break;
                }
            }
        }

        return view('Training/training_edit.php', $data);
    }
}
