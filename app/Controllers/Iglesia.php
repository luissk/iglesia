<?php

namespace App\Controllers;

class Iglesia extends BaseController
{
    protected $modeloUsuario;
    protected $modeloIglesia;
    protected $helpers = ['funciones'];

    public function __construct(){
        $this->modeloUsuario = model('UsuarioModel');
        $this->modeloIglesia = model('IglesiaModel');
        $this->session;
    }

    public function index(){
        if( !session('idusuario') ){
            return redirect()->to('sistema');
        }

        if( session('idtipo_usuario') != 1 ) return redirect()->to('sistema');

        $data['iglesias'] = $this->modeloIglesia->listarIglesias();

        $data['title']              = 'Iglesias del Sistema';
        $data['iglesiasLinkActive'] = 1;

        return view('sistema/iglesia/index', $data);    
    }

    public function registrarIglesia(){
        if( $this->request->isAJAX() ){
            if( !session('idusuario') ) exit();
            if( session('idtipo_usuario') != 1 ) exit();

            //print_r($_POST);exit();

            $iglesia   = trim($this->request->getVar('iglesia'));
            $pastor    = trim($this->request->getVar('pastor'));
            $direccion = trim($this->request->getVar('direccion'));
            $idiglesia = $this->request->getVar('id_iglesiae');//para editar

            $validation = \Config\Services::validation();

            $data = [
                'iglesia'   => $iglesia,
                'pastor'    => $pastor,
                'direccion' => $direccion,
            ];

            $rules = [
                'iglesia' => [
                    'label' => 'Iglesia', 
                    'rules' => 'required|max_length[200]',
                    'errors' => [
                        'required'    => '* La {field} es requerida.',
                        'max_length'  => '* La {field} debe contener máximo 100 caracteres.'
                    ]
                ],
                'pastor' => [
                    'label' => 'Pastor', 
                    'rules' => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ.\-\",\/ 0-9]+$/]|max_length[100]',
                    'errors' => [
                        'required'    => '* El {field} es requerido.',
                        'regex_match' => '* El {field} no es válido.',
                        'max_length'  => '* El {field} debe contener máximo 100 caracteres.'
                    ]
                ],
                'direccion' => [
                    'label' => 'Dirección', 
                    'rules' => 'required|max_length[100]',
                    'errors' => [
                        'required'    => '* La {field} es requerida.',
                        'max_length'  => '* La {field} debe contener máximo 100 caracteres.'
                    ]
                ],
            ];

            $validation->setRules($rules);

            if (!$validation->run($data)) {
                return $this->response->setJson(['errors' => $validation->getErrors()]);
            }

            $iglesia_bd = $this->modeloIglesia->obtenerIglesia($idiglesia);

            if($iglesia_bd){
                 $nombre_bd = $iglesia_bd['ig_iglesia'];
                if( $iglesia != $nombre_bd ){
                    if( $this->modeloIglesia->obtenerIglesiaXNombre($iglesia) ){
                        echo '<script>
                            Swal.fire({
                                title: "Ya existe el nombre de la Iglesia",
                                icon: "error"
                            });
                        </script>';
                        exit();
                    }
                }
                if( $this->modeloIglesia->modificarIglesia($iglesia,$pastor,$direccion,$idiglesia) ){
                    echo '<script>
                        Swal.fire({
                            title: "Iglesia Modificada",
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
                if( $this->modeloIglesia->obtenerIglesiaXNombre($iglesia) ){
                    echo '<script>
                        Swal.fire({
                            title: "Ya existe el nombre de la Iglesia",
                            icon: "error"
                        });
                    </script>';
                    exit();
                }

                if($this->modeloIglesia->insertarIglesia($iglesia,$pastor,$direccion)){
                    echo '<script>
                        Swal.fire({
                            title: "Iglesia Registrada",
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

    public function eliminarIglesia(){
        if( $this->request->isAJAX() ){
            if( !session('idusuario') ) exit();
            if( session('idtipo_usuario') != 1 ) exit();

            $idiglesia = $this->request->getVar('id');

            $eliminar = FALSE;
            $mensaje = "";

            $tablas = ['usuario','responsable_caja','registro'];
            foreach( $tablas as $t ){
                $total = $this->modeloIglesia->verificarIglesiaTieneRegEnTablas($idiglesia,$t)['total'];
                if( $total > 0 ){
                    $mensaje .= "<div class='text-start'>La iglesia tiene $total registros en la tabla '$t'.</div>";
                    $eliminar = TRUE;
                }
            }

            if( $eliminar ){
                echo '<script>
                    Swal.fire({
                        title: "La iglesia no puede ser eliminada",
                        html: "'.$mensaje.'",
                        icon: "warning",
                    });
                </script>';
                exit();
            }

            if( $this->modeloIglesia->eliminarIglesia($idiglesia) ){
                echo '<script>
                    Swal.fire({
                        title: "Iglesia Eliminada",
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