<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Inicio::index');
$routes->post('/', 'Inicio::index');
$routes->get('salir', 'Inicio::salir');
$routes->get('sistema', 'Inicio::sistema');

$routes->get('iglesias', 'Iglesia::index');
$routes->post('registro-iglesia', 'Iglesia::registrarIglesia');
$routes->post('elimina-iglesia', 'Iglesia::eliminarIglesia');

$routes->get('usuarios', 'Usuario::index');
$routes->post('registro-usuario', 'Usuario::registrarUsuario');
$routes->post('elimina-usuario', 'Usuario::eliminarUsuario');

$routes->get('registros', 'Registro::index');
