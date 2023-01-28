<?php

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
$routes->setAutoRoute(false);// pour utliser les filtres
/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.


// Page d'acceuil
$routes->get('/', 'Home::index');

// Résultat des recherches
$routes->add('/result', 'Search::resultdata');

$routes->add('/superadmin/add/admin', 'Admin::add_admin'); // Ajout administrateur
$routes->get('/superadmin/privileges', 'Dashboard::privileges'); //dashboard des privileges

// admin
$routes->group('/admin', static function ($routes) {
    $routes->get('/', 'Admin::index');
    $routes->add('articles/edit', 'News::articles_edit');
    $routes->add('publishes/edit', 'News::publishes_edit');
    $routes->add('articles/list', 'Dashboard::listarticles');
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
    $routes->add('list', 'Former::list_former_home'); // liste des formateurs page home
    $routes->add('list/cv', 'Former::details_former_home'); // détails du formateur page home
    $routes->add('articles/edit', 'News::articles_edit');
    $routes->add('publishes/edit', 'News::publishes_edit');
    $routes->add('articles/list', 'Dashboard::listformerarticles');
    $routes->add('publishes/list', 'Dashboard::listformerpublishes');
    $routes->get('view', 'Former::former_view');
    $routes->get('profil', 'Former::profile_view'); // lecture du profil
    $routes->add('rdv', 'Former::rdv');
    $routes->add('profil/edit', 'Former::profile_view'); // modification du profil
    $routes->add('training/add', 'Former::training_add'); // création de la formation
    $routes->add('training/save', 'Former::training_save'); // création de la formation
    $routes->add('training/edit', 'Former::training_edit'); // création de la page
  
    $routes->add('videos/list', 'Dashboard::listformermedias/1'); //dashboard des videos du formateur
    $routes->add('books/list', 'Dashboard::listformermedias/2'); //dashboard des livres du formateur
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
    $routes->add('profil', 'User::profileuser'); //profil (user profil)    
    $routes->add('bill', 'User::bill'); //bill (user profil)   
    $routes->add('profil/contact', 'User::modif_contact'); //modif contact (user profil) 
    $routes->add('profil/password', 'User::modif_password'); //modif password (user profil)   
    $routes->add('profil/skill', 'User::modif_skill'); //modif skills (user profil)   
    $routes->add('profil/skill/delete/(:num)', 'User::delete_skill/$1'); //delete skills (user profil)   
    $routes->add('skill/add', 'User::add_skill'); //delete skills (user profil)   
    $routes->add('category/add', 'User::add_category'); //add category (user profil)   
    $routes->add('category/modify', 'User::modify_category'); //modify category (user profil)   
    $routes->add('category/delete', 'User::delete_category'); //add category (user profil)   
    $routes->add('profil/name', 'User::modif_name'); //modif name (user profil)  
    $routes->add('profil/save/photo', 'User::save_photo'); //save the picture (user profil)  
    $routes->add('parameters', 'User::parameters'); //parameters of user (user profil)      
});

//$routes->get('/company/profile', 'User::profilecompany'); //profil company

// menu à propos
$routes->get('/faq', 'FAQ::index');
$routes->get('/funding', 'Home::funding');

// Formations
$routes->group('/training', static function ($routes) {
    $routes->add('home', 'Training::home'); // Liste des formations visible (page home)     
    $routes->add('list', 'Training::list'); // Liste des formations visible suivant le profil utilisateur 
    $routes->add('details/(:num)', 'Training::details/$1'); // Détails de la formation hors connexion (page home)
    $routes->add('payment', 'Training::payment'); // paiement
    $routes->add('view', 'Training::view'); // Contenu de la formation payante
    $routes->add('preview', 'Dashboard::preview_training'); // Contenu des pages 
    $routes->add('dashboard', 'Dashboard::training'); // liste des formations (user profil)
    $routes->add('delete', 'Training::delete_training'); //delete training (user profil)  
    $routes->add('page/modify', 'Training::modify_page'); //modify page (user profil)  
    $routes->add('page/delete', 'Training::delete_page'); //delete page (user profil)  
});

// Articles 
$routes->group('/article', static function ($routes) {
    $routes->add('list', 'News::list_articles_home'); // liste des articles (page home)
    $routes->get('list/details/(:num)', 'News::get_details_article_home/$1'); // détails de l'article page home
    $routes->post('list/details', 'News::details_article_home'); // détails de l'article page home
    $routes->add('preview', 'Dashboard::previewarticle'); //aperçu d'un article
    $routes->add('dashboard', 'Dashboard::dashboard_article'); //tableau de bord des articles (page profil)   
    $routes->add('delete', 'News::delete_article'); //delete article (page profil)  
});

// Publications
$routes->group('/publishes', static function ($routes) {
    $routes->add('list', 'News::list_publishes_home'); // liste des publications (page home)
    $routes->add('list/details', 'News::details_publishes_home'); // détails de la publication page home
    $routes->add('preview', 'Dashboard::previewpublish'); //aperçu d'une publication
    $routes->add('dashboard', 'Dashboard::dashboard_publishes'); //tableau de bord des publications (page profil)  
    $routes->add('delete', 'News::delete_publish'); //delete publishe (page profil)   
});

//Medias
$routes->group('/media', static function ($routes) {
    $routes->get('slides', 'Media::slides');
    $routes->add('videos/list', 'Media::list_media_home/1'); // liste des vidéos (page home)
    $routes->add('books/list', 'Media::list_media_home/2'); // liste des livres (page home)
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
