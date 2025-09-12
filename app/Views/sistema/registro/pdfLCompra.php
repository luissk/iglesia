<?php
$arr_meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"];

$mes_anio = $arr_meses[$mes - 1]. " - ".$anio;
?>

<!doctype html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>REPORTE DE LIBRO DE COMPRAS</title>

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
                <th width="70%" align="left" style="font-size: 12px;">
                    <?=session('iglesia')?>
                </th>
                <th width="30%" align="right" style="font-size: 22px;">
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
        <h3 align="center">Reporte de Libro de Compras</h3>
        <div>
            <table width="100%" cellspacing="0" cellpadding="5">
                <thead>
                    <tr bgcolor="#dedede">
                        <th width="9%">Fecha</th>
                        <th width="9%">Ruc</th>
                        <th width="35%">Proveedor</th>
                        <th width="23%">Glosa</th>
                        <th width="8%">V. Venta</th>
                        <th width="8%">IGV</th>
                        <th width="8%">Total</th>
                    </tr>
                </thead>
                <?php               
                $subt_t  = 0;
                $igv_t   = 0;
                $total_t = 0;
                foreach($registros as $r){
                    $fecha = $r['co_fecha'];
                    $ruc   = $r['pr_ruc'];
                    $razon = $r['pr_razon'];
                    $glosa = $r['co_glosa'];
                    $subt  = $r['co_subt'];
                    $igv   = $r['co_igv'];
                    $total = $r['co_total'];

                    $subt_t  += $subt;
                    $igv_t   += $igv;
                    $total_t += $total;

                    echo "<tr>";
                    echo "<td align='center'>$fecha</td>";
                    echo "<td>$ruc</td>";
                    echo "<td>$razon</td>";
                    echo "<td>$glosa</td>";
                    echo "<td align='right'>".number_format($subt, 2, ".", ",")."</td>";
                    echo "<td align='right'>".number_format($igv, 2, ".", ",")."</td>";
                    echo "<td align='right'>".number_format($total, 2, ".", ",")."</td>";
                    echo "</tr>";
                }
                ?>
                <tr bgcolor="#dedede">
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th align="right"><?=number_format($subt_t,2,".",",")?></th>
                    <th align="right"><?=number_format($igv_t,2,".",",")?></th>
                    <th align="right"><?=number_format($total_t,2,".",",")?></th>
                </tr>
            </table>
        </div>

    </section>
</body>
</html>