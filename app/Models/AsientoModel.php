<?php 
namespace App\Models;

use CodeIgniter\Model;

class AsientoModel extends Model{

    public function registrarAsiento($fecha,$desc,$documento,$total_debe,$total_haber,$idiglesia){
        $query = "insert into asiento(as_fecha,as_desc,as_nrodoc,as_totald,as_totalh,idiglesia) values(?,upper(?),?,?,?,?)";

        $st = $this->db->query($query, [$fecha,$desc,$documento,$total_debe,$total_haber,$idiglesia]);

        return $this->db->insertID();
    }

    public function modificarAsiento($fecha,$desc,$documento,$total_debe,$total_haber,$idasiento){
        $query = "update asiento set as_fecha=?,as_desc=?,as_nrodoc=?,as_totald=?,as_totalh=? where idasiento=?";

        $st = $this->db->query($query, [$fecha,$desc,$documento,$total_debe,$total_haber,$idasiento]);

        return $st;
    }

    public function insertarDetalleAsiento($idasiento, $idcuenta, $debe, $haber){
        $query = "insert into asiento_detalle(idasiento,idcuenta,monto_debe,monto_haber) values(?,?,?,?)";

        $st = $this->db->query($query, [$idasiento, $idcuenta, $debe, $haber]);

        return $st;
    }

    public function listarAsientosDT($idiglesia){
        $query = "select idasiento,as_fecha,as_desc,as_nrodoc,as_totald,as_totalh from asiento where idiglesia = ? order by idasiento desc";

        $st = $this->db->query($query, [$idiglesia]);

        return $st->getResultArray();
    }

    public function obtenerAsiento($idasiento, $idiglesia){
        $query = "select idasiento,as_fecha,as_desc,as_nrodoc,as_totald,as_totalh from asiento where idasiento = ? and idiglesia = ?";

        $st = $this->db->query($query, [$idasiento, $idiglesia]);

        return $st->getRowArray();
    }


    public function listarAsientoDetalle($idasiento){
        $query = "select * from asiento_detalle where idasiento = ?";

        $st = $this->db->query($query, [$idasiento]);

        return $st->getResultArray();
    }

    public function eliminarDetalleAsiento($idasiento){
        $query = "delete from asiento_detalle where idasiento = ?";

        $st = $this->db->query($query, [$idasiento]);

        return $st;
    }

    public function eliminarAsiento($idasiento){
        $query = "delete from asiento where idasiento = ?";

        $st = $this->db->query($query, [$idasiento]);

        return $st;
    }

}