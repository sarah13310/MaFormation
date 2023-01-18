<?php

namespace App\Controllers;
use App\Models\TagModel;
use App\Libraries\CategoryHelper;
use App\Libraries\UserHelper;
use App\Libraries\MediaHelper;
use App\Models\UserHasMediaModel;
use App\Models\MediaModel;

class Media extends BaseController
{
    // Gestion des diapos
    public function slides()
    {
        $data=["title"=>"Diapos"      
        ];
        return view('/Media/slides.php', $data);
    }

    public function medias_edit($type)
    {

        switch ($type) {
            case VIDEO:
                $title = "Poster une vidéo";
                $subtitle="Mise en ligne sur le site d'une vidéo.";
                $existe="Cette vidéo existe déjà!";
                $validation='Vidéo en cours de validation...';
                $n="&nbsp;Nom de la vidéo (*)";
                $u="&nbsp;Url de la vidéo (*)";
                $ucm="&nbsp;Url de la miniature de la vidéo (*)";
                break;
            case BOOK:
                $title = "Poster un livre";
                $subtitle="Mise en ligne sur le site d'un livre.";
                $existe="Ce livre existe déjà!";
                $validation='Livre en cours de validation...';
                $n="&nbsp;Nom du livre (*)";
                $u="&nbsp;Url du livre (*)";
                $ucm="&nbsp;Url de la couverture du livre (*)";
                break;
        }

        $media = new MediaModel();
        $media_helper = new MediaHelper();
        $na="&nbsp;Nom de l'auteur";

        $user_helper = new UserHelper();
        $user = $user_helper->getUserSession();
        //
        $category_helper = new CategoryHelper();
        $categories = $category_helper->getCategories();

        $data = [
            "title" => $title,
            "subtitle" => $subtitle,
            "user" => $user,
            "categories" => $categories,
            "n" =>$n,
            "na" =>$na,
            "u" =>$u,
            "ucm" =>$ucm,
        ];

        if (isset($data['warning'])) {
            unset($data['warning']);
        }

        if (isset(session()->success)) {
            session()->remove('succes');
        }

        if ($this->request->getMethod() == 'post') {

            
            $user_has_media = new UserHasMediaModel();

            $ispublished = ($this->request->getVar('publish') == true) ? EN_COURS : BROUILLON;
            $dataSave['name'] = $this->request->getVar('name');
            $dataSave['description'] = $this->request->getVar('description');
            $dataSave['author'] = $this->request->getVar('author');
            $dataSave['category'] = $this->request->getVar('category'); // on la categorise
            $dataSave['url'] = $this->request->getVar('url'); 
            $dataSave['image_url'] = $this->request->getVar('image_url'); 
            $dataSave['type'] = $type;
            $dataSave['status'] = $ispublished; // status de la publication
            $url =  $dataSave['url'];

            $rules = [
                'name' => 'required|min_length[6]|max_length[30]',
                'url' => 'required|min_length[6]|max_length[255]',
            ];
            $error = [
                'name' => [
                    'required' => "Nom vide!",
                    'min_length' => "Nom trop court",
                    'max_length' => "Nom trop long",
                ],
                'url' => [
                    'required' => "Url vide!",
                    'min_length' => "Url trop courte",
                    'max_length' => "Url trop longue",
                ],
            ];

            if (!$this->validate($rules, $error)) {
                $data['validation'] = $this->validator;
            } else {
                if ($media_helper->isExist($url) == true) {
                    if (strlen($url) > 0)
                        $data["warning"] = $existe;
                } else {
                    // on sauve en premier le tag
                    $tag_model = new TagModel();
                    $data_tag["id_category"] = $dataSave['category'];
                    $id_tag = $tag_model->insert($data_tag);
                    $dataSave['id_tag'] = $id_tag;
                    // ensuite la table media
                    $id_media = $media->insert($dataSave);
                    $datatemp = [
                        'id_user' => session()->id_user,
                        'id_media' => $id_media,
                    ];
                    // en avant-dernier la table intermédiaire user_has_media
                    $user_has_media->save($datatemp);
                    session()->setFlashdata('success', $validation);
                }
            }
        }
        return view('Media/medias_edit.php', $data);
    }

    public function list_media_home($type)
    {

        $media_helper = new MediaHelper();

        switch ($type) {
            case VIDEO:
                $title = "Liste des vidéos";
                $p="Fait par";
                $b="Regarder la vidéo";
                break;
            case BOOK:
                $title = "Liste des livres";
                $p="Ecrit par";
                $b="Acheter le livre";
                break;
        }

        $medias = $media_helper->ValidatedMedias($type);

        $listmedias = [];

        $listmedias = $media_helper->returnDataMedias($listmedias,$medias);

        $data = [
            "title" => $title,
            "listmedias" => $listmedias,
            "p" => $p,
            "b" => $b,
        ];
        return view('/Media/list_medias.php', $data);
    }

}
