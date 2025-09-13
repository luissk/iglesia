<?php
$arr_meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"];

$mes_anio = $arr_meses[$mes - 1]. " - ".$anio;

// Arrays para almacenar datos procesados y sumas
$mov1_procesado = [];
$mov2_procesado = [];
$sum_mov1 = 0;
$sum_mov2 = 0;

// Procesar el array $registros
foreach ($registros as $item) {
    $cod = $item['cod'];
    $importe = floatval($item['importe']); // Asegurarnos de que el importe sea un número
    $cuen = $item['cuen'];
    $mov = $item['mov'];

    if ($mov === '1') {
        // Si el código ya existe en mov1, sumar el importe
        if (isset($mov1_procesado[$cod])) {
            $mov1_procesado[$cod]['importe'] += $importe;
        } else {
            // Si no existe, crearlo
            $mov1_procesado[$cod] = [
                'cod' => $cod,
                'cuen' => $cuen,
                'importe' => $importe
            ];
        }
        $sum_mov1 += $importe; // Acumular suma total para mov1
    } elseif ($mov === '2') {
        // Si el código ya existe en mov2, sumar el importe
        if (isset($mov2_por_cod[$cod])) { // ¡CORREGIDO! Ahora usa $mov2_por_cod
            $mov2_por_cod[$cod]['importe'] += $importe;
        } else {
            // Si no existe, crearlo
            $mov2_por_cod[$cod] = [
                'cod' => $cod,
                'cuen' => $cuen, // Guardar el nombre de la cuenta también para mov2
                'importe' => $importe
            ];
        }
        $sum_mov2 += $importe; // Acumular suma total para mov2
    }
}

// Obtener una lista única y ordenada de todos los códigos
// Usamos los códigos de los arrays procesados para asegurar que todos los códigos se muestren
$todos_los_codigos = array_unique(array_merge(array_keys($mov1_procesado), array_keys($mov2_por_cod)));
sort($todos_los_codigos);
?>

<!doctype html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>REPORTE DE LIBRO DIARIO</title>

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
        <h3 align="center">Reporte de Libro Diario</h3>
        <div>
            <table width="100%" cellspacing="0" cellpadding="5">
                <thead>
                    <tr bgcolor="#dedede">
                        <th>COD</th>
                        <th>CUENTA</th>
                        <th>DEBE</th>
                        <th>HABER</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style='font-weight:bold'>
                        <td align="center">101</td>
                        <td>Caja</td>
                        <td class='saldos'><?php echo number_format($sum_mov1, 2); ?></td>
                        <td class='saldos'><?php echo number_format($sum_mov2, 2); ?></td>                        
                    </tr>
                    <?php
                    foreach ($todos_los_codigos as $cod) {
                        echo "<tr>";
                        
                        // Columna de Código
                        echo "<td align='center'>" . htmlspecialchars($cod) . "</td>";

                        // Columna de Cuenta
                        $cuenta_nombre = '';
                        // Priorizar la cuenta de mov1 si existe, si no, tomar la de mov2
                        if (isset($mov1_procesado[$cod]['cuen'])) {
                            $cuenta_nombre = $mov1_procesado[$cod]['cuen'];
                        } elseif (isset($mov2_por_cod[$cod]['cuen'])) {
                            $cuenta_nombre = $mov2_por_cod[$cod]['cuen'];
                        }
                        echo "<td>" . htmlspecialchars($cuenta_nombre) . "</td>";
                        
                        // Columna de Importe Movimiento 2
                        if (isset($mov2_por_cod[$cod])) {
                            echo "<td align='right'>" . htmlspecialchars(number_format($mov2_por_cod[$cod]['importe'], 2)) . "</td>";
                        } else {
                            echo "<td></td>";
                        }

                        // Columna de Importe Movimiento 1
                        if (isset($mov1_procesado[$cod])) {
                            echo "<td align='right'>" . htmlspecialchars(number_format($mov1_procesado[$cod]['importe'], 2)) . "</td>";
                        } else {
                            echo "<td></td>";
                        }

                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </section>
</body>
</html>