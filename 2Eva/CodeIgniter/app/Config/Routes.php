<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Pages;
use App\Controllers\News;
use App\Controllers\Categories;
use App\Controllers\Users;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(false);

//$routes->get('/', 'Home::index');
$routes->get('/', [News::class, 'index']);
$routes->get('news', [News::class, 'index']);
$routes->get('news/new', [News::class, 'new']);
$routes->post('news/', [News::class, 'create']);
$routes->get('news/(:segment)', [News::class, 'show']);
$routes->get('news/del/(:segment)', [News::class, 'delete']);
$routes->post('news/update/updated/(:num)', [News::class, 'updatedItem']);
$routes->get('news/update/(:num)', [News::class, 'update']);

$routes->get('categories', [Categories::class, 'index']);

$routes->get('categories/new', [Categories::class, 'new']);
$routes->post('categories/', [Categories::class, 'create']);

$routes->get('categories/del/(:num)', [Categories::class, 'delete']);
$routes->get('categories/update/(:num)', [Categories::class, 'update']);
$routes->post('categories/update/updated/(:num)', [Categories::class, 'updatedItem']);

$routes->get('admin', [Users::class, 'loginForm']);
$routes->post('login', [Users::class, 'checkUser']);


// $routes->get('pages', [Pages::class, 'index']);
// $routes->get('(:segment)', [Pages::class, 'view']);
