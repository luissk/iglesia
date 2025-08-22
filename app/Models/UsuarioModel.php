<?php 
namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model{

    public function validarLogin($usuario){
        $query = "select u.idusuario,u.idiglesia,u.us_usuario,u.us_password,u.us_nombre,u.idtipo_usuario,tu.tu_tipo,i.ig_iglesia
        from usuario u
        inner join iglesia i on u.idiglesia=i.idiglesia
        inner join tipo_usuario tu on u.idtipo_usuario=tu.idtipo_usuario
        where u.us_usuario = ? ";
        $st = $this->db->query($query, [$usuario]);

        return $st->getRowArray();
    }

    public function listarUsuarios($idiglesia = ""){
        $where = "";
        if( $idiglesia != "" )
            $where .= " where u.idiglesia = $idiglesia";

        $query = "select u.idusuario,u.idiglesia,u.us_usuario,u.us_password,u.us_nombre,u.idtipo_usuario,tu.tu_tipo,i.ig_iglesia
        from usuario u
        inner join iglesia i on u.idiglesia=i.idiglesia
        inner join tipo_usuario tu on u.idtipo_usuario=tu.idtipo_usuario $where";
        $st = $this->db->query($query);

        return $st->getResultArray();
    }

    public function listarTipos($tipo = [1,2,3]){
        $query = "select * from tipo_usuario where idtipo_usuario in ?";
        $st = $this->db->query($query, [$tipo]);

        return $st->getResultArray();
    }

    public function obtenerUsuario($idusuario){
        $query = "select u.idusuario,u.idiglesia,u.us_usuario,u.us_password,u.us_nombre,u.idtipo_usuario,tu.tu_tipo,i.ig_iglesia
        from usuario u
        inner join iglesia i on u.idiglesia=i.idiglesia
        inner join tipo_usuario tu on u.idtipo_usuario=tu.idtipo_usuario
        where u.idusuario = ? ";
        $st = $this->db->query($query, [$idusuario]);

        return $st->getRowArray();
    }

    public function modificarUsuario($usuario,$nombre,$password,$tipo,$iglesia,$idusuario){
        $query = "update usuario set us_usuario=?,us_nombre=?,us_password=?,idtipo_usuario=?,idiglesia=? where idusuario=?";
        $st = $this->db->query($query, [
            $usuario,$nombre,$password,$tipo,$iglesia,$idusuario
        ]);

        return $st;
    }

    public function insertarUsuario($usuario,$nombre,$password,$tipo,$iglesia,$idcreador){
        $query = "insert into usuario(us_usuario,us_nombre,us_password,idtipo_usuario,idiglesia,us_creador) values(?,?,?,?,?,?)";
        $st = $this->db->query($query, [
            $usuario,$nombre,$password,$tipo,$iglesia,$idcreador
        ]);

        return $st;
    }




    public function cambiarPassword($idusuario, $password){
        $query = "update usuario set usu_password=? where idusuario=?";
        $st = $this->db->query($query, [$password,$idusuario]);

        return $st;
    }

    public function getUsuario($idusuario){
        $query = "select usu.idusuario, usu.usu_dni, usu.usu_nombres, usu.usu_apellidos, usu.usu_usuario, usu.usu_password, usu.idtipousuario,
        tu.tu_tipo 
        from usuario usu
        inner join tipousuario tu on usu.idtipousuario=tu.idtipousuario
        where idusuario = ?";

        $st = $this->db->query($query, [$idusuario]);

        return $st->getRowArray();
    }

    /* public function existeUsuario_por_UsuDni($opt = 1, $criterio){//1->usuario,2->dni
        if( $opt == 1 ){
            $query = "select idusuario from usuario where LOWER(usu_usuario) = LOWER(?)";
        }else if( $opt == 2 ){
            $query = "select idusuario from usuario where usu_dni = ?";
        }

        $st = $this->db->query($query, [$criterio]);

        return $st->getRowArray();
    } */


    /* public function modificarUsuario($usuario,$dni,$nombres,$apellidos,$perfil,$password,$idusuario){
        $query = "update usuario set usu_usuario=?,usu_dni=?,usu_nombres=?,usu_apellidos=?,idtipousuario=?,usu_password=? where idusuario=?";
        $st = $this->db->query($query, [
            $usuario,$dni,$nombres,$apellidos,$perfil,$password,$idusuario
        ]);

        return $st;
    }

    //VERIFICAR SI TIENE REGISTRO EN TABLAS(usuario,transportista,cliente,pieza,torre,presupuesto,guia,factura) EL USUARIO A ELIMINAR
    public function verificarUsuTieneRegEnTablas($idusuario, $tabla){
        $query = "select count(idusuario2) as total from $tabla where idusuario2=?";
        $st = $this->db->query($query, [$idusuario]);

        return $st->getRowArray();
    }

    public function eliminarUsuario($idusuario){
        $query = "delete from usuario where idusuario = ?";
        $st = $this->db->query($query, [$idusuario]);

        return $st;
    }
 */
}