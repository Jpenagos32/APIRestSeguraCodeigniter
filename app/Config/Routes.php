<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('client', 'ClientController::index');
$routes->post('client', 'ClientController::store');
$routes->get('client/(:num)', 'ClientController::show/$1');
$routes->post('client/(:num)', 'ClientController::update/$1');
$routes->delete('client/(:num)', 'ClientController::destroy/$1');

$routes->post('auth/register', 'AuthController::register');
$routes->post('auth/login', 'AuthController::login');
