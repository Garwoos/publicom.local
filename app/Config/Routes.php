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

$routes->post('/deleteMessage', 'MessageController::delete');

$routes->put('/updateMessage', 'MessageController::update');

$routes->put('/updateOnlineStatus', 'MessageController::updateOnlineStatus');

$routes->get('/visualisationMessage', 'VisualisationController::visualize');

$routes->get('/HistoriqueMessage/(:num)', 'ModificationController::history/$1');

$routes->get('/visualisation/navigate', 'VisualisationController::navigate');
