<?php

namespace App\Controllers;

class Search extends BaseController
{
    public function resultdata()
    {

        $titlevideos = "";
        $titlebooks = "";
        $titleformers = "";
        $titlearticles = "";
        $titlepublications = "";
        $titletrainings = "";
        $listvideos = [];
        $listbooks = [];
        $listformers = [];
        $listarticles = [];
        $listpublications = [];
        $listtrainings = [];

        helper(['form', 'url', 'help']);

        if ($this->isGet()) {

            $research = $this->request->getVar('research');
            if ($research == "") {
                $listvideos = [];
                $listbooks = [];
                $listformers = [];
                $listarticles = [];
                $listpublications = [];
                $listtrainings = [];
                $title = "Aucun Résultat Trouvé";
            } else {

                $db = \Config\Database::connect();

                $builder = $db->table('media');
                $builder->where('status', VALIDE);
                $builder->where('type', VIDEO);
                $builder->like('name', $research);
                $builder->orLike('author', $research);

                $query   = $builder->get();
                $videos = $query->getResultArray();

                $listvideos = [];
                foreach ($videos as $video) {
                    if ($video['image_url'] == null) {
                        $video['image_url'] = constant('DEFAULT_IMG_VIDEO');
                    }
                    $listvideos[] = [
                        "id_media" => $video['id_media'],
                        "name" => $video['name'],
                        "author" => $video['author'],
                        "url" => $video['url'],
                        "image_url" => $video['image_url'],
                    ];
                }

                $builder = $db->table('media');
                $builder->where('status', VALIDE);
                $builder->where('type', BOOK);
                $builder->like('name', $research);
                $builder->orLike('author', $research);
                $query   = $builder->get();
                $books = $query->getResultArray();

                $listbooks = [];
                foreach ($books as $book) {
                    if ($book['image_url'] == null) {
                        $book['image_url'] = constant('DEFAULT_IMG_VIDEO');
                    }
                    $listbooks[] = [
                        "id_media" => $book['id_media'],
                        "name" => $book['name'],
                        "author" => $book['author'],
                        "url" => $book['url'],
                        "image_url" => $book['image_url'],
                    ];
                }

                $builder = $db->table('user');
                $builder->where('type', FORMER);
                $builder->where('status', VALIDE);
                $builder->like('name', $research);
                $builder->like('firstname', $research);
                $query   = $builder->get();
                $formers = $query->getResultArray();

                foreach ($formers as $former) {
                    $listformers[] = [
                        "id_user" => $former['id_user'],
                        "name" => $former['name'],
                        "firstname" => $former['firstname'],
                        "mail" => $former['mail'],
                        "image_url" => $former['image_url'],
                    ];
                }

                $builder = $db->table('article');
                $builder->like('subject', $research);
                $builder->where('status', VALIDE);
                $query   = $builder->get();
                $articles = $query->getResultArray();

                foreach ($articles as $article) {
                    $listarticles[] = [
                        "id_article" => $article['id_article'],
                        "subject" => $article['subject'],
                        "image_url" => $article['image_url'],
                    ];
                }

                $builder = $db->table('publication');
                $builder->like('subject', $research);
                $builder->where('status', VALIDE);
                $query   = $builder->get();
                $publications = $query->getResultArray();

                foreach ($publications as $publication) {
                    $listpublications[] = [
                        "id_publication" => $publication['id_publication'],
                        "subject" => $publication['subject'],
                        "image_url" => $publication['image_url'],
                    ];
                }
                $builder = $db->table('training');
                $builder->like('title', $research);
                $builder->where('status', VALIDE);
                $query   = $builder->get();
                $trainings = $query->getResultArray();

                $listtrainings = [];
                foreach ($trainings as $training) {
                    $listtrainings[] = [
                        "id_training" => $training['id_training'],
                        "title" => $training['title'],
                        "image_url" => $training['image_url'],
                    ];
                }

                $nb = count($listtrainings) + count($listpublications) + count($listarticles) + count($listformers) + count($listvideos) + count($listbooks);
                $title = "Résultat(s) : " . $nb;
                if (count($listtrainings)) {
                    $titletrainings = "Formations";
                }
                if (count($listpublications)) {
                    $titlepublications = "Publications";
                }
                if (count($listarticles)) {
                    $titlearticles = "Articles";
                }
                if (count($listformers)) {
                    $titleformers = "Formateurs";
                }
                if (count($listvideos)) {
                    $titlevideos = "Vidéos";
                }
                if (count($listbooks)) {
                    $titlebooks = "Livres";
                }
            }
        }

        $data = [
            "title" => $title,
            "listvideos" => $listvideos,
            "listbooks" => $listbooks,
            "listformers" => $listformers,
            "listarticles" => $listarticles,
            "listpublications" => $listpublications,
            "listtrainings" => $listtrainings,
            "titlevideos" => $titlevideos,
            "titlebooks" => $titlebooks,
            "titleformers" => $titleformers,
            "titlearticles" => $titlearticles,
            "titlepublications" => $titlepublications,
            "titletrainings" => $titletrainings,
        ];

        return view('Home/result.php', $data);
    }
}
