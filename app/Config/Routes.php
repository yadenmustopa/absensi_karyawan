<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
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
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

//route for management login
$routes->get('/login','Login::index');
$routes->post('/auth','Login::auth');

$routes->get('/karyawans', 'Karyawans::index');
$routes->post( 'karyawans/(:num)', 'Karyawans::upload/$1');
$routes->post('/karyawans', 'Karyawans::add');
$routes->put('/karyawans/(:num)', 'Karyawans::update/$1');

$routes->get('/users', 'Users::index');
$routes->post('/users', 'Users::add');
$routes->put('/users/(:num)', 'Users::update/$1');
$routes->patch('/change_pwd', 'Users::updatePwd');
$routes->delete('/users/(:num)', 'Users::delete/$1');

$routes->get('/absens/(:num)', 'Absens::getById/$1');
$routes->get('/absens', 'Absens::index');
$routes->post('/absens/multiple', 'Absens::multiAdd');
$routes->post('/absens', 'Absens::add');
$routes->put('/absens/(:num)', 'Absens::update/$1');


$routes->get('/jabatans', 'Jabatans::index');
$routes->post('/jabatans', 'Jabatans::add');
$routes->put('/jabatans/(:num)', 'Jabatans::update/$1');
$routes->delete('/jabatans/(:num)', 'Jabatans::delete/$1');


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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
