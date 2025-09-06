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
        <table width="100%">
            <tr>
                <th width="75%" align="left" style="font-size: 12px;">
                    <?=session('iglesia')?>
                </th>
                <th width="25%" align="right" style="font-size: 22px;">
                    <?=$mes_anio?>
                </th>
            </tr>
        </table>        
    </header>

    <footer>
        <table width="100%">
            <tr>
                <td align="right">página <span class="pagenum"></span></td>
            </tr>
        </table>
    </footer>

    <section style='font-size:12px' class="cuerpo_tablas">
        <div>
            <table width="100%" cellspacing="0" cellpadding="5">
                <thead>
                    <tr>
                        <th align="left" colspan="5" style="font-size: 24px; color: #e74c3c">Debe</th>
                    </tr>
                    <tr bgcolor="#dedede">
                        <th width="5%">Día</th>
                        <th width="5%">Cod</th>
                        <th width="30%">Cuenta</th>
                        <th width="42%">Descripción</th>
                        <th width="13%">Importe (S/.)</th>
                    </tr>
                </thead>
                <tr style="font-weight: bolder;">
                    <td align="center">01</td>
                    <td></td>
                    <td colspan="2">SALDO ANTERIOR</td>
                    <td align="right"><?=number_format($saldos['saldo_inicial'],2,".",",")?></td>
                </tr>
                <?php               
                $total_i = 0;
                foreach($registros_i as $ing){
                    $fecha_i    = date("d", strtotime($ing['re_fecha']));
                    $cod_i      = $ing['cu_codigo'];
                    $cuenta_i   = $ing['cu_cuenta'];
                    $desc_i     = $ing['re_desc'];
                    $importe_i  = $ing['re_importe'];
                    $idcuenta_i = $ing['idcuenta'];

                    $total_i += $importe_i;

                    echo "<tr>";
                    echo "<td align='center'>$fecha_i</td>";
                    echo "<td>$cod_i</td>";
                    echo "<td>$cuenta_i</td>";
                    echo "<td>$desc_i</td>";
                    echo "<td align='right'>".number_format($ing['re_importe'], 2, ".", ",")."</td>";
                    echo "</tr>";
                }
                ?>
                <tr bgcolor="#dedede">
                    <th colspan="4" align="right">INGRESOS DEL MES (S/.)</th>
                    <th align="right"><?=number_format($total_i,2,".",",")?></th>
                </tr>
            </table>
        </div>

        <div style="page-break-after:always;"></div>

        <div>
            <table width="100%" cellspacing="0" cellpadding="5">
                <thead>
                    <tr>
                        <th align="right" colspan="5" style="font-size: 24px; color: #e74c3c">Haber</th>
                    </tr>
                    <tr bgcolor="#dedede">
                        <th width="5%">Día</th>
                        <th width="5%">Cod</th>
                        <th width="30%">Cuenta</th>
                        <th width="42%">Descripción</th>
                        <th width="13%">Importe (S/.)</th>
                    </tr>
                </thead>
                <?php
                $total_e = 0;
                foreach($registros_e as $egr){
                    $fecha_e   = date("d", strtotime($egr['re_fecha']));
                    $cod_e     = $egr['cu_codigo'];
                    $cuenta_e  = $egr['cu_cuenta'];
                    $desc_e    = $egr['re_desc'];
                    $importe_e = $egr['re_importe'];

                    $total_e += $importe_e;

                    echo "<tr>";
                    echo "<td align='center'>$fecha_e</td>";
                    echo "<td>$cod_e</td>";
                    echo "<td>$cuenta_e</td>";
                    echo "<td>$desc_e</td>";
                    echo "<td align='right'>".number_format($importe_e,2,".",",")."</td>";
                    echo "</tr>";
                }
                ?>
                <tr bgcolor="#dedede">
                    <th colspan="4" align="right">EGRESOS DEL MES (S/.)</th>
                    <th align="right"><?=number_format($total_e,2,".",",")?></th>
                </tr>
            </table>
        </div>
        <br>
        <div class="saldos">
            <b>SALDO PROXIMO MES: S/. <?=number_format($saldos['saldo_final'],2,".",",")?></b>
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