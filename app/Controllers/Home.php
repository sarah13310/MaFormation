<?php

namespace App\Controllers;

use App\Models\LettersModel;
use App\Libraries\CarouselHelper;
use App\Libraries\TrainingHelper;
use App\Libraries\ArticleHelper;

class Home extends BaseController
{
    public function index()
    {
        $carousel_helper = new CarouselHelper();
        $training_helper=new TrainingHelper();
        $article_helper=new ArticleHelper();

        $db      = \Config\Database::connect();
        $builder = $db->table('article');

        $builder->where('status', '1');
        $builder->orderBy('datetime', 'DESC');
        $builder->limit(6);
        $query   = $builder->get();
        $articles = $query->getResultArray();

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
        helper(['form']);

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
                $model = new LettersModel();

                $newData = [
                    'mail' => $this->request->getVar('mail'),
                ];
                $model->save($newData);
            }
        }
                
        $trainings=$training_helper->getFilterTrainings();
        $carousel1 = $carousel_helper->listCardImgCarousel($trainings);

        $articles=$article_helper->getFilterArticles(EN_COURS);
   
        $carousel2 = $carousel_helper->listCardImgCarousel($articles);
        $data = [
            "title" => "Accueil",
            "articles" => $listarticles,
            "trainings" => $carousel1,
            "articles"=>$carousel2,
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
