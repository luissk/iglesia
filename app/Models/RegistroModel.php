<?php 
namespace App\Models;

use CodeIgniter\Model;

class RegistroModel extends Model{

    public function listarRegistros($idiglesia){
        $query = "select re.idregistro,re.re_fecha,re.re_importe,re.re_desc,re.us_creador,re.idcuenta,re.idresponsable_caja,
            re.re_mov,CASE WHEN re.re_mov = 1 THEN 'Ingreso' ELSE 'Egreso' END AS tipo_mov,us.us_nombre,us.idiglesia,ig.ig_iglesia,ig.ig_direccion,ig.ig_pastor,
            cu.cu_dh,cu.cu_codigo,cu.cu_cuenta,cu.cu_observacion,
            rc.re_nombres,ca.ca_caja
            from registro re
            inner join usuario us on re.us_creador=us.idusuario
            inner join iglesia ig on us.idiglesia=ig.idiglesia
            inner join cuenta cu on re.idcuenta=cu.idcuenta
            inner join responsable_caja rc on re.idresponsable_caja=rc.idresponsable_caja
            inner join caja ca on rc.idcaja=ca.idcaja 
            where us.idiglesia = ? ";//order by re.idregistro desc
        $st = $this->db->query($query,  [$idiglesia]);

        return $st->getResultArray();
    }

    public function obtenerRegistro($idregistro){
        $query = "select re.idregistro,re.re_fecha,re.re_importe,re.re_desc,re.us_creador,re.idcuenta,re.idresponsable_caja,
            re.re_mov,CASE WHEN re.re_mov = 1 THEN 'Ingreso' ELSE 'Egreso' END AS tipo_mov,us.us_nombre,us.idiglesia,ig.ig_iglesia,ig.ig_direccion,ig.ig_pastor,
            cu.cu_dh,cu.cu_codigo,cu.cu_cuenta,cu.cu_observacion,
            rc.re_nombres,ca.ca_caja
            from registro re
            inner join usuario us on re.us_creador=us.idusuario
            inner join iglesia ig on us.idiglesia=ig.idiglesia
            inner join cuenta cu on re.idcuenta=cu.idcuenta
            inner join responsable_caja rc on re.idresponsable_caja=rc.idresponsable_caja
            inner join caja ca on rc.idcaja=ca.idcaja 
            where re.idregistro = ?";
        $st = $this->db->query($query,  [$idregistro]);

        return $st->getRowArray();
    }

    public function insertarRegistro($fecha,$importe,$concepto,$idusuario,$idcuenta,$idcajaresp,$mov){
        $query = "insert into registro(re_fecha,re_importe,re_desc,us_creador,idcuenta,idresponsable_caja,re_mov) values(?,?,?,?,?,?,?)";
        $st = $this->db->query($query, [$fecha,$importe,$concepto,$idusuario,$idcuenta,$idcajaresp,$mov]);

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