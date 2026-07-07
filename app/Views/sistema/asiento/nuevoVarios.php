<?php echo $this->extend('plantilla/layout')?>

<?php echo $this->section('contenido');?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

<?php
$cuenta_arr = $cuentas;

if( isset($asiento_bd) && $asiento_bd ){
    /* echo "<pre>";
    print_r($asiento_bd);
    print_r($deta_bd);
    echo "</pre>"; */

    $idasiento_bd = $asiento_bd['idasiento'];
    $fecha_bd     = $asiento_bd['as_fecha'];
    $nrodoc_bd    = $asiento_bd['as_nrodoc'];
    $desc_bd      = $asiento_bd['as_desc'];
    $totald_bd    = $asiento_bd['as_totald'];
    $totalh_bd    = $asiento_bd['as_totalh'];

    $btn_title = "MODIFICAR ASIENTO";

}else{
    $idasiento_bd = "";
    $fecha_bd     = date('Y-m-d');
    $nrodoc_bd    = "";
    $desc_bd      = "";
    $totald_bd    = "";
    $totalh_bd    = "";

    $btn_title = "REGISTRAR ASIENTO";
}
?>

<div class="app-content mt-4">
    <div class="container-fluid">
        <form id="frmAsiento">
        <div class="card card-danger card-outline">
            <div class="card-header pt-1 pb-0 border-bottom-1">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="">REGISTRO DE ASIENTO</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">                    
                    <div class="col-sm-3">
                        <label for="fecha" class="form-label fw-semibold">Ingrese una fecha</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" value="<?=$fecha_bd?>">
                        <div id="msj-fecha" class="form-text text-danger"></div>
                    </div>
                    <div class="col-sm-2">
                        <label for="documento" class="form-label fw-semibold">Nro Documento</label>
                        <input type="text" class="form-control" id="documento" name="documento" value="<?=$nrodoc_bd?>" placeholder="F-1-120" maxlength="13">
                        <div id="msj-documento" class="form-text text-danger"></div>
                    </div>
                    <div class="col-sm-12">
                        &nbsp;
                    </div>
                    <div class="col-sm-6">
                        <label for="desc" class="form-label fw-semibold">Glosa / Descripción</label>
                        <input type="text" class="form-control" id="desc" name="desc" value="<?=$desc_bd?>" placeholder="" maxlength="100" autocomplete="off">
                        <div id="msj-desc" class="form-text text-danger"></div>
                    </div>
                    <div class="col-sm-3 d-flex align-items-end pb-2">
                        <a class="btn btn-outline-success btn-sm" id="btnAgregarLinea">+ Nueva Linea</a>
                    </div>                    
                </div>                

                <div class="row mt-4">
                    <div class="col-sm-12">
                        <h4 class="mb-3 text-center border-bottom border-3 border-warning">Detalle del Asiento</h4>
                    </div>

                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th class="cuenta-col">Cuenta Contable</th>
                                <th class="monto-col text-end">Debe</th>
                                <th class="monto-col text-end">Haber</th>
                                <th style="width: 5%;"></th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo-lineas">
                            </tbody>
                        <tfoot>
                            <tr class="table-info">
                                <th>Total</th>
                                <th id="total-debe" class="text-end">0.00</th>
                                <th id="total-haber" class="text-end">0.00</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12 text-end">
                <input type="hidden" name="idasiento" value="<?=$idasiento_bd?>">
                <button class="btn btn-primary" id="btnGuardarAsiento"><?=$btn_title?></button>
            </div>
        </div>
        </form>
    </div>

    <div id="msj"></div>

    <select id="select-cuentas-template" style="display: none;">
    </select>
</div>

<div class="modal fade" id="modalProveedor" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalProveedorLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 650px;">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h1 class="modal-title fs-5" id="tituloModal">Proveedores</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                    <form id="frmProveedor">
                    <div class="row bg-body-secondary py-2">
                        <h4 class="text-success">Nuevo Proveedor</h4>
                        <div class="col-sm-4">
                            <label for="npruc" class="form-label fw-semibold">Nro RUC</label>
                            <input type="text" class="form-control" id="npruc" name="npruc" value="" placeholder="" maxlength="11">
                            <div id="msj-npruc" class="form-text text-danger"></div>
                        </div>
                        <div class="col-sm-5">
                            <label for="nprazon" class="form-label fw-semibold">Razon Social</label>
                            <input type="text" class="form-control" id="nprazon" name="nprazon" value="" placeholder="" maxlength="100">
                            <div id="msj-nprazon" class="form-text text-danger"></div>
                        </div>
                        <div class="col-sm-2 d-flex align-items-end pb-1">
                            <input type="hidden" name="tipo" value="1">
                            <input type="hidden" id="idproveedor_e" name="idproveedor_e">
                            <button class="btn btn-danger" id="btnProveedor">REGISTRAR</button>
                        </div>
                    </div>
                    </form>

                    <div class="row mt-4">
                        <h4 class="bg-body-secondary py-2 text-success">Listado de Proveedores</h4>
                        <div class="col-sm-12 table-responsive">
                            <table id="tblProveedor" class="table table-striped">
                                <thead>
                                    <tr>
                                        <!-- <th>#</th> -->
                                        <th>RUC</th>
                                        <th>PROVEEDOR</th>
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

<?php echo $this->endSection();?>

<?php echo $this->section('scripts');?>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/es.js"></script>

<script>

$(function(){

    /* $( '#cuenta' ).select2( {
        theme: 'bootstrap-5',
        width: '100%',
    });

    $(".numerocondecimal").on("keypress keyup blur",function (event) {
        $(this).val($(this).val().replace(/[^0-9\.]/g,''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    }); */
    

    //LOGICA ASIENTO
    const cuentas = <?php echo json_encode($cuentas); ?>;
    console.log(cuentas);
    // Capturamos el detalle que viene desde el controlador (si está editando)
    const detalleBaseDatos = <?php echo isset($deta_bd) ? json_encode($deta_bd) : '[]'; ?>;

    // Referencias jQuery
    const $cuerpoLineas = $('#cuerpo-lineas');
    const $btnAgregar = $('#btnAgregarLinea');
    const $btnEnviar = $('#btnGuardarAsiento');
    const $selectTemplate = $('#select-cuentas-template');
    const $totalDebeSpan = $('#total-debe');
    const $totalHaberSpan = $('#total-haber');

    let contadorLinea = 0; // Contador para nombres de campos únicos

    // --- 1. Inicialización: Rellenar Plantilla de Select ---
    function inicializarCuentas() {
        // Agregamos la opción por defecto
        $selectTemplate.append('<option value="">Seleccione una cuenta</option>');

        // Rellenamos el resto de opciones usando .each() de jQuery
        $.each(cuentas, function(index, cuenta) {
            const option = `<option value="${cuenta.idcuenta}">${cuenta.cu_codigo} - ${cuenta.cu_cuenta} (${cuenta.cu_dh})</option>`;
            $selectTemplate.append(option);
        });
    }

    // --- FUNCIÓN PRINCIPAL: CALCULAR Y VALIDAR TOTALES ---
    function calcularYValidarTotales() {
        let totalDebe = 0;
        let totalHaber = 0;
        let datosCompletos = true;    // Bandera 1: ¿Movimiento tiene cuenta?
        let hayLineasVacias = false; // Bandera 2: ¿Existe alguna línea completamente vacía?
        
        // 1. Recorrer cada fila para sumar y validar
        $cuerpoLineas.find('tr').each(function() {
            const $fila = $(this);
            
            // Obtener y parsear valores
            const debeVal = parseFloat($fila.find('input[data-rol="debe"]').val()) || 0;
            const haberVal = parseFloat($fila.find('input[data-rol="haber"]').val()) || 0;
            const cuentaSeleccionada = $fila.find('select').val();

            // Acumular totales
            totalDebe += debeVal;
            totalHaber += haberVal;

            // --- VALIDACIONES DE LÍNEA ---
            
            // VALIDACIÓN A: Cuenta requerida si hay movimiento
            if (debeVal > 0 || haberVal > 0) {
                if (cuentaSeleccionada === '') {
                     datosCompletos = false; // Falla si hay valor en Debe/Haber PERO NO hay cuenta
                     $fila.addClass('table-danger');
                } else {
                     $fila.removeClass('table-danger');
                }
            } 
            
            // VALIDACIÓN B (NUEVA): Línea completamente vacía
            else if (debeVal === 0 && haberVal === 0 && cuentaSeleccionada === '') {
                // Si la línea está completamente vacía (0 en todo), forzamos la invalidación
                // Esto obliga al usuario a eliminar las filas residuales antes de enviar.
                hayLineasVacias = true; 
                $fila.removeClass('table-danger');
            }
        });

        // 2. Actualizar totales
        $totalDebeSpan.text(totalDebe.toFixed(2));
        $totalHaberSpan.text(totalHaber.toFixed(2));
        
        // 3. Condiciones de Habilitación
        const partidaDoble = Math.abs(totalDebe - totalHaber) < 0.0001; 
        const hayMovimiento = totalDebe > 0;
        
        // El botón se habilita SÓLO SI:
        // 1. Partida Doble (Debe=Haber)
        // 2. Hay Movimiento (Total > 0)
        // 3. Datos Completos (Todas las líneas tienen cuenta si tienen movimiento)
        // 4. NO Hay Líneas Vacías (No hay filas residuales)
        const habilitarBoton = partidaDoble && hayMovimiento && datosCompletos && !hayLineasVacias;
        
        $btnEnviar.prop('disabled', !habilitarBoton);
        
        // Resaltar los totales
        const colorTotal = partidaDoble ? 'green' : 'red';
        $totalDebeSpan.css('color', colorTotal);
        $totalHaberSpan.css('color', colorTotal);
    }
    
    // --- Función para Agregar Línea ---
    function agregarNuevaLinea() {
        contadorLinea++;
        
        // Se crea el HTML de la fila con jQuery (igual que antes)
        const $selectClonado = $selectTemplate.clone()
            .removeAttr('id').show().addClass('form-select form-select-sm')
            .attr('name', `lineas[${contadorLinea}][cuenta_id]`);
            
        const $inputDebe = $('<input>').attr({
                'type': 'number', 'min': '0', 'step': '0.01', 'placeholder': '0.00',
                'name': `lineas[${contadorLinea}][debe]`, 'data-rol': 'debe'
            }).addClass('form-control form-control-sm text-end');
            
        const $inputHaber = $('<input>').attr({
                'type': 'number', 'min': '0', 'step': '0.01', 'placeholder': '0.00',
                'name': `lineas[${contadorLinea}][haber]`, 'data-rol': 'haber'
            }).addClass('form-control form-control-sm text-end');

        const $btnEliminar = $('<button type="button">❌</button>').addClass('btn btn-danger btn-sm').attr('title', 'Eliminar línea');

        const $nuevaFila = $(`<tr data-linea-id="${contadorLinea}"></tr>`)
            .append($('<td></td>').append($selectClonado))
            .append($('<td></td>').append($inputDebe))
            .append($('<td></td>').append($inputHaber))
            .append($('<td></td>').append($btnEliminar));

        $cuerpoLineas.append($nuevaFila);
        calcularYValidarTotales();
    }

    // --- Función para Agregar Línea con Datos Precargados (CUANDO ES EDITAR) ---
    function agregarLineaConDatos(idcuenta, debe, haber) {
        contadorLinea++;
        
        // 1. Clonamos la plantilla del select de cuentas
        const $selectClonado = $selectTemplate.clone()
            .removeAttr('id').show().addClass('form-select form-select-sm')
            .attr('name', `lineas[${contadorLinea}][cuenta_id]`);
            
        // IMPORTANTE: Le asignamos el ID de la cuenta que viene de la BD
        $selectClonado.val(idcuenta);
            
        // 2. Creamos el input del DEBE (si es 0, lo dejamos vacío para estética)
        const valorDebe = parseFloat(debe) > 0 ? parseFloat(debe).toFixed(2) : '';
        const $inputDebe = $('<input>').attr({
                'type': 'number', 'min': '0', 'step': '0.01', 'placeholder': '0.00',
                'name': `lineas[${contadorLinea}][debe]`, 'data-rol': 'debe',
                'value': valorDebe // Inyectamos el valor
            }).addClass('form-control form-control-sm text-end');
            
        // 3. Creamos el input del HABER (si es 0, lo dejamos vacío para estética)
        const valorHaber = parseFloat(haber) > 0 ? parseFloat(haber).toFixed(2) : '';
        const $inputHaber = $('<input>').attr({
                'type': 'number', 'min': '0', 'step': '0.01', 'placeholder': '0.00',
                'name': `lineas[${contadorLinea}][haber]`, 'data-rol': 'haber',
                'value': valorHaber // Inyectamos el valor
            }).addClass('form-control form-control-sm text-end');

        // 4. Botón eliminar fila
        const $btnEliminar = $('<button type="button">❌</button>').addClass('btn btn-danger btn-sm').attr('title', 'Eliminar línea');

        // 5. Armamos la fila completa (TR)
        const $nuevaFila = $(`<tr data-linea-id="${contadorLinea}"></tr>`)
            .append($('<td></td>').append($selectClonado))
            .append($('<td></td>').append($inputDebe))
            .append($('<td></td>').append($inputHaber))
            .append($('<td></td>').append($btnEliminar));

        // 6. La metemos al cuerpo de la tabla
        $cuerpoLineas.append($nuevaFila);
        
        // Al final, llamamos a calcular para que sume los totales y active el botón de Modificar
        calcularYValidarTotales();
    }
    
    // --- Función de Envío AJAX ---
    function enviarAsientoPorAjax(e) {
        e.preventDefault(); 
        
        // Re-validación final antes de enviar
        if ($btnEnviar.prop('disabled')) {
            Swal.fire({
                icon: 'warning',
                title: '¡Validación Requerida!',
                text: 'Asegúrate de que el Debe y Haber coincidan, y que todas las líneas incompletas o vacías hayan sido corregidas o eliminadas.',
                confirmButtonText: 'Entendido'
            });
            return;
        }

        const url = 'procesar_asiento'; 
        const datosFormulario = $('#frmAsiento').serialize(); 

        let btn = document.querySelector('#btnGuardarAsiento'),
            txtbtn = btn.textContent,
            btnHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        btn.setAttribute('disabled', 'disabled');
        btn.innerHTML = `${btnHTML} PROCESANDO...`;
        
        $.ajax({
            method: 'POST',
            url: url,
            data: datosFormulario,            
            success: function(data){
                console.log(data);
                btn.removeAttribute('disabled');
                btn.innerHTML = txtbtn; 
                $('#msj').html(data);
            }
        });
    }

    // --- ASIGNACIÓN DE EVENTOS CORREGIDA (Delegación) ---
    inicializarCuentas(); 

    // Evaluamos si existen líneas precargadas de la base de datos CUANDO ES EDITAR
    if (detalleBaseDatos.length > 0) {
        // Recorremos el array que mostrabas en tu print_r
        $.each(detalleBaseDatos, function(index, deta) {
            // Ejecutamos una función que cree la línea y cargue sus datos correspondientes
            agregarLineaConDatos(deta.idcuenta, deta.monto_debe, deta.monto_haber);
        });
    } else {
        // Si es un asiento nuevo, colocamos una sola línea vacía por defecto
        agregarNuevaLinea();
    }

    // 1. Botón Agregar Línea
    $btnAgregar.on('click', agregarNuevaLinea);

    // 2. Envío del Formulario
    $('#frmAsiento').on('submit', enviarAsientoPorAjax);
    
    // 3. EVENTO CLAVE CORREGIDO: Recalcular cuando se escribe en Debe/Haber O se cambia el SELECT
    $cuerpoLineas.on('input', 'input[data-rol="debe"], input[data-rol="haber"]', calcularYValidarTotales);
    $cuerpoLineas.on('change', 'select', calcularYValidarTotales); // <-- LÍNEA AGREGADA/CORREGIDA

    // 4. Botón de Eliminar
    $cuerpoLineas.on('click', '.btn-danger', function() {
        $(this).closest('tr').remove(); 
        calcularYValidarTotales(); 
    });
    

});

</script>

<?php echo $this->endSection();?>