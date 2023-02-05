<?php

namespace App\Controllers;

use App\Libraries\CarouselHelper;

// Le 10/01/2023
// Le 05/02/2023
class Home extends BaseController
{
    /**
     * index
     * page Acceuil
     * @return void
     */
    private function home($err = null)
    {
        try {

            $db      = \Config\Database::connect();
            $builder = $db->table('article');
            $builder->where('status', VALIDE);
            $builder->orderBy('datetime', 'DESC');
            $builder->limit(6);
            $query   = $builder->get();
            $articles = $query->getResultArray();
            //$articles=$this->article_model->getFilterArticles(VALIDE,6,'DESC');

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
        $this->article_model->getAuthorsArticles($listarticles, $builder);

        if ($this->isPost()) {
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
        //
        $carousel2 = listCardImgCarousel($articles, "/article/list/details/");
        // var_dump($err);
        $data = [
            "title" => "Accueil",
            "trainings" => $carousel1,
            "articles" => $carousel2,
            "validation" => $err,
        ];

        return view('Home/index.php', $data);
    }

    public function index()
    {
        return $this->home();
    }

    /**
     * faq
     * Page des questions posées fréquemment 
     * @return void
     */
    public function faq()
    {
        $data = [
            "title" => "FAQ"
        ];
        return view('FAQ/index.php', $data);
    }

    /**
     * funding
     * page de financement
     * @return void
     */
    public function funding()
    {
        $data = [
            "title" => "Financement"
        ];
        return view('Funding/index.php', $data);
    }

    /**
     * newsletters
     * Page de confirmation d'abonnement à la lettre d'informations
     * @return void
     */
    public function newsletters()
    {
        if ($this->isPost()) {
            $mail = $this->request->getVar('mail');            
            
                $data = [
                    "title" => "Lettre d'informations",
                    "mail" => $mail,
                ];
                return view('Home/newsletters.php', $data);
            }
        }
    
}
