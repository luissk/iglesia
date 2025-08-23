<?php 
namespace App\Models;

use CodeIgniter\Model;

class CajaModel extends Model{

    public function listarCajas(){
        $query = "select * from caja";
        $st = $this->db->query($query);

        return $st->getResultArray();
    }

    public function obtenerCaja($idcaja){
        $query = "select * from caja where idcaja = ?";
        $st = $this->db->query($query, [$idcaja]);

        return $st->getRowArray();
    }

    public function obtenerCajaXNombre($caja){
        $query = "select * from caja where upper(ca_caja) = upper(?)";
        $st = $this->db->query($query, [$caja]);

        return $st->getRowArray();
    }

    public function modificarCaja($caja,$idcaja){
        $query = "update caja set ca_caja=? where idcaja=?";
        $st = $this->db->query($query, [$caja,$idcaja]);

        return $st;
    }

    public function insertarCaja($caja){
        $query = "insert into caja(ca_caja) values(?)";
        $st = $this->db->query($query, [$caja]);

        return $st;
    }

    public function verificarCajaTieneRegEnTablas($idcaja, $tabla){
        $query = "select count(idcaja) as total from $tabla where idcaja=?";
        $st = $this->db->query($query, [$idcaja]);

        return $st->getRowArray();
    }

    public function eliminarCaja($idcaja){
        $query = "delete from caja where idcaja = ?";
        $st = $this->db->query($query, [$idcaja]);

        return $st;
    }


    public function listarResponsablesDeCaja($idiglesia){
        $query = "select rc.idresponsable_caja,rc.re_nombres,rc.idiglesia,rc.idcaja,ca.ca_caja
            FROM responsable_caja rc 
            inner join caja ca on rc.idcaja=ca.idcaja
            WHERE idiglesia = ?";
        $st = $this->db->query($query, [$idiglesia]);

        return $st->getResultArray();
    }





}