<?php

namespace App\Controllers;

class Registro extends BaseController
{
    protected $modeloUsuario;
    protected $modeloRegistro;
    protected $helpers = ['funciones'];

    public function __construct(){
        $this->modeloUsuario = model('UsuarioModel');
        $this->modeloUsuario = model('RegistroModel');
        $this->session;
    }


    public function index(){
        if( !session('idusuario') ){
            return redirect()->to('/');
        }
        
        $data['title']           = "Registros del Sistema";
        $data['registrosLinkActive'] = 1;

        //FIN PARA SACAR LOS TOTALES DE PESOS EN TONELADAS
        

        return view('sistema/registro/index', $data);
    }

}