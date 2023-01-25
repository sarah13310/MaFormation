<?php

namespace App\Controllers;

class Search extends BaseController
{

    public function resultdata()
    {
        helper(['form']);

        if ($this->request->getMethod() == 'post') {

            $research = $this->request->getVar('research');
            $db = \Config\Database::connect();
            $builder = $db->table('media');
            $builder->like('name', $research);
            $builder->orLike('author', $research);
            $builder->where('status', VALIDE);
            $query   = $builder->get();
            $medias = $query->getResultArray();

            $listmedias = [];
            foreach ($medias as $media) {
                $listmedias[] = [
                    "id_media" => $media['id_media'],
                    "name" => $media['name'],
                    "author" => $media['author'],
                    "url" => $media['url'],
                    "image_url" => $media['image_url'],
                ];
            }

            $builder = $db->table('user');
            $builder->where('type', FORMER);
            $builder->where('status', VALIDE);
            $builder->like('name', $research);
            $builder->like('firstname', $research); 
            $query   = $builder->get();
            $formers = $query->getResultArray();

            $listformers = [];
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

            $listarticles = [];
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

            $listpublications = [];
            foreach ($publications as $publication) {
                $listpublications[] = [
                    "id_publication" => $publication['id_publication'],
                    "subject" => $publication['subject'],
                    "image_url" => $publication['image_url'],
                ];
            }
        }

        $data = [
            "title" => "Résultat",
            "listmedias" => $listmedias,
            "listformers" => $listformers,
            "listarticles" => $listarticles,
            "listpublications" => $listpublications, 
        ];

        return view('Home/result.php', $data);
    }
}
