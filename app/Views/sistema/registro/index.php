<?php echo $this->extend('plantilla/layout')?>

<?php echo $this->section('contenido');?>

<div class="app-content mt-4">
    <div class="container-fluid">

        <div class="card card-danger card-outline card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#libroCaja">LIBRO DE CAJAS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#libroCompras">LIBRO DE COMPRAS</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">

                    <div class="tab-pane active" id="libroCaja">
                        <div class="row">
                            <div class="col-sm-6 d-flex align-items-center">
                                <h5 class="mb-0">Registros Libro de Cajas</h5>
                            </div>
                            <div class="col-sm-6 text-end">
                                <a class="btn btn-warning" role="button" id="btnModalLCaja">Nuevo Registro L. Caja</a>
                            </div>
                        </div>
                        <div class="row table-responsive mt-3" id="">
                            <table id="tblLibroCaja" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Imp (S/.)</th>
                                        <th>Concepto</th>
                                        <th>Caja</th>
                                        <th>Cod</th>
                                        <th>Cuenta</th>
                                        <th>Mov</th>
                                        <th>Opción</th>
                                    </tr>
                                </thead>
                                <tbody>                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="libroCompras">
                        <div class="row">
                            <div class="col-sm-6 d-flex align-items-center">
                                <h5 class="mb-0">Registros Libro de Compras</h5>
                            </div>
                            <div class="col-sm-6 text-end">
                                <a class="btn btn-warning" role="button" data-bs-toggle="modal" data-bs-target="#modalLCompras">Nuevo Registro L. Compra</a>
                            </div>
                        </div>
                        <div class="row table-responsive mt-3" id="">
                            <table id="tblLibroCompra" class="table table-striped">
                                <thead>
                                    <tr>
                                        <!-- <th>#</th> -->
                                        <th>Fecha</th>
                                        <th>Importe (S/.)</th>
                                        <th>Concepto</th>
                                        <th>Caja</th>                                        
                                        <th>Cuenta</th>
                                        <th>Mov</th>
                                        <th>Opción</th>
                                    </tr>
                                </thead>
                                <tbody>                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

    </div>
</div>


<div id="msj"></div>

<div class="modal fade" id="modalLCaja" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLCajaLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 650px;">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h1 class="modal-title fs-5" id="tituloModal">Formulario Libro de Caja</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body" id="divLCompra"></div>
            </div>
        </div>
    </div>
</div>

<div class="app-content mt-4">
    <div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
<?php

// El array de datos que proporcionaste
$registro = array(
  array('idregistro' => '1','re_fecha' => '2025-05-02','re_importe' => '16.00','re_desc' => 'Ofrenda recogida','us_creador' => '2','idcuenta' => '24','idresponsable_caja' => '1','re_mov' => '1','tipo_mov' => 'Ingreso','us_nombre' => 'Juana Juarez De La Cruz','idiglesia' => '4','ig_iglesia' => 'Iglesia Monte de Sión - Sintuco','ig_direccion' => 'Calle Bolivar 123 - Chocope,  Ascope, La Libertad','ig_pastor' => 'Alipio Avila Valencia','cu_dh' => 'Haber','cu_codigo' => '753','cu_cuenta' => 'Ofrenda recogida','cu_observacion' => 'Ofrenda recogida','re_nombres' => 'Juana Juarez De La Cruz','ca_caja' => 'Principal'),
  array('idregistro' => '2','re_fecha' => '2025-05-03','re_importe' => '300.00','re_desc' => 'Pasajes mes Pastor Alipio','us_creador' => '2','idcuenta' => '10','idresponsable_caja' => '1','re_mov' => '2','tipo_mov' => 'Egreso','us_nombre' => 'Juana Juarez De La Cruz','idiglesia' => '4','ig_iglesia' => 'Iglesia Monte de Sión - Sintuco','ig_direccion' => 'Calle Bolivar 123 - Chocope,  Ascope, La Libertad','ig_pastor' => 'Alipio Avila Valencia','cu_dh' => 'Debe','cu_codigo' => '631','cu_cuenta' => 'Transporte y gastos de viaje','cu_observacion' => 'Gastos por movilidad, pasajes','re_nombres' => 'Juana Juarez De La Cruz','ca_caja' => 'Principal'),
  array('idregistro' => '3','re_fecha' => '2025-05-06','re_importe' => '30.00','re_desc' => 'Julia Juárez','us_creador' => '2','idcuenta' => '22','idresponsable_caja' => '1','re_mov' => '1','tipo_mov' => 'Ingreso','us_nombre' => 'Juana Juarez De La Cruz','idiglesia' => '4','ig_iglesia' => 'Iglesia Monte de Sión - Sintuco','ig_direccion' => 'Calle Bolivar 123 - Chocope,  Ascope, La Libertad','ig_pastor' => 'Alipio Avila Valencia','cu_dh' => 'Haber','cu_codigo' => '751','cu_cuenta' => 'Diezmo actual','cu_observacion' => 'Diezmo actual','re_nombres' => 'Juana Juarez De La Cruz','ca_caja' => 'Principal'),
  array('idregistro' => '4','re_fecha' => '2025-05-06','re_importe' => '363.00','re_desc' => 'Leonel Cueva','us_creador' => '2','idcuenta' => '22','idresponsable_caja' => '1','re_mov' => '1','tipo_mov' => 'Ingreso','us_nombre' => 'Juana Juarez De La Cruz','idiglesia' => '4','ig_iglesia' => 'Iglesia Monte de Sión - Sintuco','ig_direccion' => 'Calle Bolivar 123 - Chocope,  Ascope, La Libertad','ig_pastor' => 'Alipio Avila Valencia','cu_dh' => 'Haber','cu_codigo' => '751','cu_cuenta' => 'Diezmo actual','cu_observacion' => 'Diezmo actual','re_nombres' => 'Juana Juarez De La Cruz','ca_caja' => 'Principal'),
  array('idregistro' => '5','re_fecha' => '2025-03-01','re_importe' => '3000.00','re_desc' => 'saldo inicial de la iglesia monte de sion','us_creador' => '2','idcuenta' => '30','idresponsable_caja' => '1','re_mov' => '1','tipo_mov' => 'Ingreso','us_nombre' => 'Juana Juarez De La Cruz','idiglesia' => '4','ig_iglesia' => 'Iglesia Monte de Sión - Sintuco','ig_direccion' => 'Calle Bolivar 123 - Chocope,  Ascope, La Libertad','ig_pastor' => 'Alipio Avila Valencia','cu_dh' => 'Haber','cu_codigo' => '140','cu_cuenta' => 'Saldo Inicial','cu_observacion' => 'Saldo inicial de las iglesias','re_nombres' => 'Juana Juarez De La Cruz','ca_caja' => 'Principal'),
  array('idregistro' => '6','re_fecha' => '2025-03-03','re_importe' => '150.00','re_desc' => 'ofrendas','us_creador' => '2','idcuenta' => '25','idresponsable_caja' => '1','re_mov' => '1','tipo_mov' => 'Ingreso','us_nombre' => 'Juana Juarez De La Cruz','idiglesia' => '4','ig_iglesia' => 'Iglesia Monte de Sión - Sintuco','ig_direccion' => 'Calle Bolivar 123 - Chocope,  Ascope, La Libertad','ig_pastor' => 'Alipio Avila Valencia','cu_dh' => 'Haber','cu_codigo' => '754','cu_cuenta' => 'Ofrenda misionera','cu_observacion' => 'Ofrenda misionera','re_nombres' => 'Juana Juarez De La Cruz','ca_caja' => 'Principal'),
  array('idregistro' => '7','re_fecha' => '2025-03-05','re_importe' => '120.50','re_desc' => 'ofrendas','us_creador' => '2','idcuenta' => '25','idresponsable_caja' => '1','re_mov' => '1','tipo_mov' => 'Ingreso','us_nombre' => 'Juana Juarez De La Cruz','idiglesia' => '4','ig_iglesia' => 'Iglesia Monte de Sión - Sintuco','ig_direccion' => 'Calle Bolivar 123 - Chocope,  Ascope, La Libertad','ig_pastor' => 'Alipio Avila Valencia','cu_dh' => 'Haber','cu_codigo' => '754','cu_cuenta' => 'Ofrenda misionera','cu_observacion' => 'Ofrenda misionera','re_nombres' => 'Juana Juarez De La Cruz','ca_caja' => 'Principal'),
  array('idregistro' => '8','re_fecha' => '2025-03-05','re_importe' => '200.00','re_desc' => 'capacitacion al sistema','us_creador' => '2','idcuenta' => '8','idresponsable_caja' => '1','re_mov' => '2','tipo_mov' => 'Egreso','us_nombre' => 'Juana Juarez De La Cruz','idiglesia' => '4','ig_iglesia' => 'Iglesia Monte de Sión - Sintuco','ig_direccion' => 'Calle Bolivar 123 - Chocope,  Ascope, La Libertad','ig_pastor' => 'Alipio Avila Valencia','cu_dh' => 'Debe','cu_codigo' => '624','cu_cuenta' => 'Capacitación','cu_observacion' => 'Gastos por Capacitación','re_nombres' => 'Juana Juarez De La Cruz','ca_caja' => 'Principal'),
  array('idregistro' => '9','re_fecha' => '2025-03-20','re_importe' => '80.00','re_desc' => 'atencion a visitantes de iglesias','us_creador' => '2','idcuenta' => '9','idresponsable_caja' => '4','re_mov' => '2','tipo_mov' => 'Egreso','us_nombre' => 'Juana Juarez De La Cruz','idiglesia' => '4','ig_iglesia' => 'Iglesia Monte de Sión - Sintuco','ig_direccion' => 'Calle Bolivar 123 - Chocope,  Ascope, La Libertad','ig_pastor' => 'Alipio Avila Valencia','cu_dh' => 'Debe','cu_codigo' => '625','cu_cuenta' => 'Atención a Visitantes','cu_observacion' => 'Refrigerio a Pastores y otros','re_nombres' => 'Digna Flores','ca_caja' => 'Música'),
  array('idregistro' => '10','re_fecha' => '2025-03-23','re_importe' => '2.20','re_desc' => 'ofrenda de niños','us_creador' => '2','idcuenta' => '27','idresponsable_caja' => '6','re_mov' => '1','tipo_mov' => 'Ingreso','us_nombre' => 'Juana Juarez De La Cruz','idiglesia' => '4','ig_iglesia' => 'Iglesia Monte de Sión - Sintuco','ig_direccion' => 'Calle Bolivar 123 - Chocope,  Ascope, La Libertad','ig_pastor' => 'Alipio Avila Valencia','cu_dh' => 'Haber','cu_codigo' => '756','cu_cuenta' => 'Ofrenda niños E. dominical','cu_observacion' => 'Ofrenda niños E. dominical','re_nombres' => 'Raquel Uceda','ca_caja' => 'Evangelismo'),
  array('idregistro' => '11','re_fecha' => '2025-04-01','re_importe' => '100.00','re_desc' => 'Raquel Uceda - diezmo de marzo','us_creador' => '2','idcuenta' => '23','idresponsable_caja' => '1','re_mov' => '1','tipo_mov' => 'Ingreso','us_nombre' => 'Juana Juarez De La Cruz','idiglesia' => '4','ig_iglesia' => 'Iglesia Monte de Sión - Sintuco','ig_direccion' => 'Calle Bolivar 123 - Chocope,  Ascope, La Libertad','ig_pastor' => 'Alipio Avila Valencia','cu_dh' => 'Haber','cu_codigo' => '752','cu_cuenta' => 'Diezmo anterior','cu_observacion' => 'Diezmo anterior','re_nombres' => 'Juana Juarez De La Cruz','ca_caja' => 'Principal'),
  array('idregistro' => '12','re_fecha' => '2025-04-04','re_importe' => '150.00','re_desc' => 'Alberto Oriz - diezmo','us_creador' => '2','idcuenta' => '22','idresponsable_caja' => '1','re_mov' => '1','tipo_mov' => 'Ingreso','us_nombre' => 'Juana Juarez De La Cruz','idiglesia' => '4','ig_iglesia' => 'Iglesia Monte de Sión - Sintuco','ig_direccion' => 'Calle Bolivar 123 - Chocope,  Ascope, La Libertad','ig_pastor' => 'Alipio Avila Valencia','cu_dh' => 'Haber','cu_codigo' => '751','cu_cuenta' => 'Diezmo actual','cu_observacion' => 'Diezmo actual','re_nombres' => 'Juana Juarez De La Cruz','ca_caja' => 'Principal'),
  array('idregistro' => '13','re_fecha' => '2025-04-16','re_importe' => '50.00','re_desc' => 'compra de flores','us_creador' => '2','idcuenta' => '16','idresponsable_caja' => '1','re_mov' => '2','tipo_mov' => 'Egreso','us_nombre' => 'Juana Juarez De La Cruz','idiglesia' => '4','ig_iglesia' => 'Iglesia Monte de Sión - Sintuco','ig_direccion' => 'Calle Bolivar 123 - Chocope,  Ascope, La Libertad','ig_pastor' => 'Alipio Avila Valencia','cu_dh' => 'Debe','cu_codigo' => '656','cu_cuenta' => 'Compra de flores para el Altar','cu_observacion' => 'Compra Flores para el altar','re_nombres' => 'Juana Juarez De La Cruz','ca_caja' => 'Principal'),
  array('idregistro' => '14','re_fecha' => '2025-04-29','re_importe' => '85.00','re_desc' => 'clases de canto','us_creador' => '2','idcuenta' => '8','idresponsable_caja' => '4','re_mov' => '2','tipo_mov' => 'Egreso','us_nombre' => 'Juana Juarez De La Cruz','idiglesia' => '4','ig_iglesia' => 'Iglesia Monte de Sión - Sintuco','ig_direccion' => 'Calle Bolivar 123 - Chocope,  Ascope, La Libertad','ig_pastor' => 'Alipio Avila Valencia','cu_dh' => 'Debe','cu_codigo' => '624','cu_cuenta' => 'Capacitación','cu_observacion' => 'Gastos por Capacitación','re_nombres' => 'Digna Flores','ca_caja' => 'Música'),
  array('idregistro' => '15','re_fecha' => '2025-04-29','re_importe' => '12.00','re_desc' => 'clases de canto','us_creador' => '2','idcuenta' => '24','idresponsable_caja' => '1','re_mov' => '1','tipo_mov' => 'Ingreso','us_nombre' => 'Juana Juarez De La Cruz','idiglesia' => '4','ig_iglesia' => 'Iglesia Monte de Sión - Sintuco','ig_direccion' => 'Calle Bolivar 123 - Chocope,  Ascope, La Libertad','ig_pastor' => 'Alipio Avila Valencia','cu_dh' => 'Haber','cu_codigo' => '753','cu_cuenta' => 'Ofrenda recogida','cu_observacion' => 'Ofrenda recogida','re_nombres' => 'Juana Juarez De La Cruz','ca_caja' => 'Principal'),
  array('idregistro' => '16','re_fecha' => '2025-05-29','re_importe' => '106.00','re_desc' => 'Otros ingresos','us_creador' => '2','idcuenta' => '29','idresponsable_caja' => '7','re_mov' => '1','tipo_mov' => 'Ingreso','us_nombre' => 'Juana Juarez De La Cruz','idiglesia' => '4','ig_iglesia' => 'Iglesia Monte de Sión - Sintuco','ig_direccion' => 'Calle Bolivar 123 - Chocope,  Ascope, La Libertad','ig_pastor' => 'Alipio Avila Valencia','cu_dh' => 'Haber','cu_codigo' => '759','cu_cuenta' => 'Otros ingresos de Gestión','cu_observacion' => 'Aporte para gas, otros','re_nombres' => 'Evelyn Mesa','ca_caja' => 'Juventud')
);

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

<?php echo $this->endSection();?>

<?php echo $this->section('scripts');?>

<script>
    var $table1;
    var $table2;
$(function(){
    $table1 = $('#tblLibroCaja').dataTable({
        "ajax":{
            "url": 'lista-lcaja-dt',
            "dataSrc":"",
            "type": "POST",
            "data": {
                id:1
                //"desc": function() { return $('#desc').val() },
                //"fecha_ini": function() { return $('#fecha_ini').val() }, 
                //"fecha_fin": function() { return $('#fecha_fin').val() }
            },
            "complete": function(xhr, responseText){
                /* console.log(xhr);
                console.log(xhr.responseText); //*** responseJSON: Array[0] */
            }
        },
        "columns":[
            {"data": "re_fecha"},
            {"data": "re_importe"},
            {"data": "re_desc"},
            {"data": "ca_caja"},
            {"data": "cu_codigo"},
            {"data": "cu_cuenta"},
            {"data": "tipo_mov"},
            {"data": "idregistro",
                "mRender": function (data, type, row) {
                    //console.log(row);
                    return `
                    <a title='editar' class='link-success editar' role='button' data-id=${data}>
                        <i class='fa fa-edit'></i>
                    </a> 
                    <a title='eliminar' class='link-danger ms-1 eliminar' role='button' data-id=${data}>
                        <i class='fa fa-trash-alt'></i>
                    </a>`;
                }
            }
        ],
        "aaSorting": [[ 0, "desc" ]],
        "pageLength": 25
    });

    $('#btnModalLCaja').on('click', function(e){
        formLCaja();
    });

    $('#tblLibroCaja').on('click', '.editar', function(e){
        formLCaja($(this).data('id'))
    });

     $('#tblLibroCaja').on('click', '.eliminar', function(e){
        Swal.fire({
            title: "¿Estás seguro en eliminar el Registro?",
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('elimina-lcaja', {
                    id: $(this).data('id')
                }, function(data){
                    //console.log(data)
                    $('#msj').html(data);
                });
            }
        });        
    });



    $table2 = $('#tblLibroCompra').dataTable({
        "pageLength": 50
    });

   
});

function formLCaja(id = ''){
    $('#modalLCaja').modal('show');
    $('#divLCompra').html('Abriendo formulario...');
    $.post('formularioLCaja', {
        id
    }, function(data){
        //console.log(data)
        $('#divLCompra').html(data);
    });
}

function dataTableReload(opt = 1){
    if(opt == 1)
        $table1.DataTable().ajax.reload();
    else if(opt == 2)
        $table2.DataTable().ajax.reload()
}
</script>

<?php echo $this->endSection();?>