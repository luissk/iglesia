<?php

namespace App\Controllers;

class Inicio extends BaseController
{
    protected $modeloUsuario;
    protected $helpers = ['funciones'];

    public function __construct(){
        $this->modeloUsuario = model('UsuarioModel');
        $this->session;
    }

    public function index(){
        if( session('idusuario') ){
            return redirect()->to('sistema');
        }

        if( $this->request->is('post') ){
            $usuario  = trim($this->request->getVar('usuario'));
            $password = trim($this->request->getVar('password'));

            $validation = \Config\Services::validation();
                $validation->setRules([
                    'usuario' => [
                    'label' => 'Usuario', 
                    'rules'  => 'required|regex_match[/^[a-zA-Z_]+$/]|max_length[45]',
                    'errors' => [
                            'required'    => '* El {field} es requerido.',
                            'regex_match' => '* El {field} no es válido.',
                            'max_length'  => '* Como máximo 45 caracteres para el {field}.'
                        ]
                    ],
                    'password' => [
                        'label' => 'Password', 
                        'rules' => 'required',
                        'errors' => [
                            'required' => '* El {field} es requerido.'
                        ]
                    ]
                ]);

                $data = [
                    'usuario'  => $usuario,
                    'password' => $password,
                ];

                if (!$validation->run($data)) {
                    return redirect()->back()->with('errors', $validation->getErrors())->withInput();
                }

                $hash = '$2a$12$YmtIBS/VsxVywSQHV4A2.upBWJxS2VSqFzUwo1eMU5.tIGOgne6YG';
                $password = crypt($password, $hash);

                $result = $this->modeloUsuario->validarLogin($usuario);

                if( $result && $result['us_password'] == $password ){
                     /* echo "<pre>";
                     print_r($result);
                     echo "</pre>"; */
                     
                    $datasession = [
                        'idusuario'      => $result['idusuario'],
                        'usuario'        => $result['us_usuario'],
                        'nombres'        => $result['us_nombre'],
                        'idiglesia'      => $result['idiglesia'],
                        'idtipo_usuario' => $result['idtipo_usuario'],
                        'tipo_usuario'   => $result['tu_tipo'],
                        'iglesia'        => $result['ig_iglesia']
                    ];
                    $this->session->set($datasession);
 
                    return redirect()->to('sistema',null, 'refresh');
                }else{
                    $this->session->remove('errors');
                    return redirect()->route('/')->with('msg_login', 'Usuario y/o Contraseña inválidos.');
                }

        }

        return view('index');
    }

    public function salir(){
        $this->session->destroy();
        return redirect()->to('/');
    }

    public function sistema()
    {
        if( !session('idusuario') ){
            return redirect()->to('/');
        }

        $data['title']          = 'Bienvenido al Sistema';
        $data['dashLinkActive'] = 1;

        if( session('idtipo_usuario') == 1 ){
            return view('sistema/index', $data);
        }else if( session('idtipo_usuario') == 2 ){
            return view('sistema/index', $data);
        }else if( session('idtipo_usuario') == 3 ){
            return redirect()->to('registros');
        }
            
          
    }
}
