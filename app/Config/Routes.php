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
$routes->get('/superadmin/profil', 'Admin::superprofile');
$routes->get('/admin/profil', 'Admin::profileadmin');
$routes->get('/admin/dashboard/former', 'Dashboard::listformers');//dashboard des formateurs

$routes->get('/admin', 'Admin::index');
$routes->get('/contact', 'Contact::index');

// former
$routes->get('/former/view', 'Former::former_view');
$routes->get('/former/list', 'Former::former_list');
$routes->get('/former/profil', 'Former::profile_view');

// user
$routes->match(['get', 'post'], 'login', 'User::login'); //login user
$routes->get('logout', 'User::logout'); //logout user
$routes->match(['get', 'post'], '/forgetpassword', 'User::forgetpassword'); //login user
$routes->match(['get', 'post'], '/signin', 'User::signin'); //signin user
$routes->match(['get', 'post'], '/company', 'User::confirmation'); //signin user
$routes->get('/user/profile', 'User::profileuser'); //profil user
$routes->get('/company/profile', 'User::profilecompany'); //profil company

// menu a propos
$routes->get('/formateurs', 'Former::index');
$routes->get('/faq', 'FAQ::index');
$routes->get('/formations', 'Training::index');
$routes->get('/financement', 'Funding::index');

// menu actualités
$routes->get('/articles', 'News::index');
$routes->get('/publications', 'News::publish');
$routes->match(['get', 'post'], '/articlesedit', 'News::articlesedit');
$routes->match(['get', 'post'], '/publishesedit', 'News::publishesedit');
$routes->get('/videos', 'Media::videos');
$routes->get('/livres', 'Media::books');

$routes->get('/paymentcb', 'Payment::paymentcb');

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
