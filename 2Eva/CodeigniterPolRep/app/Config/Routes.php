<?php

use CodeIgniter\Router\RouteCollection;

use App\Controllers\Artistas;
use App\Controllers\Canciones;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(false);

// Rutas de Inicio (Home)
$routes->get('/', 'Canciones::index');

// Rutas para Canciones 
$routes->get('canciones', [Canciones::class, 'index']);
$routes->get('canciones/new', [Canciones::class, 'new']); 
$routes->post('canciones', [Canciones::class, 'create']); 
$routes->get('canciones/del/(:num)',[Canciones::class, 'delete']);
$routes->post('canciones/update/updated/(:num)',[Canciones::class, 'updatedItem']);
$routes->get('canciones/update/(:num)',[Canciones::class, 'update']);
// La ruta con segmento variable DEBE ir al final de las rutas de Canciones
$routes->get('canciones/(:segment)', [Canciones::class, 'show']); 


// Rutas para Artistas
$routes->get('artistas', [Artistas::class, 'index']);
$routes->get('artistas/new', [Artistas::class, 'new']); 
$routes->post('artistas', [Artistas::class, 'create']); 
$routes->get('artistas/del/(:num)',[Artistas::class, 'delete']);
$routes->post('artistas/update/updated/(:num)', [Artistas::class, 'updatedItem']);
$routes->get('artistas/update/(:num)',[Artistas::class, 'update']);
// La ruta con segmento variable DEBE ir al final de las rutas de artistas
$routes->get('artistas/(:segment)', [Artistas::class, 'show']); 