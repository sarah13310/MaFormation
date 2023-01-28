<?php

namespace App\Controllers;

use App\Models\ArticleHasPublicationModel;
use App\Models\ArticleModel;
use App\Models\BillModel;
use App\Models\CategoryHasMediaModel;
use App\Models\CategoryModel;
use App\Models\CertificateModel;
use App\Models\CompanyModel;
use App\Models\ContactModel;
use App\Models\LettersModel;
use App\Models\LogModel;
use App\Models\MediaModel;
use App\Models\PageModel;
use App\Models\PublicationModel;
use App\Models\RdvModel;
use App\Models\StatusModel;
use App\Models\TagModel;
use App\Models\TrainingHasPageModel;
use App\Models\TrainingModel;
use App\Models\TypeSlideModel;
use App\Models\UserHasArticleModel;
use App\Models\UserHasCertificateModel;
use App\Models\UserHasCompanyModel;
use App\Models\UserHasMediaModel;
use App\Models\UserHasTrainingModel;
use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use DateTime;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
   /**
    * Instance of the main Request object.
    *
    * @var CLIRequest|IncomingRequest
    */
   protected $request;

   /**
    * An array of helpers to be loaded automatically upon
    * class instantiation. These helpers will be available
    * to all other controllers that extend BaseController.
    *
    * @var array
    */
   protected $helpers = ['util'];

   protected $training_model;
   protected $user_model;
   protected $page_model;
   protected $article_has_publication_model;
   protected $article_model;
   protected $bill_model;
   protected $category_model;
   protected $category_has_media_model;
   protected $certificat_model;
   protected $company_model;
   protected $contact_model;
   protected $letters_model;
   protected $log_model;
   protected $media_model;
   protected $publication_model;
   protected $rdv_model;
   protected $status_model;
   protected $tag_model;
   protected $training_has_page_model;
   protected $typeslide_model;
   protected $user_has_article_model;
   protected $user_has_certificate_model;
   protected $user_has_company_model;
   protected $user_has_training_model;
   protected $user_has_media_model;
   /**
    * Constructor.
    */

   /**
    * isPost
    *
    * @return void
    */
   public function isPost()
   {
      return ($this->request->getMethod(TRUE) === "POST");
   }

   /**
    * isGet
    *
    * @return void
    */
   public function isGet()
   {
      return ($this->request->getMethod(TRUE) === "GET");
   }

   /**
    * getUserSession
    *
    * @return void
    */
   public function getUserSession()
   {
      return $this->user_model->getUserSession();
   }

   /**
    * verifySession
    *
    * @return void
    */
   public function verifySession()
   {
      $last = session()->get('__ci_last_regenerate');
      $date = time();
      $diff = $date - $last;
      echo $diff;
      if ($diff>=30){
         echo ('fin de session');
         command('cache:clear');
         return redirect(base_url().'/user/login', 'refresh');
      }      
   }

   public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
   {
      // Do Not Edit This Line
      parent::initController($request, $response, $logger);

      // Preload any models, libraries, etc, here.
      $this->article_has_publication_model = new ArticleHasPublicationModel();
      $this->article_model = new ArticleModel();
      $this->bill_model = new BillModel();
      $this->category_model = new CategoryModel();
      $this->category_has_media_model = new CategoryHasMediaModel();
      $this->certificat_model = new CertificateModel();
      $this->company_model = new CompanyModel();
      $this->contact_model = new ContactModel();
      $this->letters_model = new LettersModel();
      $this->log_model = new LogModel();
      $this->media_model = new MediaModel();
      $this->page_model = new PageModel();
      $this->publication_model = new PublicationModel();
      $this->rdv_model = new RdvModel();
      $this->status_model = new StatusModel();
      $this->tag_model = new TagModel();
      $this->training_has_page_model = new TrainingHasPageModel();
      $this->training_model = new TrainingModel();
      $this->typeslide_model = new TypeSlideModel();
      $this->user_has_article_model = new UserHasArticleModel();
      $this->user_has_certificate_model = new UserHasCertificateModel();
      $this->user_has_company_model = new UserHasCompanyModel();
      $this->user_has_training_model = new UserHasTrainingModel();
      $this->user_model = new UserModel();
      $this->user_has_media_model = new UserHasMediaModel();

      // E.g.: $this->session = \Config\Services::session();
   }
}
