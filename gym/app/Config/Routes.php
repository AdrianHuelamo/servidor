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
$routes->get('ejercicios/favorito/(:num)', 'Ejercicios::toggleFavorito/$1');
$routes->get('mis-favoritos', 'Ejercicios::misFavoritos');

$routes->get('noticias', 'Noticias::index');
$routes->get('noticias/show/(:num)', 'Noticias::show/$1');

$routes->get('login', 'Users::loginForm');
$routes->post('login', 'Users::checkUser');
$routes->get('registro', 'Users::registerForm');
$routes->post('register/create', 'Users::createUser');
$routes->get('logout', 'Users::logout');

$routes->get('rutinas', 'Rutinas::index');
$routes->post('rutinas/create', 'Rutinas::create');
$routes->get('rutinas/show/(:num)', 'Rutinas::show/$1');
$routes->get('rutinas/delete/(:num)', 'Rutinas::delete/$1');

$routes->post('rutinas/addEjercicio/(:num)', 'Rutinas::addEjercicio/$1');
$routes->post('rutinas/update/(:num)', 'Rutinas::update/$1');
$routes->get('rutinas/removeEjercicio/(:num)/(:num)', 'Rutinas::removeEjercicio/$1/$2');



$routes->group('admin', ['filter' => 'adminAuth'], function($routes) {
    
    $routes->get('/', 'Admin::index');

    $routes->get('ejercicios', 'Admin::ejercicios');                      
    
    $routes->get('ejercicios/new', 'Admin::newEjercicio');      
    $routes->post('ejercicios/create', 'Admin::createEjercicio'); 
    
    $routes->get('ejercicios/edit/(:num)', 'Admin::editEjercicio/$1');      
    $routes->post('ejercicios/update/(:num)', 'Admin::updateEjercicio/$1');

    $routes->get('ejercicios/destacar/(:num)', 'Admin::toggleDestacado/$1');

    $routes->get('ejercicios/delete/(:num)', 'Admin::deleteEjercicio/$1'); 

    $routes->get('grupos', 'Admin::grupos');

    $routes->get('grupos/new', 'Admin::newGrupo');
    $routes->post('grupos/create', 'Admin::createGrupo');

    $routes->get('grupos/edit/(:num)', 'Admin::editGrupo/$1');
    $routes->post('grupos/update/(:num)', 'Admin::updateGrupo/$1');

    $routes->get('grupos/delete/(:num)', 'Admin::deleteGrupo/$1'); 
    
    $routes->get('noticias', 'Admin::noticias');

    $routes->get('noticias/new', 'Admin::newNoticia');
    $routes->post('noticias/create', 'Admin::createNoticia');

    $routes->get('noticias/edit/(:num)', 'Admin::editNoticia/$1');
    $routes->post('noticias/update/(:num)', 'Admin::updateNoticia/$1');

    $routes->get('noticias/delete/(:num)', 'Admin::deleteNoticia/$1'); 

    $routes->get('usuarios', 'Admin::usuarios');
    $routes->get('usuarios/delete/(:num)', 'Admin::deleteUsuario/$1');

    $routes->get('rutinas', 'Admin::rutinas');
    $routes->get('rutinas/delete/(:num)', 'Admin::deleteRutina/$1');
});