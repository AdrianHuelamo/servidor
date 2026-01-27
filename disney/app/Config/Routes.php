<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Personajes;


/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Personajes::class, 'index']);
$routes->get('personajes', [Personajes::class, 'index']);
$routes->get('personajes', [Personajes::class, 'index']);
$routes->get('personajes/new', [Personajes::class, 'new']);
$routes->post('personajes', [Personajes::class, 'create']);
$routes->post('personajes/update/updated/(:num)', [Personajes::class, 'updatedItem']);
$routes->get('personajes/update/(:num)', [Personajes::class, 'update']);
$routes->get('personajes/del/(:num)', [Personajes::class, 'updatedItem']);
$routes->get('personajes/(:num)', [Personajes::class, 'show']);
