<?php

namespace App\Controllers;
use App\Models\TagModel;
use App\Libraries\CategoryHelper;
use App\Libraries\UserHelper;
use App\Libraries\VideoHelper;
use App\Libraries\BookHelper;
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

    public function videos_edit()
    {
        $video = new MediaModel();
        //
        $user_helper = new UserHelper();
        $user = $user_helper->getUserSession();
        //
        $category_helper = new CategoryHelper();
        $categories = $category_helper->getCategories();

        $data = [
            "title" => "Poster une vidéo",
            "subtitle" => "Mise en ligne sur le site d'une vidéo.",
            "user" => $user,
            "categories" => $categories,
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
            $dataSave['type'] = 1;
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
                $video_helper = new VideoHelper();
                if ($video_helper->isExist($url) == true) {
                    if (strlen($url) > 0)
                        $data["warning"] = "Cette vidéo existe déjà!";
                } else {
                    // on sauve en premier le tag
                    $tag_model = new TagModel();
                    $data_tag["id_category"] = $dataSave['category'];
                    $id_tag = $tag_model->insert($data_tag);
                    $dataSave['id_tag'] = $id_tag;
                    // ensuite la table media
                    $id_media = $video->insert($dataSave);
                    $datatemp = [
                        'id_user' => session()->id_user,
                        'id_media' => $id_media,
                    ];
                    // en avant-dernier la table intermédiaire user_has_media
                    $user_has_media->save($datatemp);
                    session()->setFlashdata('success', 'Video en cours de validation...');
                }
            }
        }
        return view('Media/videos_edit.php', $data);
    }

    public function books_edit()
    {
        $book = new MediaModel();
        //
        $user_helper = new UserHelper();
        $user = $user_helper->getUserSession();
        //
        $category_helper = new CategoryHelper();
        $categories = $category_helper->getCategories();

        $data = [
            "title" => "Poster un livre",
            "subtitle" => "Mise en ligne sur le site d'une livre.",
            "user" => $user,
            "categories" => $categories,
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
            $dataSave['type'] = 2;
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
                $book_helper = new BookHelper();
                if ($book_helper->isExist($url) == true) {
                    if (strlen($url) > 0)
                        $data["warning"] = "Cette vidéo existe déjà!";
                } else {
                    // on sauve en premier le tag
                    $tag_model = new TagModel();
                    $data_tag["id_category"] = $dataSave['category'];
                    $id_tag = $tag_model->insert($data_tag);
                    $dataSave['id_tag'] = $id_tag;
                    // ensuite la table media
                    $id_media = $book->insert($dataSave);
                    $datatemp = [
                        'id_user' => session()->id_user,
                        'id_media' => $id_media,
                    ];
                    // en avant-dernier la table intermédiaire user_has_media
                    $user_has_media->save($datatemp);
                    session()->setFlashdata('success', 'Livre en cours de validation...');
                }
            }
        }
        return view('Media/books_edit.php', $data);
    }


    // Gestion des livres
    public function list_books_home()
    {
        $title = "Liste des livres";
        $db      = \Config\Database::connect();
        $builder = $db->table('media');
        $builder->where('status', '1');
        $builder->where('type', '2');
        $query   = $builder->get();
        $books = $query->getResultArray();
        $listbooks = [];

        foreach ($books as $book) {
            $listbooks[] = [
                "id_media" => $book['id_media'],
                "name" => $book['name'],
                "description" => $book['description'],
                "author" => $book['author'],
                "url" => $book['url'],
            ];
        }

        $data = [
            "title" => $title,
            "listbooks" => $listbooks,
        ];

        return view('/Media/list_books.php', $data);
    }

    // Gestion des vidéos
    public function list_videos_home()
    {
        $title = "Liste des vidéos";
        $db      = \Config\Database::connect();
        $builder = $db->table('media');
        $builder->where('status', '1');
        $builder->where('type', '1');
        $query   = $builder->get();
        $videos = $query->getResultArray();
        $listvideos = [];

        foreach ($videos as $video) {
            /*if ($video['url']==null){
                $video['url']=base_url()."/assets/video.svg";
            }*/
            $listvideos[] = [
                "id_media" => $video['id_media'],
                "name" => $video['name'],
                "description" => $video['description'],
                "author" => $video['author'],
                "url" => $video['url'],
            ];
        }

        $data = [
            "title" => $title,
            "listvideos" => $listvideos,
        ];
        return view('/Media/list_videos.php', $data);
    }
}
