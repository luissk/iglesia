<?php


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
        margin: 170px 50px 80px 60px;
    }
    header {
        position: fixed;
        top: -140px;
        left: 0px;
        right: 0px;
        height: 120px;

        /** Extra personal styles **/
        text-align: center;
        border-bottom: 2px solid #444;

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

    .tablapdf thead tr th{
        background-color: #ddd;
        padding: 5px 0;
    }
    .tablapdf tbody tr td{
        padding: 5px;
        text-align: center;
        border: 1px solid #ddd;
    }
    .tablapdf tbody tr td.left{
        text-align: left;
    }
</style>

</head>
<body>
    <header>
        HEADER
    </header>
    <footer>
        <table width="100%">
            <tr>
                <td align="right">página <span class="pagenum"></span></td>
            </tr>
        </table>
    </footer>

    <section style='font-size:12px'>
        <div class="app-content mt-4">
    <div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
<?php

// El array de datos que proporcionaste
$registro = $registros;

$totales_por_grupo = [];

foreach ($registro as $fila) {
    // Creamos una clave única para el grupo
    $clave_grupo = $fila['re_fecha'] . '|' . $fila['cu_codigo'] . '|' . $fila['cu_cuenta'];
    
    // Si la clave no existe, la inicializamos en 0
    if (!isset($totales_por_grupo[$clave_grupo])) {
        $totales_por_grupo[$clave_grupo] = 0;
    }
    
    // Sumamos el importe a la clave del grupo
    $totales_por_grupo[$clave_grupo] += floatval($fila['re_importe']);
}

// Ahora $totales_por_grupo contiene los totales correctos para cada grupo
// print_r($totales_por_grupo);
/* Ejemplo de salida:
Array
(
    [2025-05-02|753|Ofrenda recogida] => 16
    [2025-05-03|631|Transporte y gastos de viaje] => 300
    [2025-05-06|751|Diezmo actual] => 393 // <- El total de 30 + 363
    // ...
)
*/


// ... (El código de la primera parte debe ir aquí para que $totales_por_grupo exista)

$grupo_anterior = null;

echo '<table class="table">';
echo '<tr><th>Fecha</th><th>Código</th><th>Cuenta</th><th>Descripción</th><th>Total Grupo</th></tr>';

foreach ($registro as $fila) {
    $clave_grupo = $fila['re_fecha'] . '|' . $fila['cu_codigo'] . '|' . $fila['cu_cuenta'];
    
    // Verificamos si este es un nuevo grupo
    if ($clave_grupo != $grupo_anterior) {
        // Mostramos la fila con la información del grupo y el total
        echo '<tr>';
        echo '<td>' . $fila['re_fecha'] . '</td>';
        echo '<td>' . $fila['cu_codigo'] . '</td>';
        echo '<td>' . $fila['cu_cuenta'] . '</td>';
        echo '<td>' . $fila['re_desc'] . '</td>';
        echo '<td>' . number_format($totales_por_grupo[$clave_grupo], 2) . '</td>';
        echo '</tr>';
    } else {
        // Si es el mismo grupo, mostramos la fila con celdas vacías para el grupo
        echo '<tr>';
        echo '<td></td>'; // Celda vacía para la fecha
        echo '<td></td>'; // Celda vacía para el código
        echo '<td></td>'; // Celda vacía para la cuenta
        echo '<td>' . $fila['re_desc'] . '</td>';
        echo '<td></td>'; // Celda vacía para el total
        echo '</tr>';
    }
    
    // Actualizamos el grupo anterior para la próxima iteración
    $grupo_anterior = $clave_grupo;
}

echo '</table>';

?>
</div>
</div>
</div>
</div>
    </section>
</body>
</html>