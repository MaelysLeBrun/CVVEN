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
$routes->get('disponibilite/(:segment)', 'Hotel::disponibilite/$1');
$routes->get('mes-reservations', 'Hotel::mesReservations');
$routes->post('mes-reservations/annuler/(:num)', 'Hotel::annuler/$1');
$routes->post('reserver', 'Hotel::reserver');

// Formulaire de réservation (utilisateur connecté)
$routes->get('reservation', 'Reservation::formulaire');
$routes->post('reservation/reserver', 'Reservation::reserver');
$routes->post('reservation/checkDisponibilite', 'Reservation::checkDisponibilite');

// Administration (réservé aux administrateurs)
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('users', 'AdminController::users');
    $routes->get('users/edit/(:segment)', 'AdminController::editUser/$1');
    $routes->post('users/update/(:segment)', 'AdminController::updateUser/$1');
    $routes->post('users/delete/(:segment)', 'AdminController::deleteUser/$1');
    $routes->get('reservations', 'AdminController::reservations');
    $routes->get('reservations/edit/(:num)', 'AdminController::editReservation/$1');
    $routes->post('reservations/update/(:num)', 'AdminController::updateReservation/$1');
    $routes->post('reservations/delete/(:num)', 'AdminController::deleteReservation/$1');
});


