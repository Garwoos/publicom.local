<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/login','Login::index');

$routes->post('/loginUser','LoginUserController::index');

$routes->get('/create', 'Create::index');

$routes->get('/History/(:num)', 'History::index/$1');

$routes->post('/createMessage', 'CreateMessageController::index');

$routes->post('/deleteMessage', 'DeleteMessageController::index');

$routes->post('/updateMessage', 'UpdateMessageController::index');
