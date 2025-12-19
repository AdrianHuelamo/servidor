<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Eventos;
use App\Controllers\Ciudades;


/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(false);

$routes->get('/', [Eventos::class, 'index']);
$routes->get('eventos', [Eventos::class, 'index']);
$routes->get('eventos/new', [Eventos::class, 'new']);
$routes->post('eventos/create', [Eventos::class, 'create']);
$routes->post('eventos/update/updated/(:num)', [Eventos::class, 'updatedItem']);
$routes->get('eventos/update/(:num)', [Eventos::class, 'update']);
$routes->get('eventos/del/(:num)', [Eventos::class, 'delete']);
$routes->get('eventos/(:num)', [Eventos::class, 'show']);
