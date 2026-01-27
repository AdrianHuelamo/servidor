<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Personajes;


/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Personajes::class, 'index']);
$routes->get('personajes', [Personajes::class, 'index']);
