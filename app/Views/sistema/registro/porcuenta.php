<?php
/* echo "<pre>";
print_r($movimientos);
echo "</pre>"; */
if( $movimientos ){
?>
    <table id="tblLibroCaja" class="table table-striped">
    <thead>
        <tr>
            <th>TIPO</th>
            <th>COD</th>
            <th>CUENTA</th>
            <th>IMPORTE</th>
            <th>GLOSA</th>
            <th>FECHA</th>
            <th>CAJA</th>
            <th>COMPROB.</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach( $movimientos as $m ){
            $mov     = $m['mov'];
            $cod     = $m['cod'];
            $cuen    = $m['cuen'];
            $importe = $m['importe'];
            $glosa   = $m['glosa'];
            $fecha   = $m['fecha'];
            $caja    = $m['caja'];
            $factura = $m['factura'];

            $tipobd = $m['tipo']; //1:compra, 2:venta

            $tipo = '';
            if( ($mov == 1 || $mov == 2) && $factura == '' ){
                if( $mov == 1 ) $tipo = "INGRESO";
                if( $mov == 2 ) $tipo = "EGRESO";
            }else if( $mov == 2 && $factura != '' ){
                if( $tipobd == 1 ) $tipo = "COMPRA";
                else if( $tipobd == 2 ) $tipo = "VENTA";
                
            }

            echo "<tr>";
            echo "<td>$tipo</td>";
            echo "<td>$cod</td>";
            echo "<td>$cuen</td>";
            echo "<td>$importe</td>";
            echo "<td>$glosa</td>";
            echo "<td>$fecha</td>";
            echo "<td>$caja</td>";
            echo "<td>$factura</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
<?php
}else{
    echo "NO SE ENCONTRARON DATOS";
}
?>