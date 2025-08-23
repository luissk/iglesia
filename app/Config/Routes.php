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

$routes->get('cajas', 'Caja::index');
$routes->post('registro-caja', 'Caja::registrarCaja');
$routes->post('elimina-caja', 'Caja::eliminarCaja');

$routes->get('registros', 'Registro::index');
