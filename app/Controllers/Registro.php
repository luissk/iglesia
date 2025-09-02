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

        if( session('idtipo_usuario') != 2 && session('idtipo_usuario') != 3 ) return redirect()->to('sistema');
        
        $data['title']           = "Registros del Sistema";
        $data['registrosLinkActive'] = 1;       

        return view('sistema/registro/index', $data);
    }

    public function listarLCajaDT(){
        if( $this->request->isAJAX() ){
			//print_r($_POST);

			$registros = $this->modeloRegistro->listarRegistros(session('idiglesia'));
			echo json_encode($registros, JSON_UNESCAPED_UNICODE);
        }
    }

    public function formularioLibroCaja(){
        if( $this->request->isAJAX() ){
            if( !session('idusuario') ) exit();
            if( session('idtipo_usuario') != 2 && session('idtipo_usuario') != 3 ) exit();

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
            if( session('idtipo_usuario') != 2 && session('idtipo_usuario') != 3 ) exit();

            //print_r($_POST);exit();

            $idcajaresp = $this->request->getVar('caja');
            $mov        = $this->request->getVar('mov');
            $fecha      = trim($this->request->getVar('fecha'));
            $concepto   = trim($this->request->getVar('concepto'));
            $idcuenta   = $this->request->getVar('cuenta');
            $importe    = $this->request->getVar('importe');
            $idregistro = $this->request->getVar('idregistroe');//para editar

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

            if( $registro_bd ){

                if( $this->modeloRegistro->modificarRegistro($fecha,$importe,$concepto,session('idusuario'),$idcuenta,$idcajaresp,$mov,$idregistro) ){
                    echo '<script>
                        Swal.fire({
                            title: "Registro Modificado",
                            text: "",
                            icon: "success",
                            showConfirmButton: true,
                            allowOutsideClick: false,
                        });
                        dataTableReload(1);
                    </script>';
                }
                
            }else{

                if( $this->modeloRegistro->insertarRegistro($fecha,$importe,$concepto,session('idusuario'),$idcuenta,$idcajaresp,$mov,session('idiglesia')) ){
                    echo '<script>
                        Swal.fire({
                            title: "Registro Guardado",
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

    public function eliminarLCaja(){
        if( $this->request->isAJAX() ){
            if( !session('idusuario') ) exit();
            if( session('idtipo_usuario') != 2 && session('idtipo_usuario') != 3 ) exit();

            $idregistro = $this->request->getVar('id');
            if( $registro = $this->modeloRegistro->obtenerRegistro($idregistro) ){
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

        if( session('idtipo_usuario') != 2 && session('idtipo_usuario') != 3 ) return redirect()->to('sistema');
        
        $data['title']           = "Reportes de Registros";
        $data['registrosRepLinkActive'] = 1;       

        return view('sistema/registro/reporteReg', $data);
    }

    public function generaReporteLCaja(){
        if( $this->request->isAJAX() ){
            if( !session('idusuario') ) exit();
            if( session('idtipo_usuario') != 2 && session('idtipo_usuario') != 3 ) exit();

            $mes     = $this->request->getVar('mesCa');
            $anio    = trim($this->request->getVar('anioCa'));
            $tipoRep = $this->request->getVar('tipoRepCa');

            if( $mes != '' & $anio != '' && $tipoRep != '' ){
                if( $tipoRep == 'excel' ){
                    $this->excelLCaja($mes, $anio);
                }else if( $tipoRep == 'pdf' ){
                    //$this->pdfLCaja($mes, $anio);
                    $registros = $this->modeloRegistro->listarParaReporte(session('idiglesia'),$mes,$anio);
                    if( !$registros ) exit();
                    echo "<script>window.open('".base_url('pdfLCaja/'.$mes.'/'.$anio.'')."','_blank' );$('#msj').html('')</script>";
                }
            }

        }
    }

    private function excelLCaja($mes, $anio){
        $registros = $this->modeloRegistro->listarParaReporte(session('idiglesia'),$mes,$anio);

        if( !$registros ) exit();
        
        $saldos = $this->obtenerSaldosMensualesLCaja(session('idiglesia'),$anio,$mes);
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

    public function pdfLCaja($mes, $anio){
        $options = new \Dompdf\Options();
        $options->setIsRemoteEnabled(true);
        $dompdf = new \Dompdf\Dompdf($options);

        $registros_i = $this->modeloRegistro->listarParaReporte(session('idiglesia'),$mes,$anio,[1]);
        $registros_e = $this->modeloRegistro->listarParaReporte(session('idiglesia'),$mes,$anio,[2]);
        //if( !$registros_i ) exit();

        $saldos = $this->obtenerSaldosMensualesLCaja(session('idiglesia'),$anio,$mes);
        
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

    private function obtenerSaldosMensualesLCaja($idiglesia, $anio, $mes){
        $primer_dia_mes = sprintf('%04d-%02d-01', $anio, $mes);
        $primer_dia_siguiente_mes = date('Y-m-01', strtotime('+1 month', strtotime($primer_dia_mes)));

        $saldo_inicial = $this->modeloRegistro->obtenerSaldos($idiglesia, $primer_dia_mes)['saldo'] ?? 0;
        $saldo_final   = $this->modeloRegistro->obtenerSaldos($idiglesia, $primer_dia_siguiente_mes)['saldo'] ?? 0;

        return [
            'saldo_inicial' => $saldo_inicial,
            'saldo_final' => $saldo_final,
        ];
    }

}