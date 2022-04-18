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
 * API Route
 * --------------------------------------------------------------------
 */
$routes -> group('api', ['namespace' => 'App\Controllers\api'], function ($routes){

    $routes -> group('users', function ($routes){
        $routes -> post('create', 'UsersController::create');
        $routes -> get('get/all/clabes', 'UsersController::getAllClabe');
        $routes -> get('get/(:num)', 'UsersController::getUser/$1');
        $routes -> get('get/(:num)/(:num)', 'UsersController::getUser/$1/$2');
    });

    $routes -> group('balances', function ($routes){
        $routes -> get('get/(:num)', 'BalancesController::getBalanceByIdUser/$1');
    });

    $routes -> group('requests', function ($routes){
        $routes -> post('create', 'RequestsController::createRequest');
        $routes -> get('get/(:num)', 'RequestsController::getRequestByUser/$1');
    });

    $routes -> get('type_request/get/all', 'TypeRequestController::getAll');
});


/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

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
