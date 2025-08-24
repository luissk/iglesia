<?php 
namespace App\Models;

use CodeIgniter\Model;

class CuentaModel extends Model{

    public function listarCuentas(){
        $query = "select * from cuenta";
        $st = $this->db->query($query);

        return $st->getResultArray();
    }

    public function obtenerCuenta($idcuenta){
        $query = "select * from cuenta where idcuenta = ?";
        $st = $this->db->query($query, [$idcuenta]);

        return $st->getRowArray();
    }

    public function verificarSiExisteCodigoEnDH($codigo,$dh){
        $query = "select count(idcuenta) as total from cuenta where cu_codigo=? and cu_dh=?";
        $st = $this->db->query($query, [$codigo,$dh]);

        return $st->getRowArray();
    }

    public function modificarCuenta($dh,$codigo,$cuenta,$observacion,$idcuenta){
        $query = "update cuenta set cu_dh=?,cu_codigo=?,cu_cuenta=?,cu_observacion=? where idcuenta=?";
        $st = $this->db->query($query, [$dh,$codigo,$cuenta,$observacion,$idcuenta]);

        return $st;
    }

    public function insertarCuenta($dh,$codigo,$cuenta,$observacion){
        $query = "insert into cuenta(cu_dh,cu_codigo,cu_cuenta,cu_observacion) values(?,?,?,?)";
        $st = $this->db->query($query, [$dh,$codigo,$cuenta,$observacion]);

        return $st;
    }

    public function verificarCuentaTieneRegEnTablas($idcuenta, $tabla){
        $query = "select count(idcuenta) as total from $tabla where idcuenta=?";
        $st = $this->db->query($query, [$idcuenta]);

        return $st->getRowArray();
    }

    public function eliminarCuenta($idcuenta){
        $query = "delete from cuenta where idcuenta = ?";
        $st = $this->db->query($query, [$idcuenta]);

        return $st;
    }


}