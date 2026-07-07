<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class Asiento extends BaseController
{
    protected $modeloUsuario;
    protected $modeloRegistro;
    protected $modeloCaja;
    protected $modeloCuenta;
    protected $modeloAsiento;
    protected $helpers = ['funciones'];

    public function __construct(){
        $this->modeloUsuario  = model('UsuarioModel');
        $this->modeloRegistro = model('RegistroModel');
        $this->modeloCaja     = model('CajaModel');
        $this->modeloCuenta   = model('CuentaModel');
        $this->modeloAsiento  = model('AsientoModel');
        $this->session;
    }


    public function index(){
        
    }

    public function nuevoVarios($id = ''){
        if( !session('idusuario') ){
            return redirect()->to('/');
        }

        if( session('idtipo_usuario') != 1 && session('idtipo_usuario') != 2 && session('idtipo_usuario') != 3 ) return redirect()->to('sistema');

        if( $id != '' ){
            if( $asiento = $this->modeloAsiento->obtenerAsiento($id, session('idiglesia')) ){
                
                $data['asiento_bd'] = $asiento;
                $data['deta_bd']    = $this->modeloAsiento->listarAsientoDetalle($id);
                $data['title']      = "Editar varios";
            }else{
                return redirect()->to('/');
            }
        }else{
            $data['title'] = "Nueva varios";
        }        
        
        $data['registrosLinkActive'] = 1;
        
        $data['proveedores'] = $this->modeloRegistro->listarProveedores();
        $data['cuentas']     = $this->modeloCuenta->listarCuentas();

        return view('sistema/asiento/nuevoVarios', $data);
    }

    public function procesarAsiento(){
        if( $this->request->isAJAX() ){
            if( !session('idusuario') ) exit();
            if( session('idtipo_usuario') != 1 && session('idtipo_usuario') != 2 && session('idtipo_usuario') != 3 ) exit();

           /*  echo "<pre>";
            print_r($_POST);
            echo "</pre>"; */
            // Obtener el array de líneas de asiento
            // CodeIgniter maneja automáticamente la estructura del array [lineas][ID][campo]
            $lineas_asiento = $this->request->getPost('lineas');
            $fecha          = trim($this->request->getPost('fecha'));
            $documento      = trim($this->request->getPost('documento'));
            $desc           = trim($this->request->getPost('desc'));
            $idasiento      = $this->request->getPost('idasiento');
            
            if (empty($lineas_asiento)) {
                echo '<script>
                    Swal.fire({
                        text: "El asiento esta vacío",
                        icon: "error"
                    });
                </script>';
                exit();
            }

            if( empty($fecha) || empty($documento) || empty($desc) ){
                echo '<script>
                    Swal.fire({
                        text: "La fecha, el documento y la descripcion o glosa son requeridos",
                        icon: "error"
                    });
                </script>';
                exit();
            }

            // --- 2. DOBLE VALIDACIÓN Y PROCESAMIENTO ---
            
            $total_debe = 0;
            $total_haber = 0;
            $asiento_listo_para_db = [];

            foreach ($lineas_asiento as $key => $linea) {
                
                // 2.1 Limpieza de datos
                $cuenta_id = filter_var($linea['cuenta_id'] ?? null, FILTER_SANITIZE_NUMBER_INT);
                $debe = filter_var($linea['debe'] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $haber = filter_var($linea['haber'] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                
                // 2.2 Ignorar líneas completamente vacías (ya filtrado por JS, pero por seguridad)
                if (empty($cuenta_id) && $debe == 0 && $haber == 0) {
                    continue;
                }

                // 2.3 Re-Validación estricta de cuenta y movimiento
                if (empty($cuenta_id) && ($debe > 0 || $haber > 0)) {
                    //return $this->response->setStatusCode(400)->setBody("Error: Línea con movimiento sin Cuenta seleccionada.");
                    echo '<script>
                        Swal.fire({
                            text: "Error: Línea con movimiento sin Cuenta seleccionada.",
                            icon: "error"
                        });
                    </script>';
                    exit();
                }

                // 2.4 Acumular totales
                $total_debe += (float)$debe;
                $total_haber += (float)$haber;
                
                // Guardar la línea limpia para la inserción
                $asiento_listo_para_db[] = [
                    'cuenta_id' => (int)$cuenta_id,
                    'debe'      => (float)$debe,
                    'haber'     => (float)$haber,
                ];
            }

            // --- 3. VALIDACIÓN DE PARTIDA DOBLE FINAL ---
            // Si no hay movimientos, no hay nada que enviar
            if ($total_debe == 0 || $total_haber == 0) {
                //return $this->response->setStatusCode(400)->setBody("Error: El asiento no contiene movimientos válidos para guardar.");
                echo '<script>Swal.fire({text: "Error: El asiento no contiene movimientos válidos para guardar.", icon: "error"});</script>';
                exit();
                
            }

            // Tolerancia de 0.01 (un centavo)
            if (abs($total_debe - $total_haber) > 0.01) {
                //return $this->response->setStatusCode(400)->setBody("Error Contable: Los totales no coinciden. Debe: " . number_format($total_debe, 2) . ", Haber: " . number_format($total_haber, 2));
                echo '<script>Swal.fire({text: "Error Contable: Los totales no coinciden. Debe: ' . number_format($total_debe, 2) . ', Haber: ' . number_format($total_haber, 2).'", icon: "error"});</script>';
                exit();
            }

            // --- 4. LÓGICA DE BASE DE DATOS ---
            
            $db = db_connect();
            $db->transStart();

            if( $idasiento != '' ){ //EDITAR
                // 1. Modificar encabezado del asiento...
                $this->modeloAsiento->modificarAsiento($fecha,$desc,$documento,$total_debe,$total_haber,$idasiento);
                //eliminar detalle asiento
                $this->modeloAsiento->eliminarDetalleAsiento($idasiento);

                $id_insertado = $idasiento;
            }else{ //INSERTAR
                // 1. Insertar encabezado del asiento...
                $id_insertado = $this->modeloAsiento->registrarAsiento($fecha,$desc,$documento,$total_debe,$total_haber,session('idiglesia'));
            }
            
            
            // 2. Recorrer $asiento_listo_para_db e insertar detalles...
            foreach( $asiento_listo_para_db as $as ){
                $this->modeloAsiento->insertarDetalleAsiento($id_insertado, $as['cuenta_id'], $as['debe'], $as['haber']);
            }
            
            if ($db->transComplete() === FALSE) {
                // Falló la transacción
                //return $this->response->setStatusCode(500)->setBody("Error en la transacción de base de datos.");
                echo '<script>Swal.fire({text: "ALGO SALIO MAL.", icon: "error"});</script>';
                exit();
            }
           

            // --- 5. Respuesta de Éxito ---
            //return $this->response->setStatusCode(200)->setBody("Asiento Contable procesado y guardado con éxito. Total: " . number_format($total_debe, 2));
            echo '<script>
                Swal.fire({
                    title: "Asiento Contable procesado y guardado con éxito. Total: ' . number_format($total_debe, 2).'",
                    text: "",
                    icon: "success",
                    showConfirmButton: false,
                    allowOutsideClick: false,
                });
                setTimeout(function(){location.href="registros#libroVarios"}, 1500);
            </script>';
        }
    }


    public function listarAsientosDT(){
        if( $this->request->isAJAX() ){
			//print_r($_POST);
            /* $status = $this->request->getVar('status');
            $tipo   = $this->request->getVar('tipo'); */

			$registros = $this->modeloAsiento->listarAsientosDT(session('idiglesia'));
			echo json_encode($registros, JSON_UNESCAPED_UNICODE);
        }
    }

    public function eliminarAsiento(){
        if( $this->request->isAJAX() ){
            if( !session('idusuario') ) exit();
            if( session('idtipo_usuario') != 1 && session('idtipo_usuario') != 2 && session('idtipo_usuario') != 3 ) exit();

            $idasiento = $this->request->getVar('id');
            if( $asiento = $this->modeloAsiento->obtenerAsiento($idasiento,session('idiglesia')) ){
                if( $this->modeloAsiento->eliminarAsiento($idasiento) ){
                    echo '<script>
                        Swal.fire({
                            title: "Asiento Eliminado",
                            text: "",
                            icon: "success",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
                        dataTableReload(4);
                    </script>';
                }
            }          

        }
    }



}