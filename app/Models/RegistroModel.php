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

        $query = "select re.idregistro,re.re_fecha,re.re_importe,re.re_desc,re.us_creador,re.idcuenta,re.idresponsable_caja,re.idiglesia,re.idcompra,
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
        $query = "select re.idregistro,re.re_fecha,re.re_importe,re.re_desc,re.us_creador,re.idcuenta,re.idresponsable_caja,re.idiglesia,re.idcompra,
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

    public function insertarRegistro($fecha,$importe,$concepto,$idusuario,$idcuenta,$idcajaresp,$mov,$idcaja,$idiglesia,$idcompra){
        $query = "insert into registro(re_fecha,re_importe,re_desc,us_creador,idcuenta,idresponsable_caja,re_mov,idcaja,idiglesia,idcompra) values(?,?,?,?,?,?,?,?,?,?)";
        $st = $this->db->query($query, [$fecha,$importe,$concepto,$idusuario,$idcuenta,$idcajaresp,$mov,$idcaja,$idiglesia,$idcompra]);

        return $st;
    }

    public function modificarRegistro($fecha,$importe,$concepto,$idusuario,$idcuenta,$idcajaresp,$mov,$idcaja,$idcompra,$idregistro){
        $query = "update registro set re_fecha=?,re_importe=?,re_desc=?,us_creador=?,idcuenta=?,idresponsable_caja=?,re_mov=?,idcaja=?,idcompra=? where idregistro=?";
        $st = $this->db->query($query, [$fecha,$importe,$concepto,$idusuario,$idcuenta,$idcajaresp,$mov,$idcaja,$idcompra,$idregistro]);

        return $st;
    }

    public function eliminarRegistro($idregistro){
        $query = "delete from registro where idregistro=?";
        $st = $this->db->query($query, [$idregistro]);

        return $st;
    }


    public function listarProveedores($tipo = 1){//1: proveedores, 2:clientes
        $params = [$tipo];
        $query = "select * from proveedor where pr_type = ?";
        $st = $this->db->query($query, $params);

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

    public function registrarProveedor($ruc, $razon, $tipo){
        $query = "insert into proveedor(pr_ruc,pr_razon,pr_type) values(?,?,?)";
        $st = $this->db->query($query, [$ruc, $razon, $tipo]);

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
    public function obtenerCompra_PorID($idcompra){
        $params = [$idcompra];
        $query = "select * from compra where idcompra = ? ";

        $st = $this->db->query($query, $params);

        return $st->getRowArray();
    }

    public function obtenerCompra($idcompra, $idiglesia, $tipo = 1){//1:compra, 2:venta
        $where = '';
        $params = [$idcompra, $idiglesia, $tipo];
        /* if( $idiglesia != '' ){
            $where .= " and co.idiglesia = ?";
            array_push($params, $idiglesia);
        } */
        $query = "select co.idcompra, co.co_fecha, co.co_factura,co.idproveedor,co.us_creador,co.idiglesia,co.co_type,
            co.co_subt,co.co_igv,co.co_total,co.cuentafact,co.cuentabase,co.cuentaigv,co.co_glosa,co.co_status,(case when co.co_status = 1 then 'si' else 'no' end) pagado,
            pr.pr_ruc,pr.pr_razon,
            ig.ig_iglesia,
            us.us_nombre,
            re.idregistro,re.re_fecha,re.re_desc
            from compra co
            inner join proveedor pr on co.idproveedor=pr.idproveedor
            inner join iglesia ig on co.idiglesia=ig.idiglesia
            inner join usuario us on co.us_creador=us.idusuario 
            left join registro re on co.idcompra=re.idcompra
            where co.idcompra = ?  and co.idiglesia = ? and co.co_type = ?";

        $st = $this->db->query($query, $params);

        return $st->getRowArray();
    }

    public function listarCompras($idiglesia, $tipo, $status = ''){
        $params = [$idiglesia, $tipo];
        $where  = "";
        if( $status != '' ){
            $where .= " and co.co_status = ?";
            array_push($params, $status);
        }
        $query = "select co.idcompra, co.co_fecha, co.co_factura,co.idproveedor,co.us_creador,co.idiglesia,co.co_type,
            co.co_subt,co.co_igv,co.co_total,co.cuentafact,co.cuentabase,co.cuentaigv,co.co_glosa,co.co_status,(case when co.co_status = 1 then 'si' else 'no' end) pagado,
            pr.pr_ruc,pr.pr_razon,
            ig.ig_iglesia,
            us.us_nombre,
            re.idregistro,re.re_fecha,re.re_desc
            from compra co
            inner join proveedor pr on co.idproveedor=pr.idproveedor
            inner join iglesia ig on co.idiglesia=ig.idiglesia
            inner join usuario us on co.us_creador=us.idusuario 
            left join registro re on co.idcompra=re.idcompra
            where co.idiglesia = ? and co.co_type = ? $where";
        $st = $this->db->query($query, $params);

        return $st->getResultArray();
    }

    public function insertarCompra($fecha, $factura, $proveedor, $idusuario, $idiglesia, $subt, $igv, $total, $ctafact, $ctaigv, $ctabase, $glosa, $type){
        $query = "insert into compra(co_fecha,co_factura,idproveedor,us_creador,idiglesia,co_subt,co_igv,co_total,cuentafact,cuentaigv,cuentabase,co_glosa,co_type) values(?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $st = $this->db->query($query, [$fecha, $factura, $proveedor, $idusuario, $idiglesia, $subt, $igv, $total, $ctafact, $ctaigv, $ctabase,$glosa,$type]);

        return $this->db->insertID();
    }
    
    public function modificarCompra($fecha, $factura, $proveedor, $subt, $igv, $total, $ctafact, $ctaigv, $ctabase, $glosa, $idcompra){
        $query = "update compra set co_fecha=?, co_factura=?, idproveedor=?, co_subt=?, co_igv=?, co_total=?, cuentafact=?, cuentaigv=?, cuentabase=?, co_glosa=? where idcompra=?";
        $st = $this->db->query($query, [$fecha, $factura, $proveedor, $subt, $igv, $total, $ctafact, $ctaigv, $ctabase, $glosa, $idcompra]);

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

    public function cambiarEstadoCompra($idcompra, $status){
        $query = "update compra set co_status=? where idcompra=?";
        $st = $this->db->query($query, [$status, $idcompra]);

        return $st;
    }

    public function listarParaReporteLCompra($idiglesia,$mes,$anio,$tipo){
        $params = [$idiglesia,$anio,$mes,$tipo];

        $query = "select co.idcompra, co.co_fecha, co.co_factura,co.idproveedor,co.us_creador,co.idiglesia,
            co.co_subt,co.co_igv,co.co_total,co.cuentafact,co.cuentabase,co_glosa,
            pr.pr_ruc,pr.pr_razon,
            ig.ig_iglesia,
            us.us_nombre
            from compra co
            inner join proveedor pr on co.idproveedor=pr.idproveedor
            inner join iglesia ig on co.idiglesia=ig.idiglesia
            inner join usuario us on co.us_creador=us.idusuario
            where co.idiglesia = ? and year(co.co_fecha) = ? and month(co.co_fecha) = ? and co.co_type = ?
            order by co.co_fecha";
        $st = $this->db->query($query,  $params);

        return $st->getResultArray();
    }

    public function listarParaReporteDiario($idiglesia,$mes,$anio){
        $params = [$idiglesia,$anio,$mes,$idiglesia,$anio,$mes,$idiglesia,$anio,$mes,$idiglesia,$anio,$mes,
                $idiglesia,$anio,$mes,$idiglesia,$anio,$mes,$idiglesia,$anio,$mes];

        $query = "select re.re_mov mov,re.idcuenta idcu,cu.cu_codigo cod,cu.cu_cuenta cuen,sum(re.re_importe) importe
            from registro re 
            inner join cuenta cu on re.idcuenta=cu.idcuenta 
            where re.idiglesia = ? and year(re.re_fecha) = ? and month(re.re_fecha) = ?
            GROUP by re.re_mov,re.idcuenta,cu.cu_codigo
            UNION 
            select 2 mov, co.cuentaigv idcu, cu.cu_codigo cod, cu.cu_cuenta cuen, sum(co.co_igv) importe 
            from compra co 
            inner join cuenta cu on co.cuentaigv=cu.idcuenta
            where co.idiglesia = ? and year(co.co_fecha) = ? and month(co.co_fecha) = ? and co.co_type = 1 
            UNION 
            select 1 mov, co.cuentafact idcu, cu.cu_codigo cod, cu.cu_cuenta cuen, sum(co.co_total) importe 
            from compra co 
            inner join cuenta cu on co.cuentafact=cu.idcuenta
            where co.idiglesia = ? and year(co.co_fecha) = ? and month(co.co_fecha) = ? and co.co_type = 1
            UNION 
            select 2 mov, co.cuentabase idcu, cu.cu_codigo cod, cu.cu_cuenta cuen, sum(co.co_subt) importe 
            from compra co 
            inner join cuenta cu on co.cuentabase=cu.idcuenta
            where co.idiglesia = ? and year(co.co_fecha) = ? and month(co.co_fecha) = ? and co.co_type = 1 
            GROUP by co.cuentabase, cu.cu_codigo, cu.cu_cuenta

            UNION 
            select 1 mov, co.cuentaigv idcu, cu.cu_codigo cod, cu.cu_cuenta cuen, sum(co.co_igv) importe 
            from compra co 
            inner join cuenta cu on co.cuentaigv=cu.idcuenta
            where co.idiglesia = ? and year(co.co_fecha) = ? and month(co.co_fecha) = ? and co.co_type = 2 
            UNION 
            select 2 mov, co.cuentafact idcu, cu.cu_codigo cod, cu.cu_cuenta cuen, sum(co.co_total) importe 
            from compra co 
            inner join cuenta cu on co.cuentafact=cu.idcuenta
            where co.idiglesia = ? and year(co.co_fecha) = ? and month(co.co_fecha) = ? and co.co_type = 2
            UNION 
            select 1 mov, co.cuentabase idcu, cu.cu_codigo cod, cu.cu_cuenta cuen, sum(co.co_subt) importe 
            from compra co 
            inner join cuenta cu on co.cuentabase=cu.idcuenta
            where co.idiglesia = ? and year(co.co_fecha) = ? and month(co.co_fecha) = ? and co.co_type = 2 
            GROUP by co.cuentabase, cu.cu_codigo, cu.cu_cuenta

            order by mov,cod;";
        $st = $this->db->query($query,  $params);

        return $st->getResultArray();
    }

    public function ReportePorCodCuenta($idiglesia, $anio, $mes, $codcuenta){
        //$params = [$idiglesia, $codcuenta, $idiglesia, $codcuenta];

        /* $query = "select
            cu.cu_codigo cuenta,
            'TOTAL' AS TipoRegistro,
            -- Columna para la suma de las ENTRADAS
            SUM(CASE WHEN re.re_mov = 1 THEN re.re_importe ELSE 0 END) AS TotalEntradas,    
            -- Columna para la suma de las SALIDAS
            SUM(CASE WHEN re.re_mov = 2 THEN re.re_importe ELSE 0 END) AS TotalSalidas,
            NULL AS tipo,
            NULL AS fecha,
            NULL AS glosa,
            NULL AS caja
            FROM
                registro re
                inner join cuenta cu on re.idcuenta=cu.idcuenta
                inner join caja ca on re.idcaja=ca.idcaja
                where re.idiglesia = 4 and year(re.re_fecha) = 2025 and month(re.re_fecha) = 7 and cu.cu_codigo='140'
            GROUP BY
                cu.cu_codigo

            UNION ALL

            -- 2. PARTE: DETALLE DE TRANSACCIONES (Filas de detalle)
            SELECT
                cu.cu_codigo cuenta,
                'DETALLE' AS TipoRegistro,
                CASE WHEN re.re_mov = 1 THEN re.re_importe ELSE NULL END AS TotalEntradas,
                -- Muestra el monto solo si es una 'salida', sino NULL
                CASE WHEN re.re_mov = 2 THEN re.re_importe ELSE NULL END AS TotalSalidas,  -- ya que estas filas son el detalle.
                re.re_mov AS tipo,
                re.re_fecha AS fecha,
                re.re_desc as glosa,
                ca.ca_caja
            FROM
                registro re
                inner join cuenta cu on re.idcuenta=cu.idcuenta
                inner join caja ca on re.idcaja=ca.idcaja
                where re.idiglesia = 4 and year(re.re_fecha) = 2025 and month(re.re_fecha) = 7 and cu.cu_codigo='140'
            ORDER BY
                cuenta,
                TipoRegistro DESC, -- Asegura que el 'TOTAL' aparezca antes que el 'DETALLE'
                fecha;"; */

        $params = [$idiglesia, $anio, $mes, $codcuenta, $idiglesia, $anio, $mes, $codcuenta, $idiglesia, $anio, $mes, $codcuenta, $idiglesia, $anio, $mes, $codcuenta];

        $query = "select re.re_mov mov,re.idcuenta idcu,cu.cu_codigo cod,cu.cu_cuenta cuen,re.re_importe importe,re.re_desc glosa,re.re_fecha fecha,ca.ca_caja caja,NULL factura,
            NULL tipo
            from registro re 
            inner join cuenta cu on re.idcuenta=cu.idcuenta 
            inner join caja ca on re.idcaja=ca.idcaja
            where re.idiglesia = ? and year(re.re_fecha) = ? and month(re.re_fecha) = ? and cu.cu_codigo=?
            UNION 
            select 2 mov, co.cuentaigv idcu, cu.cu_codigo cod, cu.cu_cuenta cuen, co.co_igv importe,co.co_glosa glosa,co.co_fecha fecha,NULL caja,co.co_factura factura,co.co_type tipo 
            from compra co 
            inner join cuenta cu on co.cuentaigv=cu.idcuenta
            where co.idiglesia = ? and year(co.co_fecha) = ? and month(co.co_fecha) = ? and cu.cu_codigo=? 
            UNION 
            select 2 mov, co.cuentafact idcu, cu.cu_codigo cod, cu.cu_cuenta cuen, co.co_total importe,co.co_glosa glosa,co.co_fecha fecha,NULL caja,co.co_factura factura,co.co_type tipo 
            from compra co 
            inner join cuenta cu on co.cuentafact=cu.idcuenta
            where co.idiglesia = ? and year(co.co_fecha) = ? and month(co.co_fecha) = ? and cu.cu_codigo=? 
            UNION 
            select 2 mov, co.cuentabase idcu, cu.cu_codigo cod, cu.cu_cuenta cuen, co.co_subt importe,co.co_glosa glosa,co.co_fecha fecha,NULL caja,co.co_factura factura,co.co_type tipo 
            from compra co 
            inner join cuenta cu on co.cuentabase=cu.idcuenta
            where co.idiglesia = ? and year(co.co_fecha) = ? and month(co.co_fecha) = ? and cu.cu_codigo=? 
            GROUP by co.cuentabase, cu.cu_codigo, cu.cu_cuenta
            order by mov,cod,fecha";
        
        $st = $this->db->query($query,  $params);

        return $st->getResultArray();
    }

}