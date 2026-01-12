<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');

$routes->get('/', 'Hotel::index');
$routes->get('chambre/(:segment)', 'Hotel::detail/$1'); // (:segment) car chamb_id est un Varchar (ex: DBL001)
$routes->post('reserver', 'Hotel::reserver');

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');
$routes->get('logout', 'AuthController::logout');

