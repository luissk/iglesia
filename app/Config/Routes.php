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

//$routes->get('cajas', 'Caja::index');
$routes->get('cajas-(:any)', 'Caja::index/$1');
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

$routes->get('reportes-registros', 'Registro::reportesRegistros');
$routes->post('genera-reportelcaja', 'Registro::generaReporteLCaja');
$routes->get('pdfLCaja/(:any)/(:any)/(:any)', 'Registro::pdfLCaja/$1/$2/$3');
$routes->get('pdfLCaja/(:any)/(:any)', 'Registro::pdfLCaja/$1/$2');

$routes->post('formularioLCaja', 'Registro::formularioLibroCaja');

$routes->get('nueva-compra', 'Registro::nuevaCompra');
$routes->get('editar-compra-(:num)', 'Registro::nuevaCompra/$1');
$routes->post('lista-proveedor-dt', 'Registro::listaProveedorDT');
$routes->post('registro-proveedor','Registro::registrarProveedor');
$routes->post('elimina-proveedor','Registro::eliminarProveedor');
$routes->post('registro-compra','Registro::registrarCompra');

$routes->post('lista-lcompra-dt', 'Registro::listarLCompraDT');
$routes->post('elimina-lcompra', 'Registro::eliminarLCompra');

$routes->post('genera-reportelcompra', 'Registro::generaReporteLCompra');
$routes->get('pdfLCompra/(:any)/(:any)', 'Registro::pdfLCompra/$1/$2/$3');

$routes->post('genera-reportediario', 'Registro::generaReporteDiario');
$routes->get('pdfDiario/(:any)/(:any)', 'Registro::pdfDiario/$1/$2');

$routes->post('genera-reportecuenta', 'Registro::generaReportePorCuenta');

$routes->get('nueva-venta', 'Registro::nuevaVenta');
$routes->get('editar-venta-(:num)', 'Registro::nuevaVenta/$1');
