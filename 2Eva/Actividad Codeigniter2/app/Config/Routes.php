<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Viajes;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(false);

$routes->get('/', [Viajes::class, 'index']);
$routes->get('viajes', [Viajes::class, 'index']);
$routes->get('viajes/new', [Viajes::class, 'new']);
$routes->post('viajes/', [Viajes::class, 'create']);
$routes->post('viajes/update/updated/(:num)', [Viajes::class, 'updatedItem']);
$routes->get('viajes/update/(:num)', [Viajes::class, 'update']);
$routes->get('viajes/del/(:num)', [Viajes::class, 'delete']);
$routes->get('viajes/(:num)', [Viajes::class, 'show']);