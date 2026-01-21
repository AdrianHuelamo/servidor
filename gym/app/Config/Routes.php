<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index');

$routes->get('grupos', 'Grupos::index');                  
$routes->get('grupos/show/(:num)', 'Grupos::show/$1');    

$routes->get('ejercicios', 'Ejercicios::index');         
$routes->get('ejercicios/show/(:num)', 'Ejercicios::show/$1'); 
$routes->post('ejercicios/autocomplete', 'Ejercicios::autocomplete');

$routes->get('noticias', 'Noticias::index');
$routes->get('noticias/show/(:num)', 'Noticias::show/$1');

$routes->get('login', 'Users::loginForm');
$routes->post('login', 'Users::checkUser');
$routes->get('registro', 'Users::registerForm');
$routes->post('register/create', 'Users::createUser');
$routes->get('logout', 'Users::logout');


$routes->group('admin', ['filter' => 'adminAuth'], function($routes) {
    $routes->get('/', 'Admin::index');

    $routes->get('ejercicios', 'Admin::ejercicios');              
    $routes->get('ejercicios/delete/(:num)', 'Admin::deleteEjercicio/$1'); 
    
    $routes->get('grupos', 'Admin::grupos');
    $routes->get('grupos/delete/(:num)', 'Admin::deleteGrupo/$1'); 
    
    $routes->get('noticias', 'Admin::noticias');
    $routes->get('noticias/delete/(:num)', 'Admin::deleteNoticia/$1'); 

    $routes->get('usuarios', 'Admin::usuarios');
});