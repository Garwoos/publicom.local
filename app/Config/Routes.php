<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/login','Login::index');

$routes->post('/loginUser','LoginUserController::index');

$routes->get('/create', 'Create::index');

$routes->get('/modify/(:num)', 'Modify::index/$1');

$routes->post('/createMessage', 'MessageController::create');

$routes->post('/delete/(:num)', 'MessageController::delete/$1');

$routes->put('/updateMessage', 'MessageController::update');

$routes->put('/updateOnlineStatus', 'MessageController::updateOnlineStatus');

$routes->get('/visualisationMessage', 'VisualisationController::visualize');

$routes->get('/HistoriqueController/(:num)', 'HistoriqueController::history/$1');

$routes->get('/navigateEvent', 'VisualisationController::navigateEvent');
