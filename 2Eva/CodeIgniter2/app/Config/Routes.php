<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Conciertos;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(false);

$routes->get('/', 'Conciertos::index');
$routes->get('conciertos/(:num)', [Conciertos::class, 'show']);

