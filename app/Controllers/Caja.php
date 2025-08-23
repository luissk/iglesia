<?php

namespace App\Controllers;

class Caja extends BaseController
{
    protected $modeloUsuario;
    protected $modeloIglesia;
    protected $modeloCaja;
    protected $helpers = ['funciones'];

    public function __construct(){
        $this->modeloUsuario = model('UsuarioModel');
        $this->modeloIglesia = model('IglesiaModel');
        $this->modeloCaja    = model('CajaModel');
        $this->session;
    }

    public function index(){
        if( !session('idusuario') ){
            return redirect()->to('sistema');
        }

        if( session('idtipo_usuario') != 1 && session('idtipo_usuario') != 2 ) return redirect()->to('sistema');

        $data['title']           = 'Cajas del Sistema';
        $data['cajasLinkActive'] = 1;

        if( session('idtipo_usuario') == 1 ){
            $data['cajas'] = $this->modeloCaja->listarCajas();
            return view('sistema/caja/index', $data);
        }else if( session('idtipo_usuario') == 2 ){
            return view('sistema/caja/admin', $data);
        }
        


        

        
    }

    public function registrarCaja(){
        if( $this->request->isAJAX() ){
            if( !session('idusuario') ) exit();
            if( session('idtipo_usuario') != 1 ) exit();

            //print_r($_POST);exit();

            $caja   = trim($this->request->getVar('caja'));
            $idcaja = $this->request->getVar('idcajae');//para editar

            $validation = \Config\Services::validation();

            $data = [
                'caja'   => $caja,
            ];

            $rules = [
                'caja' => [
                    'label' => 'Caja', 
                    'rules' => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ.\-\",\/ 0-9]+$/]|max_length[45]',
                    'errors' => [
                        'required'    => '* La {field} es requerida.',
                        'regex_match' => '* La {field} no es válida.',
                        'max_length'  => '* La {field} debe contener máximo 45 caracteres.'
                    ]
                ]
            ];

            $validation->setRules($rules);

            if (!$validation->run($data)) {
                return $this->response->setJson(['errors' => $validation->getErrors()]);
            }

            $caja_bd = $this->modeloCaja->obtenerCaja($idcaja);

            if($caja_bd){
                $nombre_bd = $caja_bd['ca_caja'];
                if( $caja != $nombre_bd ){
                    if( $this->modeloCaja->obtenerCajaXNombre($caja) ){
                        echo '<script>
                            Swal.fire({
                                title: "Ya existe el nombre de la Caja",
                                icon: "error"
                            });
                        </script>';
                        exit();
                    }
                }
                if( $this->modeloCaja->modificarCaja($caja,$idcaja) ){
                    echo '<script>
                        Swal.fire({
                            title: "Caja Modificada",
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
                if( $this->modeloCaja->obtenerCajaXNombre($caja) ){
                    echo '<script>
                        Swal.fire({
                            title: "Ya existe el nombre de la Caja",
                            icon: "error"
                        });
                    </script>';
                    exit();
                }

                if($this->modeloCaja->insertarCaja($caja)){
                    echo '<script>
                        Swal.fire({
                            title: "Caja Registrada",
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

    public function eliminarCaja(){
        if( $this->request->isAJAX() ){
            if( !session('idusuario') ) exit();
            if( session('idtipo_usuario') != 1 ) exit();

            $idcaja = $this->request->getVar('id');

            $eliminar = FALSE;
            $mensaje = "";

            $tablas = ['registro','responsable_caja'];
            foreach( $tablas as $t ){
                $total = $this->modeloCaja->verificarCajaTieneRegEnTablas($idcaja,$t)['total'];
                if( $total > 0 ){
                    $mensaje .= "<div class='text-start'>La caja tiene $total registros en la tabla '$t'.</div>";
                    $eliminar = TRUE;
                }
            }

            if( $eliminar ){
                echo '<script>
                    Swal.fire({
                        title: "La caja no puede ser eliminada",
                        html: "'.$mensaje.'",
                        icon: "warning",
                    });
                </script>';
                exit();
            }

            if( $this->modeloCaja->eliminarCaja($idcaja) ){
                echo '<script>
                    Swal.fire({
                        title: "Caja Eliminada",
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