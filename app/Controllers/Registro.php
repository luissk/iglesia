<?php

namespace App\Controllers;

class Registro extends BaseController
{
    protected $modeloUsuario;
    protected $modeloRegistro;
    protected $modeloCaja;
    protected $modeloCuenta;
    protected $helpers = ['funciones'];

    public function __construct(){
        $this->modeloUsuario = model('UsuarioModel');
        $this->modeloUsuario = model('RegistroModel');
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

    public function formularioLibroCaja(){
        if( $this->request->isAJAX() ){
            if( !session('idusuario') ) exit();
            if( session('idtipo_usuario') != 2 && session('idtipo_usuario') != 3 ) exit();

            $data['cajas']   = $this->modeloCaja->listarResponsablesDeCaja(session('idiglesia'));
            $data['cuentas'] = $this->modeloCuenta->listarCuentas();

            return view('sistema/registro/frmLCaja', $data);

        }
    }

}