<?php
$arr_meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"];

$mes_anio = $arr_meses[$mes - 1]. " - ".$anio;
?>

<!doctype html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>REPORTE</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
        color: #333;
    }
    @page { 
        margin: 80px 50px 80px 60px;
    }
    header {
        position: fixed;
        top: -50px;
        left: 0px;
        right: 0px;
        height: 30px;

        /** Extra personal styles **/
        text-align: center;
        border-bottom: 2px solid #444;
        /* background-color: red; */
    }

    footer {
        position: fixed; 
        bottom: -60px; 
        left: 0px; 
        right: 0px;
        height: 50px; 

        /** Extra personal styles **/
        border-top: 2px solid #444;
        text-align: center;
        line-height: 2;
        font-size: 13px;
    }

    .pagenum:before {
        content: counter(page);
    }

    .cuerpo_tablas table tr td{
        border: 1px solid #dedede;
    }

    .saldos{text-align: right;}
    .saldos b{
        background-color: #dedede;
        padding: 6px;
    }
</style>

</head>
<body>
    <header>
        Libro de Caja "<?=session('iglesia')?>"
    </header>
    <footer>
        <table width="100%">
            <tr>
                <td align="right">página <span class="pagenum"></span></td>
            </tr>
        </table>
    </footer>

    <section style='font-size:12px' class="cuerpo_tablas">
        <div class="saldos">
            <b>Saldo Anterior: S/. <?=$saldos['saldo_inicial']?></b>
        </div>
        <br>
        <div>
            <table width="100%" cellspacing="0" cellpadding="5">
                <thead>
                <tr>
                    <th colspan="5" bgcolor="#87e1eb">INGRESOS (<?=$mes_anio?>)</th>
                </tr>
                <tr bgcolor="#dedede">
                    <th width="10%">Fecha</th>
                    <th width="5%">Cod</th>
                    <th width="27%">Cuenta</th>
                    <th width="40%">Descripción</th>
                    <th width="13%">Importe (S/.)</th>
                </tr>
                </thead>
                <?php               
                // Variables para rastrear el grupo anterior (PARA AGRUPAR LAS FILAS CUANDO SE REPITE LA FECHA Y EL CODIGO)
                $fecha_anterior     = null;
                $codcuenta_anterior = null;

                $total_i = 0;
                foreach($registros_i as $ing){
                    $fecha_i   = date("d/m/Y", strtotime($ing['re_fecha']));
                    $cod_i     = $ing['cu_codigo'];
                    $cuenta_i  = $ing['cu_cuenta'];
                    $desc_i    = $ing['re_desc'];
                    $importe_i = $ing['re_importe'];

                    $total_i += $importe_i;

                    $fecha_actual     = $fecha_i;
                    $codcuenta_actual = $cod_i;

                    echo "<tr>";

                    // Si la fecha o la cuenta cambian, mostrar los valores
                    if ($fecha_actual != $fecha_anterior || $codcuenta_actual != $codcuenta_anterior) {
                        echo "<td>$fecha_actual</td>";
                        echo "<td>$cod_i</td>";
                        echo "<td>$cuenta_i</td>";
                    }else{
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                    }

                    echo "<td>$desc_i</td>";
                    echo "<td align='right'>$importe_i</td>";
                    echo "</tr>";

                    $fecha_anterior     = $fecha_actual;
                    $codcuenta_anterior = $codcuenta_actual;
                }
                ?>
                <tr bgcolor="#dedede">
                    <th colspan="4" align="right">TOTAL (S/.)</th>
                    <th align="right"><?=$total_i?></th>
                </tr>
            </table>
        </div>

        <br><br>

        <div>
            <table width="100%" cellspacing="0" cellpadding="5">
                <thead>
                <tr>
                    <th colspan="5" bgcolor="#f6f86f">EGRESOS (<?=$mes_anio?>)</th>
                </tr>
                <tr bgcolor="#dedede">
                    <th width="10%">Fecha</th>
                    <th width="5%">Cod</th>
                    <th width="27%">Cuenta</th>
                    <th width="40%">Descripción</th>
                    <th width="13%">Importe (S/.)</th>
                </tr>
                </thead>
                <?php
                // Variables para rastrear el grupo anterior (PARA AGRUPAR LAS FILAS CUANDO SE REPITE LA FECHA Y EL CODIGO)
                $fecha_anterior     = null;
                $codcuenta_anterior = null;

                $total_e = 0;
                foreach($registros_e as $egr){
                    $fecha_e   = date("d/m/Y", strtotime($egr['re_fecha']));
                    $cod_e     = $egr['cu_codigo'];
                    $cuenta_e  = $egr['cu_cuenta'];
                    $desc_e    = $egr['re_desc'];
                    $importe_e = $egr['re_importe'];

                    $total_e += $importe_e;

                    $fecha_actual     = $fecha_e;
                    $codcuenta_actual = $cod_e;

                    echo "<tr>";

                    if ($fecha_actual != $fecha_anterior || $codcuenta_actual != $codcuenta_anterior) {
                        echo "<td>$fecha_e</td>";
                        echo "<td>$cod_e</td>";
                        echo "<td>$cuenta_e</td>";
                    }else{
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                    }
                    echo "<td>$desc_e</td>";
                    echo "<td align='right'>$importe_e</td>";
                    echo "</tr>";

                    $fecha_anterior     = $fecha_actual;
                    $codcuenta_anterior = $codcuenta_actual;
                }
                ?>
                <tr bgcolor="#dedede">
                    <th colspan="4" align="right">TOTAL (S/.)</th>
                    <th align="right"><?=$total_e?></th>
                </tr>
            </table>
        </div>
        <br>
        <div class="saldos">
            <b>Saldo Final: S/. <?=$saldos['saldo_final']?></b>
        </div>

        <?php
       /*  echo "<pre>";
        print_r($saldos);

        print_r($registros_i);

        print_r($registros_e);
        echo "</pre>"; */
        ?>

    </section>
</body>
</html>