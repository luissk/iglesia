<?php

namespace App\Controllers;

class Usuario extends BaseController
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

        if( session('idtipo_usuario') != 1 && session('idtipo_usuario') != 2 ) return redirect()->to('sistema');

        if( session('idtipo_usuario') == 1 ){//super
            $data['usuarios'] = $this->modeloUsuario->listarUsuarios();
            $data['tipos']    = $this->modeloUsuario->listarTipos([2]);//solo puede crear usuario de tipo 2
            $data['iglesias'] = $this->modeloIglesia->listarIglesias(FALSE);
        }else if( session('idtipo_usuario') == 2 ){//admin
            $data['usuarios'] = $this->modeloUsuario->listarUsuarios(session('idiglesia'));//usuarios de su iglesia
            $data['tipos']    = $this->modeloUsuario->listarTipos([3]);//solo puede crear usuario de tipo 3
            $data['iglesias'] = $this->modeloIglesia->listarIglesias('', session('idiglesia'));//solo su iglesia
        }        

        $data['title']              = 'Usuarios del Sistema';
        $data['usuariosLinkActive'] = 1;

        return view('sistema/usuario/index', $data);
    }

    public function registrarUsuario(){
        if( $this->request->isAJAX() ){
            if( !session('idusuario') ) exit();
            if( session('idtipo_usuario') != 1 && session('idtipo_usuario') != 2 ) exit();

            //validar si el usuario que crea existe
            $us_crea = $this->modeloUsuario->obtenerUsuario(session('idusuario'));
            if( !$us_crea ) exit(); //

            //print_r($_POST);

            $usuario   = trim($this->request->getVar('usuario'));
            $nombre    = trim($this->request->getVar('nombre'));            
            $password  = trim($this->request->getVar('password'));
            $tipo      = $this->request->getVar('tipo');
            $iglesia   = $this->request->getVar('iglesia');
            $idusuario = $this->request->getVar('id_usuarioe');//para editar

            $validation = \Config\Services::validation();

            $data = [
                'usuario'  => $usuario,
                'nombre'   => $nombre,
                'tipo'     => $tipo,
                'iglesia'  => $iglesia,
                'password' => $password,
            ];

            $rules = [
                'usuario' => [
                    'label' => 'Usuario', 
                    'rules' => 'required|regex_match[/^[a-zA-Z0-9_]+$/]|max_length[45]',
                    'errors' => [
                        'required'    => '* El {field} es requerido.',
                        'regex_match' => '* El {field} no es válido.',
                        'max_length'  => '* El {field} debe contener máximo 45 caracteres.'
                    ]
                ],
                'nombre' => [
                    'label' => 'Nombre', 
                    'rules' => 'required|regex_match[/^[a-zA-ZñÑáéíóúÁÉÍÓÚ. 0-9]+$/]|max_length[100]',
                    'errors' => [
                        'required'    => '* El {field} es requerido.',
                        'regex_match' => '* El {field} no es válido.',
                        'max_length'  => '* El {field} debe contener máximo 100 caracteres.'
                    ]
                ],                
                'password' => [
                    'label' => 'Password', 
                    'rules' => 'required|min_length[8]|max_length[20]',
                    'errors' => [
                        'required'    => '* El {field} es requerido.',
                        'min_length' => '* El {field} debe tener al menos 8 caracteres.',
                        'max_length' => '* El {field} debe tener hasta 20 caracteres.'
                    ]
                ]
            ];

            if( ( session('idtipo_usuario') == 1 || session('idtipo_usuario') == 2 ) && ( isset($tipo) && $tipo !=session('idtipo_usuario') ) ){
                //Validar tbn estos campos
                $rules['tipo'] = [
                    'label' => 'Tipo', 
                    'rules' => 'required|regex_match[/^[0-9]+$/]',
                    'errors' => [
                        'required'    => '* El {field} es requerido.',
                        'regex_match' => '* El {field} sólo contiene números.'
                    ]
                ];
                $rules['iglesia'] = [
                    'label' => 'Iglesia', 
                    'rules' => 'required|regex_match[/^[0-9]+$/]',
                    'errors' => [
                        'required'    => '* La {field} es requerido.',
                        'regex_match' => '* La {field} sólo contiene números.'
                    ]
                ];
            }

            $hash = '$2a$12$YmtIBS/VsxVywSQHV4A2.upBWJxS2VSqFzUwo1eMU5.tIGOgne6YG';
            $password = $password != '' ? crypt($password, $hash) : '';

            $usuario_bd = $this->modeloUsuario->obtenerUsuario($idusuario);
            if( $usuario_bd ){
                if( $password == '' ){
                    $rules['password']['rules'] = 'permit_empty|min_length[8]|max_length[20]'; //permitir vacio
                    array_splice($rules['password']['errors'], 0, 1); //remover msj error requerido
                    $password = $usuario_bd['us_password'];
                }

                //
                if($iglesia == ''){
                    $iglesia = $usuario_bd['idiglesia'];
                }
                if($tipo == ''){
                    $tipo = $usuario_bd['idtipo_usuario'];
                }
            }

            $validation->setRules($rules);

            if (!$validation->run($data)) {
                return $this->response->setJson(['errors' => $validation->getErrors()]);
            }

            if( $usuario_bd ){
                $user_bd = $usuario_bd['us_usuario'];
                if( strtoupper($usuario) != strtoupper($user_bd) ){
                    if( $this->modeloUsuario->validarLogin($usuario) ){
                        echo '<script>
                            Swal.fire({
                                title: "El usuario ya existe",
                                icon: "error"
                            });
                        </script>';
                        exit();
                    }
                }
                if( $this->modeloUsuario->modificarUsuario($usuario,$nombre,$password,$tipo,$iglesia,$idusuario) ){
                    echo '<script>
                        Swal.fire({
                            title: "Usuario Modificado",
                            text: "",
                            icon: "success",
                            showConfirmButton: false,
                            allowOutsideClick: false,
                        });
                        setTimeout(function(){location.reload()},1500)
                    </script>';
                }
            }else{
                if( $this->modeloUsuario->validarLogin($usuario) ){
                    echo '<script>
                        Swal.fire({
                            title: "El usuario ya existe",
                            icon: "error"
                        });
                    </script>';
                    exit();
                }

                if( $this->modeloUsuario->insertarUsuario($usuario,$nombre,$password,$tipo,$iglesia,session('idusuario')) ){
                    echo '<script>
                        Swal.fire({
                            title: "Usuario Registrado",
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

    public function eliminarUsuario(){
        if( $this->request->isAJAX() ){
            if(!session('idusuario')) exit();
            if( session('idtipo_usuario') != 1 && session('idtipo_usuario') != 2 ) exit();

            $idusuario = $this->request->getVar('id');

            if( $idusuario == 1 ) exit();

            $eliminar = FALSE;
            $mensaje = "";

            $tablas = ['usuario','registro','responsable_caja'];
            foreach( $tablas as $t ){
                $total = $this->modeloUsuario->verificarUsuTieneRegEnTablas($idusuario,$t)['total'];
                if( $total > 0 ){
                    $mensaje .= "<div class='text-start'>El usuario tiene $total registros en la tabla '$t'.</div>";
                    $eliminar = TRUE;
                }
            }

            if( $eliminar ){
                echo '<script>
                    Swal.fire({
                        title: "El usuario no puede ser eliminado",
                        html: "'.$mensaje.'",
                        icon: "warning",
                    });
                </script>';
                exit();
            }

            if( $this->modeloUsuario->eliminarUsuario($idusuario) ){
                echo '<script>
                    Swal.fire({
                        title: "Usuario Eliminado",
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