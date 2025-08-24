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


    // RESPONSABLES DE CAJA

    public function listarResponsablesDeCaja($idiglesia){
        $query = "select rc.idresponsable_caja,rc.re_nombres,rc.idiglesia,rc.idcaja,ca.ca_caja
            FROM responsable_caja rc 
            inner join caja ca on rc.idcaja=ca.idcaja
            WHERE rc.idiglesia = ?";
        $st = $this->db->query($query, [$idiglesia]);

        return $st->getResultArray();
    }

    public function obtenerResponsableDeCaja($idresponsable){
        $query = "select rc.idresponsable_caja,rc.re_nombres,rc.idiglesia,rc.idcaja,ca.ca_caja
            FROM responsable_caja rc 
            inner join caja ca on rc.idcaja=ca.idcaja
            WHERE rc.idresponsable_caja = ?";
        $st = $this->db->query($query, [$idresponsable]);

        return $st->getRowArray();
    }

    public function existeResponsableDeCajaIglesia($idcaja, $idiglesia){
        $query = "select count(idresponsable_caja) as total from responsable_caja where idcaja = ? and idiglesia = ?";
        $st = $this->db->query($query, [$idcaja, $idiglesia]);

        return $st->getRowArray();
    }

    public function modificarResponsableCaja($nombre,$idcaja,$idiglesia,$idresponsable){
        $query = "update responsable_caja set re_nombres=?,idcaja=?,idiglesia=? where idresponsable_caja=?";
        $st = $this->db->query($query, [$nombre,$idcaja,$idiglesia,$idresponsable]);

        return $st;
    }

    public function insertarResponsableCaja($nombre,$idcaja,$idiglesia,$idcreador){
        $query = "insert into responsable_caja(re_nombres,idcaja,idiglesia,us_creador) values(?,?,?,?)";
        $st = $this->db->query($query, [$nombre,$idcaja,$idiglesia,$idcreador]);

        return $st;
    }

    public function verificarResponsableTieneRegEnTablas($idresponsable, $tabla){
        $query = "select count(idresponsable_caja) as total from $tabla where idresponsable_caja=?";
        $st = $this->db->query($query, [$idresponsable]);

        return $st->getRowArray();
    }

    public function eliminarResponsableCaja($idresponsable){
        $query = "delete from responsable_caja where idresponsable_caja = ?";
        $st = $this->db->query($query, [$idresponsable]);

        return $st;
    }


}