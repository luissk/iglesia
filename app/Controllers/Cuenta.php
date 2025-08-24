<?php

namespace App\Controllers;

class Cuenta extends BaseController
{
    protected $modeloUsuario;
    protected $modeloIglesia;
    protected $modeloCaja;
    protected $modeloCuenta;
    protected $helpers = ['funciones'];

    public function __construct(){
        $this->modeloUsuario = model('UsuarioModel');
        $this->modeloIglesia = model('IglesiaModel');
        $this->modeloCaja    = model('CajaModel');
        $this->modeloCuenta  = model('CuentaModel');
        $this->session;
    }

    public function index(){
        if( !session('idusuario') ){
            return redirect()->to('sistema');
        }

        if( session('idtipo_usuario') != 1 ) return redirect()->to('sistema');

        $data['title']           = 'Cuentas del Sistema';
        $data['cuentasLinkActive'] = 1;


        $data['cuentas'] = $this->modeloCuenta->listarCuentas();
        return view('sistema/cuenta/index', $data);
    }

    public function registrarCuenta(){
        if( $this->request->isAJAX() ){
            if( !session('idusuario') ) exit();
            if( session('idtipo_usuario') != 1 ) exit();

            //print_r($_POST);exit();

            $dh      = $this->request->getVar('dh');
            $codigo  = trim($this->request->getVar('codigo'));
            $cuenta  = trim($this->request->getVar('cuenta'));
            $observa = trim($this->request->getVar('observa'));
            $idcuenta = $this->request->getVar('idcuentae');//para editar

            $validation = \Config\Services::validation();

            $data = [
                'dh'      => $dh,
                'codigo'  => $codigo,
                'cuenta'  => $cuenta,
                'observa' => $observa,
            ];

            $rules = [
                'dh' => [
                    'label' => 'Debe / Haber', 
                    'rules' => 'required|regex_match[/^[1-2]+$/]|max_length[1]',
                    'errors' => [
                        'required'    => '* El {field} es requerido.',
                        'regex_match' => '* El {field} no es válido.',
                        'max_length'  => '* El {field} debe contener máximo 1 caracteres.'
                    ]
                ],
                'codigo' => [
                    'label' => 'Código', 
                    'rules' => 'required|regex_match[/^[0-9]+$/]|max_length[3]',
                    'errors' => [
                        'required'    => '* El {field} es requerido.',
                        'regex_match' => '* El {field} no es válido.',
                        'max_length'  => '* El {field} debe contener máximo 3 caracteres.'
                    ]
                ],
                'cuenta' => [
                    'label' => 'Cuenta', 
                    'rules' => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ.\-\",\/ 0-9]+$/]|max_length[100]',
                    'errors' => [
                        'required'    => '* La {field} es requerida.',
                        'regex_match' => '* La {field} no es válida.',
                        'max_length'  => '* La {field} debe contener máximo 100 caracteres.'
                    ]
                ],
                'observa' => [
                    'label' => 'Observación', 
                    'rules' => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ.\-\",\/ 0-9]+$/]|max_length[100]',
                    'errors' => [
                        'required'    => '* La {field} es requerida.',
                        'regex_match' => '* La {field} no es válida.',
                        'max_length'  => '* La {field} debe contener máximo 100 caracteres.'
                    ]
                ]
            ];

            $validation->setRules($rules);

            if (!$validation->run($data)) {
                return $this->response->setJson(['errors' => $validation->getErrors()]);
            }

            $cuenta_bd = $this->modeloCuenta->obtenerCuenta($idcuenta);

            if($cuenta_bd){
                $codigo_bd = $cuenta_bd['cu_codigo'];
                $dh_bd     = $cuenta_bd['cu_dh'] == 'Debe' ? 1 : 2;
                //echo "$codigo/$codigo_bd -- $dh/$dh_bd";
                if( $codigo != $codigo_bd ){
                    if( $this->modeloCuenta->verificarSiExisteCodigoEnDH($codigo,(int)$dh)['total'] > 0 ){
                        echo '<script>Swal.fire({title: "Ya existe un código en este D/H",icon: "error"});</script>';
                        exit();
                    }
                }
                if( $dh_bd != $dh ){
                    if( $this->modeloCuenta->verificarSiExisteCodigoEnDH($codigo,(int)$dh)['total'] > 0 ){
                        echo '<script>Swal.fire({title: "Ya existe un código en este D/H",icon: "error"});</script>';
                        exit();
                    }
                }

                if( $this->modeloCuenta->modificarCuenta($dh,$codigo,$cuenta,$observa,$idcuenta) ){
                    echo '<script>
                        Swal.fire({
                            title: "Cuenta Modificada",
                            text: "",
                            icon: "success",
                            showConfirmButton: false,
                            allowOutsideClick: false,
                        });
                        setTimeout(function(){location.reload()},1500)
                    </script>';
                }
            }else{
                //echo "INSERTAR";
                //echo "$codigo - $dh";
                if( $this->modeloCuenta->verificarSiExisteCodigoEnDH($codigo,(int)$dh)['total'] > 0 ){
                    echo '<script>
                        Swal.fire({
                            title: "Ya existe un código en este D/H",
                            icon: "error"
                        });
                    </script>';
                    exit();
                }

                if( $this->modeloCuenta->insertarCuenta($dh,$codigo,$cuenta,$observa) ){
                    echo '<script>
                        Swal.fire({
                            title: "Cuenta Registrada",
                            text: "",
                            icon: "success",
                            showConfirmButton: false,
                            allowOutsideClick: false,
                        });
                        setTimeout(function(){location.reload()},1500)
                    </script>';
                }
            }            

        }
    }

    public function eliminarCuenta(){
        if( $this->request->isAJAX() ){
            if( !session('idusuario') ) exit();
            if( session('idtipo_usuario') != 1 ) exit();

            $idcuenta = $this->request->getVar('id');

            $eliminar = FALSE;
            $mensaje = "";

            $tablas = ['registro'];
            foreach( $tablas as $t ){
                $total = $this->modeloCuenta->verificarCuentaTieneRegEnTablas($idcuenta,$t)['total'];
                if( $total > 0 ){
                    $mensaje .= "<div class='text-start'>La cuenta tiene $total registros en la tabla '$t'.</div>";
                    $eliminar = TRUE;
                }
            }

            if( $eliminar ){
                echo '<script>
                    Swal.fire({
                        title: "La cuenta no puede ser eliminada",
                        html: "'.$mensaje.'",
                        icon: "warning",
                    });
                </script>';
                exit();
            }

            if( $this->modeloCuenta->eliminarCuenta($idcuenta) ){
                echo '<script>
                    Swal.fire({
                        title: "Cuenta Eliminada",
                        text: "",
                        icon: "success",
                        showConfirmButton: false,
                        allowOutsideClick: false,
                    });
                    setTimeout(function(){location.reload()},1500)
                </script>';
            }
        }
    }



}