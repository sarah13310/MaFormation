<?php

namespace App\Controllers;


use App\Libraries\CarouselHelper;


// Le 10/01/2023
class Home extends BaseController
{
    public function index()
    {
        helper(['form']);

        
       
        try {
            $db      = \Config\Database::connect();
            $builder = $db->table('article');

            $builder->where('status', '1');
            $builder->orderBy('datetime', 'DESC');
            $builder->limit(6);
            $query   = $builder->get();
            $articles = $query->getResultArray();

        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $ex) {
            session()->setFlashdata('infos', 'Connexion impossible!');
            return view("/errors/html/error_connexion.php");
        }

        $listarticles = [];

        foreach ($articles as $article) {
            $listarticles[] = [
                "id_article" => $article['id_article'],
                "subject" => $article['subject'],
                "description" => $article['description'],
                "datetime" => $article['datetime'],
            ];
        }

        /* auteur de l'article*/
        $builder->select('user.name,user.firstname');

        for ($i = 0; $i < count($listarticles); $i++) {
            $builder->where('article.id_article', $listarticles[$i]['id_article']);
            $builder->join('user_has_article', 'user_has_article.id_article = article.id_article');
            $builder->join('user', 'user_has_article.id_user = user.id_user');
            $query = $builder->get();
            $user = $query->getResultArray();
            $authors = [];
            foreach ($user as $u) {
                $authors[] = [
                    "name" => $u['name'],
                    "firstname" => $u['firstname'],
                ];
            }
            $listarticles[$i]["user"] = $authors;
        }


        if ($this->request->getMethod() == 'post') {
            $rules = [
                'mail' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[user.mail]',
            ];
            $error = [
                'mail' => ['required' => "Adresse mail vide!"],
            ];

            if (!$this->validate($rules, $error)) {
                $data['validation'] = $this->validator;
            } else {
                

                $newData = [
                    'mail' => $this->request->getVar('mail'),
                ];
                $this->letters_model->save($newData);
            }
        }

        $trainings = $this->training_model->getFilterTrainings();        
        $carousel1 = listCardImgCarousel($trainings, "/training/details/");
        $articles = $this->article_model->getFilterArticles(VALIDE);
        

        $carousel2 = listCardImgCarousel($articles, "/article/list/details/");
        $data = [
            "title" => "Accueil",
            //"count_articles" => count($listarticles),
            //"count_training"=>count($trainings),
            "trainings" => $carousel1,
            "articles" => $carousel2,
        ];
        return view('Home/index.php', $data);
    }

    public function faq()
    {
        $data = [
            "title" => "FAQ"
        ];
        return view('FAQ/index.php', $data);
    }

    public function funding()
    {
        $data = [
            "title" => "Financement"
        ];
        return view('Funding/index.php', $data);
    }
}
