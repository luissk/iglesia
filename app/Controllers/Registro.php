<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

class Registro extends BaseController
{
    protected $modeloUsuario;
    protected $modeloRegistro;
    protected $modeloCaja;
    protected $modeloCuenta;
    protected $helpers = ['funciones'];

    public function __construct(){
        $this->modeloUsuario = model('UsuarioModel');
        $this->modeloRegistro = model('RegistroModel');
        $this->modeloCaja    = model('CajaModel');
        $this->modeloCuenta  = model('CuentaModel');
        $this->session;
    }


    public function index(){
        if( !session('idusuario') ){
            return redirect()->to('/');
        }

        if( session('idtipo_usuario') != 1 && session('idtipo_usuario') != 2 && session('idtipo_usuario') != 3 ) return redirect()->to('sistema');
        
        $data['title'] = "Registros del Sistema";

        $data['cajas'] = $this->modeloCaja->listarResponsablesDeCaja(session('idiglesia'));//PARA EL FILTRO DE CAJAS

        $data['registrosLinkActive'] = 1;       

        return view('sistema/registro/index', $data);
    }

    public function listarLCajaDT(){
        if( $this->request->isAJAX() ){
            $caja = $this->request->getVar('caja');
            $mes  = $this->request->getVar('mes');
            $anio = $this->request->getVar('anio');

			$registros = $this->modeloRegistro->listarRegistros(session('idiglesia'), $anio, $mes, $caja);
			echo json_encode($registros, JSON_UNESCAPED_UNICODE);
        }
    }

    public function formularioLibroCaja(){
        if( $this->request->isAJAX() ){
            if( !session('idusuario') ) exit();
            if( session('idtipo_usuario') != 1 && session('idtipo_usuario') != 2 && session('idtipo_usuario') != 3 ) exit();

            $idregistro = $this->request->getVar('id');
            if( $registro = $this->modeloRegistro->obtenerRegistro($idregistro) ){
                if( $registro['idiglesia'] == session('idiglesia') ){
                    $data['registro_bd'] = $registro;
                }
            }

            $data['cajas']   = $this->modeloCaja->listarResponsablesDeCaja(session('idiglesia'));
            $data['cuentas'] = $this->modeloCuenta->listarCuentas();

            return view('sistema/registro/frmLCaja', $data);

        }
    }

    public function registrarLCaja(){
        if( $this->request->isAJAX() ){
            if( !session('idusuario') ) exit();
            if( session('idtipo_usuario') != 1 && session('idtipo_usuario') != 2 && session('idtipo_usuario') != 3 ) exit();

            //print_r($_POST);exit();

            $idcajaresp = $this->request->getVar('caja');
            $mov        = $this->request->getVar('mov');
            $fecha      = trim($this->request->getVar('fecha'));
            $concepto   = trim($this->request->getVar('concepto'));
            $idcuenta   = $this->request->getVar('cuenta');
            $importe    = $this->request->getVar('importe');
            $idregistro = $this->request->getVar('idregistroe');//para editar
            $idcompra   = $this->request->getVar('idcompra');//para pagar la factura

            $validation = \Config\Services::validation();

            $data = [
                'caja'     => $idcajaresp,
                'mov'      => $mov,
                'fecha'    => $fecha,
                'concepto' => $concepto,
                'cuenta'   => $idcuenta,
                'importe'  => $importe,
            ];

            $rules = [
                'caja' => [
                    'label' => 'Caja', 
                    'rules' => 'required|integer',
                    'errors' => [
                        'required'   => '* La {field} es requerida.',
                        'integer'    => '* La {field} no es válida.',
                    ]
                ],
                'mov' => [
                    'label' => 'Movimiento', 
                    'rules' => 'required|integer',
                    'errors' => [
                        'required'   => '* El {field} es requerido.',
                        'integer'    => '* El {field} no es válido.',
                    ]
                ],
                'fecha' => [
                    'label' => 'Fecha', 
                    'rules' => 'required|valid_date',
                    'errors' => [
                        'required'   => '* La {field} es requerida.',
                        'valid_date' => '* La {field} no es válida.',
                    ]
                ],
                'concepto' => [
                    'label' => 'Concepto', 
                    'rules' => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ.\-\",\/ 0-9]+$/]|max_length[200]',
                    'errors' => [
                        'required'    => '* El {field} es requerido.',
                        'regex_match' => '* El {field} no es válido.',
                        'max_length'  => '* El {field} debe contener máximo 200 caracteres.'
                    ]
                ],
                'cuenta' => [
                    'label' => 'Cuenta', 
                    'rules' => 'required|integer',
                    'errors' => [
                        'required'   => '* La {field} es requerida.',
                        'integer'    => '* La {field} no es válida.',
                    ]
                ],
                'importe' => [
                    'label' => 'Importe', 
                    'rules' => 'required|decimal|max_length[10]',
                    'errors' => [
                        'required'   => '* El {field} es requerido.',
                        'decimal'    => '* El {field} sólo contiene números y punto decimal',
                        'max_length' => '* El {field} debe contener máximo 10 caracteres.'
                    ]
                ],

            ];

            $validation->setRules($rules);

            if (!$validation->run($data)) {
                return $this->response->setJson(['errors' => $validation->getErrors()]);
            }

            $registro_bd = $this->modeloRegistro->obtenerRegistro($idregistro);

            //OBTENER TAMBIEN EL IDCAJA PARA EL REGISTRO
            $cajabd   = $this->modeloCaja->obtenerResponsableDeCaja($idcajaresp);
            $idcajabd = $cajabd['idcaja'];

            if( $registro_bd ){
                //VERIFICAR SI EL REGISTRO TIENE FACTURA PAGADA Y SI LO HA CAMBIADO A OTRA
                $idcompra_bd = $registro_bd['idcompra'];
                if( $idcompra_bd > 0 ){//SI TIENE PAGA UNA COMPRA
                    if( $idcompra_bd != $idcompra ){//VERIFICAR SI SON DIFERENTES
                        $this->modeloRegistro->cambiarEstadoCompra($idcompra_bd, 0); //SI SON DIFERENTES ACTUALIZAR EL ESTADO DE LA COMPRA ANTERIOR(BD)
                    }
                }

                if( $compra_bd = $this->modeloRegistro->obtenerCompra_PorID($idcompra) ){
                    //PAGAR FACTURA
                    $this->modeloRegistro->cambiarEstadoCompra($idcompra, 1);
                }

                if( $this->modeloRegistro->modificarRegistro($fecha,$importe,$concepto,session('idusuario'),$idcuenta,$idcajaresp,$mov,$idcajabd,$idcompra,$idregistro) ){
                    echo '<script>
                        Swal.fire({
                            title: "Registro Modificado",
                            text: "",
                            icon: "success",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                            allowEnterKey:false,
                        });
                        dataTableReload(1);
                    </script>';
                }
                
            }else{                

                if( $this->modeloRegistro->insertarRegistro($fecha,$importe,$concepto,session('idusuario'),$idcuenta,$idcajaresp,$mov,$idcajabd,session('idiglesia'),$idcompra) ){
                    if( $compra_bd = $this->modeloRegistro->obtenerCompra_PorID($idcompra) ){
                        //PAGAR FACTURA
                        $this->modeloRegistro->cambiarEstadoCompra($idcompra, 1);
                    }

                    echo '<script>
                        Swal.fire({
                            title: "Registro Guardado",
                            text: "",
                            icon: "success",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                            allowEnterKey:false,
                        });
                        $("#importe").val("");
                        dataTableReload(1);
                    </script>';
                }

            }

        }
    }

    public function eliminarLCaja(){
        if( $this->request->isAJAX() ){
            if( !session('idusuario') ) exit();
            if( session('idtipo_usuario') != 1 && session('idtipo_usuario') != 2 && session('idtipo_usuario') != 3 ) exit();

            $idregistro = $this->request->getVar('id');
            if( $registro = $this->modeloRegistro->obtenerRegistro($idregistro) ){

                //VERIFICAR SI EL REGISTRO TIENE FACTURA PAGADA
                $idcompra_bd = $registro['idcompra'];
                if( $idcompra_bd > 0 ){//SI TIENE PAGA UNA COMPRA
                    $this->modeloRegistro->cambiarEstadoCompra($idcompra_bd, 0);
                }

                if( $this->modeloRegistro->eliminarRegistro($idregistro) ){
                    echo '<script>
                        Swal.fire({
                            title: "Registro Eliminado",
                            text: "",
                            icon: "success",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
                        dataTableReload(1);
                    </script>';
                }
            }

            

        }
    }

    public function reportesRegistros(){
        if( !session('idusuario') ){
            return redirect()->to('/');
        }

        if( session('idtipo_usuario') != 1 &&  session('idtipo_usuario') != 2 && session('idtipo_usuario') != 3 ) return redirect()->to('sistema');
        
        $data['title']           = "Reportes de Registros";
        $data['registrosRepLinkActive'] = 1;
        
        $data['cajas'] = $this->modeloCaja->listarResponsablesDeCaja(session('idiglesia'));

        return view('sistema/registro/reporteReg', $data);
    }

    public function generaReporteLCaja(){
        if( $this->request->isAJAX() ){
            if( !session('idusuario') ) exit();
            if( session('idtipo_usuario') != 1 && session('idtipo_usuario') != 2 && session('idtipo_usuario') != 3 ) exit();

            $mes     = $this->request->getVar('mesCa');
            $anio    = trim($this->request->getVar('anioCa'));
            $caja    = $this->request->getVar('cajaCa');
            $tipoRep = $this->request->getVar('tipoRepCa');

            if( $mes != '' & $anio != '' && $tipoRep != '' ){
                if( $tipoRep == 'excel' ){
                    $this->excelLCaja($mes, $anio, $caja);
                }else if( $tipoRep == 'pdf' ){
                    //$this->pdfLCaja($mes, $anio);
                    $registros = $this->modeloRegistro->listarParaReporte(session('idiglesia'),$mes,$anio,[1,2],$caja);
                    if( !$registros ) exit();
                    echo "<script>window.open('".base_url('pdfLCaja/'.$mes.'/'.$anio.'/'.$caja.'?v='.time().'')."','_blank' );$('#msj').html('')</script>";
                }
            }

        }
    }

    private function excelLCaja($mes, $anio, $caja){
        $registros = $this->modeloRegistro->listarParaReporte(session('idiglesia'),$mes,$anio,[1,2],$caja);

        if( !$registros ) exit();
        
        $saldos = $this->obtenerSaldosMensualesLCaja(session('idiglesia'),$anio,$mes,$caja);
        //print_r($saldos);exit();

        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('B1', 'SALDO ANT');
        $sheet->setCellValue('C1', $saldos['saldo_inicial']);

        $sheet->setCellValue('A3', 'NRO');
        $sheet->setCellValue('B3', 'FECHA');
        $sheet->setCellValue('C3', 'IMPORTE');
        $sheet->setCellValue('D3', 'MOV');
        $sheet->setCellValue('E3', 'DH');
        $sheet->setCellValue('F3', 'COD');
        $sheet->setCellValue('G3', 'CUENTA');
        $sheet->setCellValue('H3', 'CONCEPTO');
        $sheet->setCellValue('I3', 'CAJA');
        
        $cont = 0;
        $rows = 4;
        foreach($registros as $r){
            $cont++;
            $fecha    = $r['re_fecha'];
            $importe  = $r['re_importe'];
            $mov      = $r['tipo_mov'];
            $dh       = $r['cu_dh'];
            $cod      = $r['cu_codigo'];
            $cuenta   = $r['cu_cuenta'];
            $concepto = $r['re_desc'];
            $caja     = $r['ca_caja'];

            $sheet->setCellValue('A'.$rows, $cont);
            $sheet->setCellValue('B'.$rows, $fecha);
            //$sheet->getCell('B'.$rows, $codigo)->getStyle()->getNumberFormat()->setFormatCode('#');
            $sheet->setCellValue('C'.$rows, $importe);
            $sheet->setCellValue('D'.$rows, $mov);
            $sheet->setCellValue('E'.$rows, $dh);
            $sheet->setCellValue('F'.$rows, $cod);
            $sheet->setCellValue('G'.$rows, $cuenta);
            $sheet->setCellValue('H'.$rows, $concepto);
            $sheet->setCellValue('I'.$rows, $caja);
            $rows++;
        }
        foreach (range('A','I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $file = 'reporte_lcaja.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$file.'"');
        header('Cache-Control: max-age=0');
        

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('public/'.$file);
        $writer->save('php://output');

        echo "<script>window.open('".base_url('public/'.$file)."','_blank' );$('#msj').html('')</script>";

        //unlink('public/'.$file);
        exit();
        
    }

    /* private function excelLCaja_($mes, $anio){
        $registros = $this->modeloRegistro->listarParaReporte(session('idiglesia'),$mes,$anio);

        if( !$registros ) exit();
        //print_r($registros); exit();

        $tabla = '
        <table border="1">
            <tr>
                <th>NRO</th>
                <th>FECHA</th>
                <th>IMPORTE</th>
                <th>MOV</th>
                <th>DH</th>
                <th>COD</th>
                <th>CUENTA</th>
                <th>CONCEPTO</th>
            </tr>
        ';

        $cont = 0;
        foreach($registros as $r){
            $cont++;
            $fecha    = $r['re_fecha'];
            $importe  = $r['re_importe'];
            $mov      = $r['tipo_mov'];
            $dh       = $r['cu_dh'];
            $cod      = $r['cu_codigo'];
            $cuenta   = $r['cu_cuenta'];
            $concepto = $r['re_desc'];

            $tabla .= "
            <tr>
                <td>$cont</td>
                <td>$fecha</td>
                <td>$importe</td>
                <td>$mov</td>
                <td>$dh</td>
                <td>$cod</td>
                <td>$cuenta</td>
                <td>$concepto</td>
            </tr>
            ";
        }
        $tabla .= "</table>";
        
        $filename = 'reporte_lcaja_'.date('d-m-Y h:i:s').'.xls';
        header ( "Content-Type: application/vnd.ms-excel" ); 
        header ( "Content-Disposition: attachment; filename=$filename" );
        
        // Representar datos de Excel 
        //echo  $tabla; 

        exit();
    } */

    public function pdfLCaja($mes, $anio, $caja = ''){
        $options = new \Dompdf\Options();
        $options->setIsRemoteEnabled(true);
        $dompdf = new \Dompdf\Dompdf($options);

        $registros_i = $this->modeloRegistro->listarParaReporte(session('idiglesia'),$mes,$anio,[1],$caja);
        $registros_e = $this->modeloRegistro->listarParaReporte(session('idiglesia'),$mes,$anio,[2],$caja);
        //if( !$registros_i ) exit();

        $saldos = $this->obtenerSaldosMensualesLCaja(session('idiglesia'),$anio,$mes,$caja);
        
        $data['registros_i'] = $registros_i;
        $data['registros_e'] = $registros_e;
        $data['saldos']      = $saldos;
        $data['anio']        = $anio;
        $data['mes']         = $mes;

        $dompdf->loadHtml(view('sistema/registro/pdfLCaja', $data));

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $dompdf->stream("reporte_lcaja_".time().".pdf", array("Attachment" => false));
        exit;
    }

    private function obtenerSaldosMensualesLCaja($idiglesia, $anio, $mes, $caja = ''){
        $primer_dia_mes = sprintf('%04d-%02d-01', $anio, $mes);
        $primer_dia_siguiente_mes = date('Y-m-01', strtotime('+1 month', strtotime($primer_dia_mes)));

        $saldo_inicial = $this->modeloRegistro->obtenerSaldos($idiglesia, $primer_dia_mes, $caja)['saldo'] ?? 0;
        $saldo_final   = $this->modeloRegistro->obtenerSaldos($idiglesia, $primer_dia_siguiente_mes, $caja)['saldo'] ?? 0;

        return [
            'saldo_inicial' => $saldo_inicial,
            'saldo_final' => $saldo_final,
        ];
    }


    public function nuevaCompra($id = ''){
        if( !session('idusuario') ){
            return redirect()->to('/');
        }

        if( session('idtipo_usuario') != 1 && session('idtipo_usuario') != 2 && session('idtipo_usuario') != 3 ) return redirect()->to('sistema');

        if( $id != '' ){
            if( $compra = $this->modeloRegistro->obtenerCompra($id, session('idiglesia')) ){
                
                $data['compra_bd'] = $compra;
                /* $data['deta_bd']   = $this->modeloRegistro->listarDetalleCompra($id); */
                $data['title']     = "Editar compra";
            }else{
                return redirect()->to('/');
            }
        }else{
            $data['title'] = "Nueva compra";
        }        
        
        $data['registrosLinkActive'] = 1;
        
        $data['proveedores'] = $this->modeloRegistro->listarProveedores();
        $data['cuentas']     = $this->modeloCuenta->listarCuentas(1);

        return view('sistema/registro/nuevaCompra', $data);
    }

    public function listaProveedorDT(){
        if( $this->request->isAJAX() ){
			//print_r($_POST);
            $tipo = $this->request->getVar('tipo');

			$registros = $this->modeloRegistro->listarProveedores($tipo);
			echo json_encode($registros, JSON_UNESCAPED_UNICODE);
        }
    }

    public function registrarProveedor(){
         if( $this->request->isAJAX() ){
            if( !session('idusuario') ) exit();
            if( session('idtipo_usuario') != 1 && session('idtipo_usuario') != 2 && session('idtipo_usuario') != 3 ) exit();

            //print_r($_POST);exit();

            $ruc         = trim($this->request->getVar('npruc'));
            $razon       = trim($this->request->getVar('nprazon'));
            $tipo        = $this->request->getVar('tipo');
            $idproveedor = $this->request->getVar('idproveedor_e');//para editar

            $validation = \Config\Services::validation();

            //PARA MENSAJITOS
            $msj_doc = $tipo == 1 ? "Ruc" : "Nro Doc";
            $msj_per = $tipo == 1 ? "Proveedor" : "Persona";

            $data = [
                'npruc'   => $ruc,
                'nprazon' => $razon,
            ];

            $rules = [
                'npruc' => [
                    'label' => $msj_doc, 
                    'rules' => 'required|regex_match[/^[0-9]+$/]|max_length[11]',
                    'errors' => [
                        'required'    => '* {field} es requerido.',
                        'regex_match' => '* {field} no es válido.',
                        'max_length'  => '* {field} debe contener máximo 11 caracteres.'
                    ]
                ],
                'nprazon' => [
                    'label' => $msj_per, 
                    'rules' => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ.\-\",\/ 0-9]+$/]|max_length[100]',
                    'errors' => [
                        'required'    => '* {field} es requerido.',
                        'regex_match' => '* {field} no es válido.',
                        'max_length'  => '* {field} debe contener máximo 100 caracteres.'
                    ]
                ],
            ];

            $validation->setRules($rules);

            if (!$validation->run($data)) {
                return $this->response->setJson(['errors' => $validation->getErrors()]);
            }

            $proveedor_bd = $this->modeloRegistro->obtenerProveedor($idproveedor);

            if( $proveedor_bd ){
                $ruc_bd = $proveedor_bd['pr_ruc'];
                if( $ruc != $ruc_bd ){
                    if( $this->modeloRegistro->verificarRuc($ruc) ){
                        echo '<script>
                            Swal.fire({
                                title: "El '.$msj_doc.' ya existe",
                                icon: "error"
                            });
                        </script>';
                        exit();
                    }
                }

                if( $this->modeloRegistro->modificarProveedor($ruc, $razon, $idproveedor) ){
                    echo '<script>
                        Swal.fire({
                            title: "'.$msj_per.' Modificado",
                            text: "",
                            icon: "success",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
                        dtProvReload();
                        limpiarCamposProv();
                        cargarSelectProv(2, '.$ruc.', "'.$razon.'", '.$idproveedor.');
                    </script>';
                }
                
            }else{
                if( $this->modeloRegistro->verificarRuc($ruc) ){
                    echo '<script>
                        Swal.fire({
                            title: "El '.$msj_doc.' ya existe",
                            icon: "error"
                        });
                    </script>';
                    exit();
                }

                if( $id = $this->modeloRegistro->registrarProveedor($ruc, $razon, $tipo) ){
                    echo '<script>
                        Swal.fire({
                            title: "'.$msj_per.' Guardado",
                            text: "",
                            icon: "success",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
                        dtProvReload();
                        limpiarCamposProv();
                        cargarSelectProv(1, '.$ruc.', "'.$razon.'", '.$id.');
                    </script>';
                }

            }

        }
    }

    public function eliminarProveedor(){
        if( $this->request->isAJAX() ){
            if( !session('idusuario') ) exit();
            if( session('idtipo_usuario') != 1 && session('idtipo_usuario') != 2 && session('idtipo_usuario') != 3 ) exit();

            $idproveedor = $this->request->getVar('id');

            $eliminar = FALSE;
            $mensaje = "";

            $tablas = ['compra'];
            foreach( $tablas as $t ){
                $total = $this->modeloRegistro->verificarProvTieneRegEnTablas($idproveedor,$t)['total'];
                if( $total > 0 ){
                    $mensaje .= "<div class='text-start'>El proveedor tiene $total registros en la tabla '$t'.</div>";
                    $eliminar = TRUE;
                }
            }

            if( $eliminar ){
                echo '<script>
                    Swal.fire({
                        title: "El proveedor no puede ser eliminado",
                        html: "'.$mensaje.'",
                        icon: "warning",
                    });
                </script>';
                exit();
            }

            if( $this->modeloRegistro->eliminarProveedor($idproveedor) ){
                echo '<script>
                    Swal.fire({
                        title: "Proveedor Eliminado",
                        text: "",
                        icon: "success",
                        showConfirmButton: true,
                        allowOutsideClick: false,
                    });
                    dtProvReload();
                    limpiarCamposProv();
                    cargarSelectProv(3, "", "", '.$idproveedor.');
                </script>';
            }            

        }
    }

    public function registrarCompra(){
        if( $this->request->isAJAX() ){
            if( !session('idusuario') ) exit();
            if( session('idtipo_usuario') != 1 && session('idtipo_usuario') != 2 && session('idtipo_usuario') != 3 ) exit();

            //print_r($_POST);exit();

            /* $items     = json_decode($this->request->getVar('items'), true);
            $count_items = count($items);
            if( $count_items == 0 ){
                exit();
            } */

            $fecha     = trim($this->request->getVar('fecha'));
            $factura   = trim($this->request->getVar('factura'));
            $proveedor = $this->request->getVar('proveedor');
            $subt      = $this->request->getVar('subt');
            $igv       = $this->request->getVar('igv');
            $total     = $this->request->getVar('total');
            $cuenta    = $this->request->getVar('cuenta');
            $glosa     = $this->request->getVar('glosa');
            $idcompra  = $this->request->getVar('idcompra_e');//para editar
            $type      = $this->request->getVar('type');

            if( $subt == '' || $igv == '' || $total == '' || $cuenta == '' || $glosa == '' || $fecha == '' || $factura == '' || $proveedor == '' ) exit();

            //print_r($items);
            //PARA EL FLAG SI ES VENTA O COMPRA
            if( $type == 1 ){//Compra
                $cuentafact = 4;
                $msj_tbl = "Compra";
                $url = "registros#libroCompras";
            }else if( $type == 2 ){
                $cuentafact = 35;
                $msj_tbl = "Venta";
                $url = "registros#libroVentas";
            }
            
            $cuentaigv  = 31;
            if( $compra_bd = $this->modeloRegistro->obtenerCompra($idcompra,session('idiglesia'),$type) ){
                if( $this->modeloRegistro->modificarCompra($fecha, $factura, $proveedor, $subt, $igv, $total, $cuentafact, $cuentaigv, $cuenta, $glosa, $idcompra)){
                    echo '<script>
                        Swal.fire({
                            title: "'.$msj_tbl.' Actualizada",
                            text: "",
                            icon: "success",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
                    </script>';
                }
            }else{
                if( $idcompra_i = $this->modeloRegistro->insertarCompra($fecha, $factura, $proveedor, session('idusuario'), session('idiglesia'), $subt, $igv, $total, $cuentafact, $cuentaigv, $cuenta, $glosa, $type) ){
                    echo '<script>
                        Swal.fire({
                            title: "'.$msj_tbl.' Registrada",
                            text: "",
                            icon: "success",
                            showConfirmButton: false,
                            allowOutsideClick: false,
                        });
                        limpiarCabecera();
                        setTimeout(function(){location.href="'.base_url($url).'"}, 1500);
                    </script>';
                }
            }
        }
    }

    public function eliminarLCompra(){
        if( $this->request->isAJAX() ){
            if( !session('idusuario') ) exit();
            if( session('idtipo_usuario') != 1 && session('idtipo_usuario') != 2 && session('idtipo_usuario') != 3 ) exit();

            $idcompra = $this->request->getVar('id');
            $type     = $this->request->getVar('type');

            if( !$this->modeloRegistro->obtenerCompra($idcompra,session('idiglesia'),$type) ) exit();

            //flag mensajes
            $msj_tbl    = $type == 1 ? 'compra': 'venta';
            $nro_reload = $type == 1 ? 2       : 3;

            $eliminar = FALSE;
            $mensaje = "";

            $tablas = ['registro'];
            foreach( $tablas as $t ){
                $total = $this->modeloRegistro->verificarCompraTieneRegEnTablas($idcompra,$t)['total'];
                if( $total > 0 ){
                    $mensaje .= "<div class='text-start'>La $msj_tbl ha sido pagada, primero debes eliminar el registro de pago</div>";
                    $eliminar = TRUE;
                }
            }

            if( $eliminar ){
                echo '<script>
                    Swal.fire({
                        title: "La '.$msj_tbl.' no puede ser eliminada",
                        html: "'.$mensaje.'",
                        icon: "warning",
                    });
                </script>';
                exit();
            }
            if( $this->modeloRegistro->eliminarCompra($idcompra) ){
            echo '<script>
                    Swal.fire({
                        title: "'.$msj_tbl.' Eliminada",
                        text: "",
                        icon: "success",
                        showConfirmButton: true,
                        allowOutsideClick: false,
                    });
                    dataTableReload('.$nro_reload.');
                </script>';
            }
      
        }
    }

    public function listarLCompraDT(){
        if( $this->request->isAJAX() ){
			//print_r($_POST);
            $status = $this->request->getVar('status');
            $tipo   = $this->request->getVar('tipo');

			$registros = $this->modeloRegistro->listarCompras(session('idiglesia'), $tipo, $status);
			echo json_encode($registros, JSON_UNESCAPED_UNICODE);
        }
    }

    public function generaReporteLCompra(){
        if( $this->request->isAJAX() ){
            if( !session('idusuario') ) exit();
            if( session('idtipo_usuario') != 1 && session('idtipo_usuario') != 2 && session('idtipo_usuario') != 3 ) exit();

            $mes     = $this->request->getVar('mesCo');
            $anio    = trim($this->request->getVar('anioCo'));
            $tipoRep = $this->request->getVar('tipoRepCo');

            if( $mes != '' & $anio != '' && $tipoRep != '' ){
                if( $tipoRep == 'excel' ){
                    $this->excelLCompra($mes, $anio);
                }else if( $tipoRep == 'pdf' ){
                    $registros = $this->modeloRegistro->listarParaReporteLCompra(session('idiglesia'),$mes,$anio);
                    if( !$registros ) exit();
                    echo "<script>window.open('".base_url('pdfLCompra/'.$mes.'/'.$anio.'?v='.time().'')."','_blank' );$('#msj').html('')</script>";
                }
            }

        }
    }

    private function excelLCompra($mes, $anio){
        $registros = $this->modeloRegistro->listarParaReporteLCompra(session('idiglesia'),$mes,$anio);

        if( !$registros ) exit();
        
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A2', '#');
        $sheet->setCellValue('B2', 'FECHA');
        $sheet->setCellValue('C2', 'RUC');
        $sheet->setCellValue('D2', 'PROVEEDOR');
        $sheet->setCellValue('E2', 'GLOSA');
        $sheet->setCellValue('F2', 'V. VENTA');
        $sheet->setCellValue('G2', 'IGV');
        $sheet->setCellValue('H2', 'TOTAL');
        
        $cont = 0;
        $rows = 3;
        foreach($registros as $r){
            $cont++;
            $fecha = $r['co_fecha'];
            $ruc   = $r['pr_ruc'];
            $razon = $r['pr_razon'];
            $glosa = $r['co_glosa'];
            $subt  = $r['co_subt'];
            $igv   = $r['co_igv'];
            $total = $r['co_total'];

            $sheet->setCellValue('A'.$rows, $cont);
            $sheet->setCellValue('B'.$rows, $fecha);
            $sheet->setCellValue('C'.$rows, $ruc);
            //$sheet->getCell('B'.$rows, $codigo)->getStyle()->getNumberFormat()->setFormatCode('#');
            $sheet->setCellValue('D'.$rows, $razon);
            $sheet->setCellValue('E'.$rows, $glosa);
            $sheet->setCellValue('F'.$rows, $subt);
            $sheet->setCellValue('G'.$rows, $igv);
            $sheet->setCellValue('H'.$rows, $total);
            $rows++;
        }
        foreach (range('A','I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $file = 'reporte_lcompra.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$file.'"');
        header('Cache-Control: max-age=0');
        

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('public/'.$file);
        $writer->save('php://output');

        echo "<script>window.open('".base_url('public/'.$file)."','_blank' );$('#msj').html('')</script>";

        //unlink('public/'.$file);
        exit();
    }

    public function pdfLCompra($mes, $anio){
        $options = new \Dompdf\Options();
        $options->setIsRemoteEnabled(true);
        $dompdf = new \Dompdf\Dompdf($options);

        $registros = $this->modeloRegistro->listarParaReporteLCompra(session('idiglesia'),$mes,$anio);
        
        $data['registros'] = $registros;
        $data['anio']      = $anio;
        $data['mes']       = $mes;

        $dompdf->loadHtml(view('sistema/registro/pdfLCompra', $data));

        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();

        $dompdf->stream("reporte_lcompra_".time().".pdf", array("Attachment" => false));
        exit;
    }

    public function generaReporteDiario(){
        if( $this->request->isAJAX() ){
            if( !session('idusuario') ) exit();
            if( session('idtipo_usuario') != 1 && session('idtipo_usuario') != 2 && session('idtipo_usuario') != 3 ) exit();

            $mes     = $this->request->getVar('mesDi');
            $anio    = trim($this->request->getVar('anioDi'));
            //$tipoRep = $this->request->getVar('tipoRepDi');

            if( $mes != '' && $anio != '' ){
                $registros = $this->modeloRegistro->listarParaReporteDiario(session('idiglesia'),$mes,$anio);
                if( !$registros ) exit();
                echo "<script>window.open('".base_url('pdfDiario/'.$mes.'/'.$anio.'?v='.time().'')."','_blank' );$('#msj').html('')</script>";
            }

        }
    }

    public function pdfDiario($mes, $anio){
        $options = new \Dompdf\Options();
        $options->setIsRemoteEnabled(true);
        $dompdf = new \Dompdf\Dompdf($options);

        $registros = $this->modeloRegistro->listarParaReporteDiario(session('idiglesia'),$mes,$anio);
        
        $data['registros'] = $registros;
        $data['anio']      = $anio;
        $data['mes']       = $mes;

        $dompdf->loadHtml(view('sistema/registro/pdfDiario', $data));

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $dompdf->stream("reporte_diario_".time().".pdf", array("Attachment" => false));
        exit;
    }

    public function generaReportePorCuenta(){
        if( $this->request->isAJAX() ){
            if( !session('idusuario') ) exit();
            if( session('idtipo_usuario') != 1 && session('idtipo_usuario') != 2 && session('idtipo_usuario') != 3 ) exit();

            $mes    = $this->request->getVar('mesDi');
            $anio   = trim($this->request->getVar('anioDi'));
            $cuenta = trim($this->request->getVar('cuentaLD'));

            if( $mes != '' && $anio != '' && $cuenta != ''  ){
                $data['movimientos'] = $this->modeloRegistro->ReportePorCodCuenta(session('idiglesia'), $anio, $mes, $cuenta);
                return view('sistema/registro/porcuenta', $data);
            }else{
                echo "FALTAN DATOS!";
            }

        }
    }

    public function nuevaVenta($id = ''){
        if( !session('idusuario') ){
            return redirect()->to('/');
        }

        if( session('idtipo_usuario') != 1 && session('idtipo_usuario') != 2 && session('idtipo_usuario') != 3 ) return redirect()->to('sistema');

        if( $id != '' ){
            if( $compra = $this->modeloRegistro->obtenerCompra($id, session('idiglesia'), 2) ){//VENTA
                
                $data['compra_bd'] = $compra;
                $data['title']     = "Editar venta";
            }else{
                return redirect()->to('/');
            }
        }else{
            $data['title'] = "Nueva venta";
        }        
        
        $data['registrosLinkActive'] = 1;
        
        $data['proveedores'] = $this->modeloRegistro->listarProveedores(2);
        $data['cuentas']     = $this->modeloCuenta->listarCuentas(2);

        return view('sistema/registro/nuevaVenta', $data);
    }


}