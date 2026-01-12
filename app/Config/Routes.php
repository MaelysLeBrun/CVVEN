<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');

$routes->get('/', 'Hotel::index');           // page d'accueil du site
$routes->get('login', 'LoginController::login');
$routes->post('login', 'LoginController::attemptLogin');
$routes->get('logout', 'LoginController::logout');
// Inscription
$routes->get('register', 'LoginController::showRegister');
$routes->post('register', 'LoginController::register');

$routes->get('chambre/(:segment)', 'Hotel::detail/$1');
$routes->post('reserver', 'Hotel::reserver');


