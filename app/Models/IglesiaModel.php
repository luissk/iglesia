<?php 
namespace App\Models;

use CodeIgniter\Model;

class IglesiaModel extends Model{

    public function listarIglesias($todas = TRUE, $idiglesia = ""){
        if( $todas)
            $query = "select * from iglesia ";
        else if( $todas == FALSE )
            $query = "select * from iglesia where idiglesia > 1";
        
        if( $idiglesia != "" )//para listar la iglesia del tipo de usuario 2
            $query = "select * from iglesia where idiglesia = $idiglesia";

        $st = $this->db->query($query);   

        return $st->getResultArray();
    }

    public function obtenerIglesia($idiglesia){
        $query = "select * from iglesia where idiglesia=? ";
        $st = $this->db->query($query,[$idiglesia]);

        return $st->getRowArray();
    }

    public function obtenerIglesiaXNombre($iglesia){
        $query = "select * from iglesia where ig_iglesia=? ";
        $st = $this->db->query($query,[$iglesia]);

        return $st->getRowArray();
    }

    public function modificarIglesia($iglesia,$pastor,$direccion,$idiglesia){
        $query = "update iglesia set ig_iglesia=?,ig_pastor=?,ig_direccion=? where idiglesia=?";
        $st = $this->db->query($query, [$iglesia,$pastor,$direccion,$idiglesia]);

        return $st;
    }

    public function insertarIglesia($iglesia,$pastor,$direccion){
        $query = "insert into iglesia(ig_iglesia,ig_pastor,ig_direccion) values(?,?,?)";
        $st = $this->db->query($query, [$iglesia,$pastor,$direccion]);

        return $st;
    }

    //VERIFICAR SI TIENE REGISTRO EN TABLAS
    public function verificarIglesiaTieneRegEnTablas($idiglesia, $tabla){
        $query = "select count(idiglesia) as total from $tabla where idiglesia=?";
        $st = $this->db->query($query, [$idiglesia]);

        return $st->getRowArray();
    }

    public function eliminarIglesia($idiglesia){
        $query = "delete from iglesia where idiglesia = ? and idiglesia != 1";
        $st = $this->db->query($query, [$idiglesia]);

        return $st;
    }

}