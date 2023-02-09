<?php
// le 04/02/2023

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}
/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false); // pour utliser les filtres
/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.


// Page d'acceuil
$routes->get('/', 'Home::index');

//newsletter envoie
$routes->add('/newsletters', 'Home::newsletters');

// Résultat des recherches
$routes->add('/result', 'Search::resultdata', ['filter' => 'cache']);

//$routemap['find-by']='Search::resultdata';
//$routes->map($routemap);

$routes->add('/superadmin/add/admin', 'Admin::add_admin', ['filter' => 'auth']); // Ajout administrateur
$routes->get('/superadmin/privileges', 'Dashboard::privileges', ['filter' => 'auth']); //dashboard des privileges

// admin
$routes->group('/admin', static function ($routes) {
    $routes->get('/', 'Admin::index');
    $routes->add('articles/edit', 'News::articles_edit', ['filter' => 'auth']);
    $routes->add('publishes/edit', 'News::publishes_edit', ['filter' => 'auth']);
    $routes->add('articles/list', 'Dashboard::listarticles', ['filter' => 'auth']);
    $routes->add('publishes/list', 'Dashboard::listpublishes');
    $routes->add('videos/list', 'Dashboard::listmedias/1'); //dashboard des videos de tous les formateurs/admins
    $routes->add('books/list', 'Dashboard::listmedias/2'); //dashboard des livres de tous les formateurs/admins
    $routes->add('videos/edit', 'Media::medias_edit/1');
    $routes->add('books/edit', 'Media::medias_edit/2');
});

$routes->add('/contact', 'Contact::index'); // page contact

$routes->get('/admin/dashboard/former', 'Dashboard::listformers'); //dashboard des formateurs
//Former
$routes->group('/former', static function ($routes) {
    $routes->add('list', 'Former::list_former_home'); // list of formers  (page home)
    $routes->add('list/cv', 'Former::details_former_home'); // details former (page home)
    $routes->add('articles/edit', 'News::articles_edit');
    $routes->add('publishes/edit', 'News::publishes_edit');
    $routes->add('articles/list', 'Dashboard::listarticles');
    $routes->add('publishes/list', 'Dashboard::listpublishes');
    $routes->get('view', 'Former::former_view');
    $routes->get('profil', 'Former::profile_view'); // view profil

    $routes->add('profil/edit', 'Former::profile_view'); // modify profil

    $routes->add('training/save', 'Training::training_save'); // create training
    $routes->add('training/edit', 'Former::page_modify'); // create page

    $routes->add('videos/list', 'Dashboard::listmedias/1'); //dashboard videos in former's profil
    $routes->add('books/list', 'Dashboard::listmedias/2'); //dashboard books in former's profil
    $routes->add('videos/edit', 'Media::medias_edit/1');
    $routes->add('books/edit', 'Media::medias_edit/2');
});

// user (profils communs)
$routes->group('/user', static function ($routes) {
    $routes->add('login', 'User::login'); //login user
    $routes->get('logout', 'User::logout'); //logout user
    $routes->add('forgetpassword', 'User::forgetpassword'); //login connection to user
    $routes->add('signin', 'User::signin'); //signin create user profil
    $routes->add('company', 'User::confirmation'); //signin create user profil
    $routes->add('profil', 'User::profileuser', ['filter' => 'auth']); //profil (user profil)    
    $routes->add('bill', 'User::bill', ['filter' => 'auth']); //bill (user profil)   
    $routes->add('profil/contact', 'User::modif_contact', ['filter' => 'auth']); //modif contact (user profil) 
    $routes->add('profil/password', 'User::modif_password', ['filter' => 'auth']); //modif password (user profil)   
    $routes->add('profil/skill', 'User::modif_skill', ['filter' => 'auth']); //modif skills (user profil)   
    $routes->add('profil/skill/delete/(:num)', 'User::delete_skill/$1', ['filter' => 'auth']); //delete skills (user profil)   
    $routes->add('skill/add', 'User::add_skill', ['filter' => 'auth']); //delete skills (user profil)   
    $routes->add('category/add', 'User::add_category', ['filter' => 'auth']); //add category (user profil)   
    $routes->add('category/modify', 'User::modify_category', ['filter' => 'auth']); //modify category (user profil)   
    $routes->add('category/delete', 'User::delete_category', ['filter' => 'auth']); //add category (user profil)   
    $routes->add('profil/name', 'User::modif_name', ['filter' => 'auth']); //modif name (user profil)  
    $routes->add('profil/save/photo', 'User::save_photo', ['filter' => 'auth']); //save the picture (user profil)  
    $routes->add('parameters', 'User::parameters', ['filter' => 'auth']); //parameters of user (user profil)      
    $routes->add('list/(:segment)', "User::list_user/$1", ['filter' => 'auth']); // list user (company or ordinary customer)
    $routes->add('rdv/add', 'User::edit_rdv', ['filter' => 'auth']); //add rdv 
    $routes->add('rdv/save', 'User::save_rdv', ['filter' => 'auth']); //save rdv 
    $routes->add('rdv/list', 'User::list_rdv', ['filter' => 'auth']); //list rdv 
    $routes->add('rdv/delete', 'User::delete_rdv', ['filter' => 'auth']); //delete rdv 
});

// menu à propos
$routes->get('/faq', 'FAQ::index');
$routes->get('/funding', 'Home::funding');

// Formations
$routes->group('/training', static function ($routes) {
    $routes->add('home', 'Training::home'); // Liste des formations visible (page home)     
    $routes->add('list', 'Training::list'); // Liste des formations visible suivant le profil utilisateur 
    $routes->add('details/(:num)', 'Training::details/$1'); // Détails de la formation hors connexion (page home)
    $routes->add('payment', 'Training::payment', ['filter' => 'auth']); // paiement
    $routes->add('view', 'Training::view'); // Contenu de la formation payante
    $routes->add('preview', 'Dashboard::preview_training', ['filter' => 'auth']); // Contenu des pages 
    $routes->add('dashboard', 'Training::dashboard_training', ['filter' => 'auth']); // liste des formations (user profil)
    $routes->add('add', 'Training::training_add', ['filter' => 'auth']); // add training
    $routes->add('delete', 'Training::delete_training', ['filter' => 'auth']); //delete training (user profil)  
    $routes->add('page/add', 'Training::add_page', ['filter' => 'auth']); //add page (user profil)  
    $routes->add('page/modify', 'Training::modify_page', ['filter' => 'auth']); //modify page (user profil)
    $routes->add('page/save', 'Training::save_page', ['filter' => 'auth']); //modify page (user profil)  
    $routes->add('page/delete', 'Training::delete_page', ['filter' => 'auth']); //delete page (user profil)  
});

// Articles 
$routes->group('/article', static function ($routes) {
    $routes->add('list', 'News::list_articles_home'); // liste des articles (page home)
    $routes->get('list/details/(:num)', 'News::get_details_article_home/$1'); // détails de l'article page home
    $routes->post('list/details', 'News::details_article_home'); // détails de l'article page home
    $routes->add('preview', 'Dashboard::previewarticle'); //aperçu d'un article
    $routes->add('dashboard', 'Dashboard::dashboard_article', ['filter' => 'auth']); //tableau de bord des articles (page profil)   
    $routes->add('delete', 'News::delete_article', ['filter' => 'auth']); //delete article (page profil)  
});

// Publications
$routes->group('/publishes', static function ($routes) {
    $routes->add('list', 'News::list_publishes_home'); // liste des publications (page home)
    $routes->add('list/details', 'News::details_publishes_home'); // détails de la publication page home
    $routes->add('preview', 'Dashboard::previewpublish'); //aperçu d'une publication
    $routes->add('dashboard', 'Dashboard::dashboard_publishes', ['filter' => 'auth']); //tableau de bord des publications (page profil)  
    $routes->add('delete', 'News::delete_publish', ['filter' => 'auth']); //delete publishe (page profil)   
});

//Medias
$routes->group('/media', static function ($routes) {
    $routes->get('slides', 'Media::slides');
    $routes->add('videos/list', 'Media::list_media_home/1'); // liste des vidéos (page home)
    $routes->add('books/list', 'Media::list_media_home/2'); // liste des livres (page home)
    $routes->add('dashboard/videos', 'Dashboard::dashboard_media/1', ['filter' => 'auth']); // tableau de bord des vidéos (page profil)
    $routes->add('dashboard/books', 'Dashboard::dashboard_media/2', ['filter' => 'auth']); // tableau de bord des livres (page profil)
    $routes->add('delete', 'Media::delete_media', ['filter' => 'auth']); //delete vidéo/livre (page profil)
});

/*
* --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
