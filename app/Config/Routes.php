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
$routes->post('registro-responsable', 'Caja::registrarResponsable');
$routes->post('elimina-responsable', 'Caja::eliminarResponsable');

$routes->get('cuentas', 'Cuenta::index');
$routes->post('registro-cuenta', 'Cuenta::registrarCuenta');
$routes->post('elimina-cuenta', 'Cuenta::eliminarCuenta');

$routes->get('registros', 'Registro::index');
$routes->post('registro-lcaja', 'Registro::registrarLCaja');
$routes->post('lista-lcaja-dt', 'Registro::listarLCajaDT');
$routes->post('elimina-lcaja', 'Registro::eliminarLCaja');

$routes->post('formularioLCaja', 'Registro::formularioLibroCaja');
