<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');

$routes->get('/', 'Hotel::index');
$routes->get('chambre/(:segment)', 'Hotel::detail/$1'); // (:segment) car chamb_id est un Varchar (ex: DBL001)
$routes->post('reserver', 'Hotel::reserver');
