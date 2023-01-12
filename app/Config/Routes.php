<?php

namespace Config;

use App\Controllers\Training;

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

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

// admin
$routes->get('/superadmin/profil', 'Admin::superprofile'); //Page profil super administrateur
$routes->get('/admin/profil', 'Admin::profileadmin'); // Page profil administrateur
$routes->match(['get', 'post'], '/superadmin/add/admin', 'Admin::add_admin'); // Ajout administrateur
$routes->get('/superadmin/privileges', 'Dashboard::privileges'); //dashboard des privileges
$routes->match(['get', 'post'], '/admin/articles/edit', 'News::articles_edit');
$routes->match(['get', 'post'], '/admin/publishes/edit', 'News::publishes_edit');
$routes->add('/admin/articles/list', 'Dashboard::listarticles');
$routes->add('/admin/publishes/list', 'Dashboard::listpublishes');
$routes->get('/admin', 'Admin::index');
$routes->add('/admin/videos/list', 'Dashboard::listvideos'); //dashboard des videos de tous les formateurs/admins
$routes->add('/admin/books/list', 'Dashboard::listbooks'); //dashboard des livres de tous les formateurs/admins
$routes->add('/admin/videos/edit', 'Media::videos_edit');
$routes->add('/admin/books/edit', 'Media::books_edit');

$routes->add('/contact', 'Contact::index'); // page contact

$routes->get('/admin/dashboard/former', 'Dashboard::listformers'); //dashboard des formateurs
//Former
$routes->group('/former', static function ($routes) {

    $routes->add('list', 'Former::list_formers_home'); // liste des formateurs page home
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
    $routes->add('training/edit', 'Former::training_edit'); // création de la page
    $routes->add('videos/list', 'Dashboard::listformervideos'); //dashboard des videos du formateur
    $routes->add('books/list', 'Dashboard::listformerbooks'); //dashboard des livres du formateur
    $routes->add('videos/edit', 'Media::videos_edit');
    $routes->add('books/edit', 'Media::books_edit');
});

// user
$routes->group('/user', static function ($routes) {
    $routes->match(['get', 'post'], 'login', 'User::login'); //login user
    $routes->get('logout', 'User::logout'); //logout user
    $routes->match(['get', 'post'], 'forgetpassword', 'User::forgetpassword'); //login user
    $routes->match(['get', 'post'], 'signin', 'User::signin'); //signin user
    $routes->match(['get', 'post'], 'company', 'User::confirmation'); //signin user
    $routes->add('profil', 'User::profileuser'); //profil user   
    $routes->add('bill', 'User::bill'); //profil user  
    $routes->add('profil/contact', 'User::modif_contact'); //modif contact user
    $routes->add('profil/password', 'User::modif_password'); //modif password user  
});

$routes->get('/company/profile', 'User::profilecompany'); //profil company

// menu à propos
$routes->get('/faq', 'FAQ::index');
$routes->get('/funding', 'Home::funding');

// Formations
$routes->group('/training', static function ($routes) {
    $routes->get('list', 'Training::list'); // Liste des formations visible suivant le profil utilisateur 
    $routes->get('details/(:num)', 'Training::details/$1'); // Détails de la formation hors connexion (page home)
    $routes->add('payment', 'Training::payment'); // paiement
    $routes->add('view', 'Training::view'); // Contenu de la formation payante
});


// Articles et publication 
$routes->add('/article/list', 'News::list_articles_home'); // liste des articles page home
$routes->get('/article/list/details/(:num)', 'News::get_details_article_home/$1'); // détails de l'article page home
$routes->post('/article/list/details', 'News::details_article_home'); // détails de l'article page home
$routes->add('/articles/preview', 'Dashboard::previewarticle'); //aperçu d'un article

$routes->add('/publishes/list', 'News::list_publishes_home'); // liste des publications page home
$routes->add('/publishes/list/details', 'News::details_publishes_home'); // détails de la publication page home
$routes->add('/publishes/preview', 'Dashboard::previewpublish'); //aperçu d'une publication

//Medias
$routes->group('/media', static function ($routes) {
    $routes->add('videos/list', 'Media::list_videos_home'); // liste des vidéos page home
    $routes->add('books/list', 'Media::list_books_home'); // liste des livres page home
    $routes->get('slides', 'Media::slides');
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
