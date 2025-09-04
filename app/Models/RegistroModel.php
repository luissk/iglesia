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


    public function listarProveedores(){
        $query = "select * from proveedor";
        $st = $this->db->query($query);

        return $st->getResultArray();
    }

    public function obtenerProveedor($idproveedor){
        $query = "select * from proveedor where idproveedor = ?";
        $st = $this->db->query($query, [$idproveedor]);

        return $st->getRowArray();
    }

    public function verificarRuc($ruc){
        $query = "select idproveedor as total from proveedor where pr_ruc = ?";
        $st = $this->db->query($query, [$ruc]);

        return $st->getRowArray();
    }

    public function registrarProveedor($ruc, $razon){
        $query = "insert into proveedor(pr_ruc,pr_razon) values(?,?)";
        $st = $this->db->query($query, [$ruc, $razon]);

        return $this->db->insertID();
    }

    public function modificarProveedor($ruc, $razon, $idproveedor){
        $query = "update proveedor set pr_ruc = ?,pr_razon = ? where idproveedor = ?";
        $st = $this->db->query($query, [$ruc, $razon, $idproveedor]);

        return $st;
    }

    //VERIFICAR SI TIENE REGISTRO EN TABLAS
    public function verificarProvTieneRegEnTablas($idproveedor, $tabla){
        $query = "select count(idiglesia) as total from $tabla where idproveedor=?";
        $st = $this->db->query($query, [$idproveedor]);

        return $st->getRowArray();
    }

    public function eliminarProveedor($idproveedor){
        $query = "delete from proveedor where idproveedor = ?";
        $st = $this->db->query($query, [$idproveedor]);

        return $st;
    }

    //COMPRA
    public function obtenerCompra($idcompra, $idiglesia = ''){
        $criterio = '';
        if( $idiglesia != '' ){
            $criterio .= " and co.idiglesia = ?";
        }
        $query = "select co.idcompra, co.co_fecha, co.co_factura,co.idproveedor,co.us_creador,co.idiglesia,
            pr.pr_ruc,pr.pr_razon,
            ig.ig_iglesia,
            us.us_nombre
            from compra co
            inner join proveedor pr on co.idproveedor=pr.idproveedor
            inner join iglesia ig on co.idiglesia=ig.idiglesia
            inner join usuario us on co.us_creador=us.idusuario
            where co.idcompra = ?  $criterio";

        if( $criterio != '' )
            $st = $this->db->query($query, [$idcompra, $idiglesia]);
        else
            $st = $this->db->query($query, [$idcompra]);

        return $st->getRowArray();
    }

    public function listarCompras($idiglesia){
        $query = "select co.idcompra, co.co_fecha, co.co_factura,co.idproveedor,co.us_creador,co.idiglesia,
            pr.pr_ruc,pr.pr_razon,
            ig.ig_iglesia,
            us.us_nombre,
            format( (sum(cd.cd_subtotal) * 0.18 + sum(cd.cd_subtotal)), 2) as totalpagado 
            from compra co
            inner join proveedor pr on co.idproveedor=pr.idproveedor
            inner join iglesia ig on co.idiglesia=ig.idiglesia
            inner join usuario us on co.us_creador=us.idusuario
            inner join compra_detalle cd on co.idcompra=cd.idcompra
            where co.idiglesia = ?
            GROUP by co.idcompra, co.co_fecha, co.co_factura,co.idproveedor,co.us_creador,co.idiglesia,
            pr.pr_ruc,pr.pr_razon,
            ig.ig_iglesia,
            us.us_nombre";
        $st = $this->db->query($query, [$idiglesia]);

        return $st->getResultArray();
    }

    public function listarDetalleCompra($idcompra){
        $query = "select cd.idcompra_detalle,cd.cd_glosa,cd.cd_precio,cd.cd_cant,cd.cd_subtotal,cd.idcuenta,
            cu.cu_codigo,cu.cu_cuenta,cu.cu_observacion
            from compra_detalle cd
            inner join cuenta cu on cd.idcuenta=cu.idcuenta
            where cd.idcompra = ?";
        $st = $this->db->query($query, [$idcompra]);

        return $st->getResultArray();
    }

    public function insertarCompra($fecha, $factura, $proveedor, $idusuario, $idiglesia){
        $query = "insert into compra(co_fecha,co_factura,idproveedor,us_creador,idiglesia) values(?,?,?,?,?)";
        $st = $this->db->query($query, [$fecha, $factura, $proveedor, $idusuario, $idiglesia]);

        return $this->db->insertID();
    }
    
    public function modificarCompra($fecha, $factura, $proveedor, $idcompra){
        $query = "update compra set co_fecha=?, co_factura=?, idproveedor=? where idcompra=?";
        $st = $this->db->query($query, [$fecha, $factura, $proveedor, $idcompra]);

        return $st;
    }

    public function insertarDetalleCompra($glosa,$precio,$cantidad,$subtotal,$cuenta,$idcompra){
        $query = "insert into compra_detalle(cd_glosa,cd_precio,cd_cant,cd_subtotal,idcuenta,idcompra) values(?,?,?,?,?,?)";
        $st = $this->db->query($query, [$glosa,$precio,$cantidad,$subtotal,$cuenta,$idcompra]);

        return $st;
    }

    public function borrarDetalleCompra($idcompra){
        $query = "delete from compra_detalle where idcompra=?";
        $st = $this->db->query($query, [$idcompra]);

        return $st;
    }

    //VERIFICAR SI TIENE REGISTRO EN TABLAS
    public function verificarCompraTieneRegEnTablas($idcompra, $tabla){
        $query = "select count(idcompra) as total from $tabla where idcompra=?";
        $st = $this->db->query($query, [$idcompra]);

        return $st->getRowArray();
    }

    public function eliminarCompra($idcompra){
        $query = "delete from compra where idcompra=?";
        $st = $this->db->query($query, [$idcompra]);

        return $st;
    }

}