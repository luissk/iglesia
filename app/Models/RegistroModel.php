<?php 
namespace App\Models;

use CodeIgniter\Model;

class RegistroModel extends Model{

    public function listarRegistros($idiglesia){
        $query = "select re.idregistro,re.re_fecha,re.re_importe,re.re_desc,re.us_creador,re.idcuenta,re.idresponsable_caja,re.idiglesia,
            re.re_mov,CASE WHEN re.re_mov = 1 THEN 'Ingreso' ELSE 'Egreso' END AS tipo_mov,us.us_nombre,ig.ig_iglesia,ig.ig_direccion,ig.ig_pastor,
            cu.cu_dh,cu.cu_codigo,cu.cu_cuenta,cu.cu_observacion,
            rc.re_nombres,ca.ca_caja
            from registro re
            inner join usuario us on re.us_creador=us.idusuario
            inner join iglesia ig on re.idiglesia=ig.idiglesia
            inner join cuenta cu on re.idcuenta=cu.idcuenta
            inner join responsable_caja rc on re.idresponsable_caja=rc.idresponsable_caja
            inner join caja ca on rc.idcaja=ca.idcaja 
            where re.idiglesia = ? ";//order by re.idregistro desc
        $st = $this->db->query($query,  [$idiglesia]);

        return $st->getResultArray();
    }

    public function obtenerRegistro($idregistro){
        $query = "select re.idregistro,re.re_fecha,re.re_importe,re.re_desc,re.us_creador,re.idcuenta,re.idresponsable_caja,re.idiglesia,
            re.re_mov,CASE WHEN re.re_mov = 1 THEN 'Ingreso' ELSE 'Egreso' END AS tipo_mov,us.us_nombre,ig.ig_iglesia,ig.ig_direccion,ig.ig_pastor,
            cu.cu_dh,cu.cu_codigo,cu.cu_cuenta,cu.cu_observacion,
            rc.re_nombres,ca.ca_caja
            from registro re
            inner join usuario us on re.us_creador=us.idusuario
            inner join iglesia ig on re.idiglesia=ig.idiglesia
            inner join cuenta cu on re.idcuenta=cu.idcuenta
            inner join responsable_caja rc on re.idresponsable_caja=rc.idresponsable_caja
            inner join caja ca on rc.idcaja=ca.idcaja 
            where re.idregistro = ?";
        $st = $this->db->query($query,  [$idregistro]);

        return $st->getRowArray();
    }

    public function listarParaReporte($idiglesia,$mes,$anio,$mov = [1,2]){
        $query = "select re.idregistro,re.re_fecha,re.re_importe,re.re_desc,CASE WHEN re.re_mov = 1 THEN 'Ingreso' ELSE 'Egreso' END AS tipo_mov, 
        cu.cu_dh,cu.cu_codigo,cu.cu_cuenta,ca.ca_caja 
        from registro re 
        inner join usuario us on re.us_creador=us.idusuario 
        inner join iglesia ig on re.idiglesia=ig.idiglesia 
        inner join cuenta cu on re.idcuenta=cu.idcuenta 
        inner join responsable_caja rc on re.idresponsable_caja=rc.idresponsable_caja 
        inner join caja ca on rc.idcaja=ca.idcaja 
        where re.idiglesia = ? and year(re.re_fecha) = ? and month(re.re_fecha) = ? and re.re_mov in ? 
         order by re.re_fecha";
        $st = $this->db->query($query,  [$idiglesia,$anio,$mes,$mov]);

        return $st->getResultArray();
    }

    public function obtenerSaldos($idiglesia, $fecha){
        $query = "select SUM(CASE WHEN re_mov = 1 THEN re_importe ELSE -re_importe END) AS saldo FROM registro WHERE idiglesia = ? and re_fecha < ?";
        $st = $this->db->query($query,  [$idiglesia, $fecha]);

        return $st->getRowArray();
    }

    public function insertarRegistro($fecha,$importe,$concepto,$idusuario,$idcuenta,$idcajaresp,$mov,$idiglesia){
        $query = "insert into registro(re_fecha,re_importe,re_desc,us_creador,idcuenta,idresponsable_caja,re_mov,idiglesia) values(?,?,?,?,?,?,?,?)";
        $st = $this->db->query($query, [$fecha,$importe,$concepto,$idusuario,$idcuenta,$idcajaresp,$mov,$idiglesia]);

        return $st;
    }

    public function modificarRegistro($fecha,$importe,$concepto,$idusuario,$idcuenta,$idcajaresp,$mov,$idregistro){
        $query = "update registro set re_fecha=?,re_importe=?,re_desc=?,us_creador=?,idcuenta=?,idresponsable_caja=?,re_mov=? where idregistro=?";
        $st = $this->db->query($query, [$fecha,$importe,$concepto,$idusuario,$idcuenta,$idcajaresp,$mov,$idregistro]);

        return $st;
    }

    public function eliminarRegistro($idregistro){
        $query = "delete from registro where idregistro=?";
        $st = $this->db->query($query, [$idregistro]);

        return $st;
    }

}