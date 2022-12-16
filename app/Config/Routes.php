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

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

// admin
$routes->get('/superadmin/profil', 'Admin::superprofile');//Page profil super administrateur
$routes->get('/admin/profil', 'Admin::profileadmin');// Page profil administrateur
$routes->match(['get', 'post'],'/superadmin/add/admin', 'Admin::add_admin');// Ajout administrateur
$routes->get('/superadmin/privileges', 'Dashboard::privileges');//dashboard des privileges
$routes->match(['get', 'post'], '/admin/articles/edit', 'News::articles_edit');
$routes->match(['get', 'post'], '/admin/publishes/edit', 'News::publishes_edit');


$routes->get('/admin', 'Admin::index');

//Former
$routes->get('/admin/dashboard/former', 'Dashboard::listformers');//dashboard des formateurs
$routes->match(['get', 'post'],'/former/list', 'Former::list_formers_home');// liste des formateurs page home
$routes->add('/former/list/cv', 'Former::details_former_home');// détails du formateur page home
$routes->match(['get', 'post'],'/contact', 'Contact::index');// page contact

$routes->get('/former/view', 'Former::former_view');
$routes->get('/former/profil', 'Former::profile_view');
$routes->add('/former/rdv', 'Former::rdv');
$routes->add('/former/profil/edit', 'Former::profile_view');

// user
$routes->match(['get', 'post'], '/login', 'User::login'); //login user
$routes->get('logout', 'User::logout'); //logout user
$routes->match(['get', 'post'], '/forgetpassword', 'User::forgetpassword'); //login user
$routes->match(['get', 'post'], '/signin', 'User::signin'); //signin user
$routes->match(['get', 'post'], '/company', 'User::confirmation'); //signin user
$routes->get('/user/profile', 'User::profileuser'); //profil user
$routes->get('/company/profile', 'User::profilecompany'); //profil company


//article et publication
$routes->add('/admin/dashboard/article', 'Dashboard::listarticles');

// menu a propos
$routes->get('/faq', 'FAQ::index');
$routes->get('/funding', 'Home::funding');
$routes->get('/formations', 'Training::index');


// menu actualités
$routes->get('/articles', 'News::index');
$routes->get('/publications', 'News::publish');
$routes->get('/paymentcb', 'Payment::paymentcb');

//Medias
$routes->get('/medias/slides', 'Media::slides');
$routes->get('/medias/videos', 'Media::videos');
$routes->get('/medias/livres', 'Media::books');




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
