<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Canciones;
use App\Controllers\Cantantes;
use App\Controllers\Categories;


/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(false);

$routes->get('/', [Canciones::class, 'index']);
$routes->get('canciones', [Canciones::class, 'index']);
$routes->get('canciones/new', [Canciones::class, 'new']);
$routes->post('canciones', [Canciones::class, 'create']);
$routes->post('canciones/update/updated/(:num)', [Canciones::class, 'updatedItem']);
$routes->get('canciones/update/(:num)', [Canciones::class, 'update']);
$routes->get('canciones/del/(:num)', [Canciones::class, 'delete']);
$routes->get('canciones/(:num)', [Canciones::class, 'show']);

$routes->get('cantantes', [Cantantes::class, 'index']);

$routes->get('cantantes/new', [Cantantes::class, 'new']);
$routes->post('cantantes/', [Cantantes::class, 'create']);

$routes->get('cantantes/del/(:num)', [Cantantes::class, 'delete']);
$routes->get('cantantes/update/(:num)', [Cantantes::class, 'update']);
$routes->post('cantantes/update/updated/(:num)', [Cantantes::class, 'updatedItem']);