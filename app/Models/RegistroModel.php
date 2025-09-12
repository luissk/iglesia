<?php 
namespace App\Models;

use CodeIgniter\Model;

class RegistroModel extends Model{

    public function listarRegistros($idiglesia,$anio = '', $mes = '', $caja = ''){
        $params = [$idiglesia];
        $where_more = "";
        if( $anio != '' ){
            $where_more .= " and year(re.re_fecha) = ?";
            array_push($params, $anio);
        } 
        if( $mes != '' ){
            $where_more .= " and month(re.re_fecha) = ?";
            array_push($params, $mes);
        }
        if( $caja != '' ){
            $where_more .= " and re.idcaja = ?";
            array_push($params, $caja);
        }

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
            where re.idiglesia = ? $where_more";//order by re.idregistro desc
        $st = $this->db->query($query,  $params);

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

    public function listarParaReporte($idiglesia,$mes,$anio,$mov = [1,2],$caja = ''){
        $params = [$idiglesia,$anio,$mes,$mov];
        $where_more = "";
        if($caja != ''){
            $where_more .= " and re.idcaja = ? ";
            array_push($params, $caja);
        }

        $query = "select re.idregistro,re.re_fecha,re.re_importe,re.re_desc,CASE WHEN re.re_mov = 1 THEN 'Ingreso' ELSE 'Egreso' END AS tipo_mov,re.idcuenta,
        cu.cu_dh,cu.cu_codigo,cu.cu_cuenta,ca.ca_caja 
        from registro re 
        inner join usuario us on re.us_creador=us.idusuario 
        inner join iglesia ig on re.idiglesia=ig.idiglesia 
        inner join cuenta cu on re.idcuenta=cu.idcuenta 
        inner join responsable_caja rc on re.idresponsable_caja=rc.idresponsable_caja 
        inner join caja ca on rc.idcaja=ca.idcaja 
        where re.idiglesia = ? and year(re.re_fecha) = ? and month(re.re_fecha) = ? and re.re_mov in ? $where_more 
         order by re.re_fecha,re.idregistro";
        $st = $this->db->query($query,  $params);

        return $st->getResultArray();
    }

    public function obtenerSaldos($idiglesia, $fecha, $caja = ''){
        $params = [$idiglesia, $fecha];
        $where_more = "";
        if($caja != ''){
            $where_more .= " and idcaja = ?";
            array_push($params, $caja);
        }

        $query = "select SUM(CASE WHEN re_mov = 1 THEN re_importe ELSE -re_importe END) AS saldo FROM registro WHERE idiglesia = ? and re_fecha < ? $where_more";
        $st = $this->db->query($query,  $params);

        return $st->getRowArray();
    }

    public function insertarRegistro($fecha,$importe,$concepto,$idusuario,$idcuenta,$idcajaresp,$mov,$idcaja,$idiglesia){
        $query = "insert into registro(re_fecha,re_importe,re_desc,us_creador,idcuenta,idresponsable_caja,re_mov,idcaja,idiglesia) values(?,?,?,?,?,?,?,?,?)";
        $st = $this->db->query($query, [$fecha,$importe,$concepto,$idusuario,$idcuenta,$idcajaresp,$mov,$idcaja,$idiglesia]);

        return $st;
    }

    public function modificarRegistro($fecha,$importe,$concepto,$idusuario,$idcuenta,$idcajaresp,$mov,$idcaja,$idregistro){
        $query = "update registro set re_fecha=?,re_importe=?,re_desc=?,us_creador=?,idcuenta=?,idresponsable_caja=?,re_mov=?,idcaja=? where idregistro=?";
        $st = $this->db->query($query, [$fecha,$importe,$concepto,$idusuario,$idcuenta,$idcajaresp,$mov,$idcaja,$idregistro]);

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
            co.co_subt,co.co_igv,co.co_total,co.cuentafact,co.cuentabase,co_glosa,
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
            co.co_subt,co.co_igv,co.co_total,co.cuentafact,co.cuentabase,co_glosa,
            pr.pr_ruc,pr.pr_razon,
            ig.ig_iglesia,
            us.us_nombre
            from compra co
            inner join proveedor pr on co.idproveedor=pr.idproveedor
            inner join iglesia ig on co.idiglesia=ig.idiglesia
            inner join usuario us on co.us_creador=us.idusuario
            where co.idiglesia = ?";
        $st = $this->db->query($query, [$idiglesia]);

        return $st->getResultArray();
    }

    public function insertarCompra($fecha, $factura, $proveedor, $idusuario, $idiglesia, $subt, $igv, $total, $ctafact, $ctabase,$glosa){
        $query = "insert into compra(co_fecha,co_factura,idproveedor,us_creador,idiglesia,co_subt,co_igv,co_total,cuentafact,cuentabase,co_glosa) values(?,?,?,?,?,?,?,?,?,?,?)";
        $st = $this->db->query($query, [$fecha, $factura, $proveedor, $idusuario, $idiglesia, $subt, $igv, $total, $ctafact, $ctabase,$glosa]);

        return $this->db->insertID();
    }
    
    public function modificarCompra($fecha, $factura, $proveedor, $subt, $igv, $total, $ctafact, $ctabase, $glosa, $idcompra){
        $query = "update compra set co_fecha=?, co_factura=?, idproveedor=?, co_subt=?, co_igv=?, co_total=?, cuentafact=?, cuentabase=?, co_glosa=? where idcompra=?";
        $st = $this->db->query($query, [$fecha, $factura, $proveedor, $subt, $igv, $total, $ctafact, $ctabase, $glosa, $idcompra]);

        return $st;
    }

    public function eliminarCompra($idcompra){
        $query = "delete from compra where idcompra=?";
        $st = $this->db->query($query, [$idcompra]);

        return $st;
    }

    public function listarParaReporteLCompra($idiglesia,$mes,$anio){
        $params = [$idiglesia,$anio,$mes];

        $query = "select co.idcompra, co.co_fecha, co.co_factura,co.idproveedor,co.us_creador,co.idiglesia,
            co.co_subt,co.co_igv,co.co_total,co.cuentafact,co.cuentabase,co_glosa,
            pr.pr_ruc,pr.pr_razon,
            ig.ig_iglesia,
            us.us_nombre
            from compra co
            inner join proveedor pr on co.idproveedor=pr.idproveedor
            inner join iglesia ig on co.idiglesia=ig.idiglesia
            inner join usuario us on co.us_creador=us.idusuario
            where co.idiglesia = ? and year(co.co_fecha) = ? and month(co.co_fecha) = ? 
            order by co.co_fecha";
        $st = $this->db->query($query,  $params);

        return $st->getResultArray();
    }

    public function listarParaReporteDiario($idiglesia,$mes,$anio){
        $params = [$idiglesia,$anio,$mes,$idiglesia,$anio,$mes];

        $query = "select re.re_mov mov,re.idcuenta idcu,cu.cu_codigo cod,cu.cu_cuenta cuen,sum(re.re_importe) importe
            from registro re 
            inner join cuenta cu on re.idcuenta=cu.idcuenta 
            where re.idiglesia = ? and year(re.re_fecha) = ? and month(re.re_fecha) = ?
            GROUP by re.re_mov,re.idcuenta,cu.cu_codigo
            UNION 
            select 2 mov, 31  idcu, 401  cod, 'IGV' cuen, sum(co.co_igv)  importe 
            from compra co
            where co.idiglesia = ? and year(co.co_fecha) = ? and month(co.co_fecha) = ? 
            order by mov,cod";
        $st = $this->db->query($query,  $params);

        return $st->getResultArray();
    }

}