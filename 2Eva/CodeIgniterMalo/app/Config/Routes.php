<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Pages;
use App\Controllers\News;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(false);

// $routes->get('/', 'Home::index');

$routes->get('/', [News::class, 'index']);
$routes->get('news/new', [News::class, 'new']); // Formulario insertar
$routes->post('insert_news', [News::class, 'create']); // Enviar formulario insertar
$routes->get('news/(:segment)', [News::class, 'show']);
$routes->get('news/del/(:num)', [News::class, 'delete']);

$routes->post('news/update/updated/(:num)', [News::class, 'updatedItem']); // enviar Formulario update
$routes->get('news/update/(:num)', [News::class, 'update']); // mostrar Formulario update

$routes->get('pages', [Pages::class, 'index']);
$routes->get('(:segment)', [Pages::class, 'view']);