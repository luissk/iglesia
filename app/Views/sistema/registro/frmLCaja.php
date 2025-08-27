<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

<?php
//echo "<pre>";print_r($cajas);echo "</pre>";
$fechaAct = date('Y-m-d');
?>
<div id="frmLCaja">
    <div class="row">
        <div class="col-sm-12">
            <label for="caja" class="form-label fw-semibold">Seleccione una Caja</label>
            <select class="form-select" name="caja" id="caja">
                <option value="">Seleccione</option>
                <?php
                foreach( $cajas as $c ){
                    $idcaja  = $c['idcaja'];
                    $caja    = $c['ca_caja'];
                    $nombres = $c['re_nombres'];
                    echo "<option value=$idcaja>$caja ($nombres)</option>";
                }
                ?>
            </select>
            <div id="msj-caja" class="form-text text-danger"></div>
        </div>
        <div class="col-sm-6 mt-3">
            <label for="mov" class="form-label fw-semibold">Seleccione el movimiento</label>
            <select class="form-select" name="mov" id="mov">
                <option value="">Seleccione</option>
                <option value="1">Ingreso</option>
                <option value="2">Egreso</option>
            </select>
            <div id="msj-mov" class="form-text text-danger"></div>
        </div>
        <div class="col-sm-6 mt-3">
            <label for="fecha" class="form-label fw-semibold">Ingrese una fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" value="<?=$fechaAct?>">
            <div id="msj-fecha" class="form-text text-danger"></div>
        </div>
        <div class="col-sm-12 mt-3">
            <label for="concepto" class="form-label fw-semibold">Concepto</label>
            <input type="text" class="form-control" id="concepto" name="concepto" maxlength="200">
            <div id="msj-concepto" class="form-text text-danger"></div>
        </div>
        <div class="col-sm-12 mt-3">
            <label for="cuenta" class="form-label fw-semibold">Seleccione una Cuenta</label>
            <select class="form-select" name="cuenta" id="cuenta" disabled>
                <option value="">Seleccione</option>
                <?php
                foreach( $cuentas as $cu ){
                    $idcuenta       = $cu['idcuenta'];
                    $cu_dh          = $cu['cu_dh'];
                    $cu_codigo      = $cu['cu_codigo'];
                    $cu_cuenta      = $cu['cu_cuenta'];
                    $cu_observacion = $cu['cu_observacion'];

                    $opt = $cu_dh == 'Haber' ? 1 : 2;
                    echo "<option value=$idcuenta data-opt='$opt' data-obs='$cu_observacion'>$cu_codigo - $cu_cuenta</option>";
                }
                ?>
            </select>
            <div id="msjObs"></div>
            <div id="msj-cuenta" class="form-text text-danger"></div>
        </div>
        <div class="col-sm-4 mt-3">
            <label for="importe" class="form-label fw-semibold">Ingrese el importe</label>
            <input type="text" class="form-control" id="importe" name="importe" maxlength="10">
            <div id="msj-importe" class="form-text text-danger"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/es.js"></script>

<script>
$(function(){
    /* $( '#cuenta' ).select2( {
        theme: 'bootstrap-5',
        dropdownParent: $("#modalLCaja"),
    }); */

    $('#mov').on('change', function(e){
        alternarCuentas();
    });

    $('#frmLCaja').on('#cuenta', 'change', function(e){
        alert(1);
        if( $(this).val() != '' ){
            $('#msjObs').text($(this).data('obs'));
        }
    })
});

const tipo_movimiento_select = document.getElementById('mov');
const cuentas_select         = document.getElementById('cuenta');
const todas_las_opciones     = Array.from(cuentas_select.options);

function alternarCuentas(){   
    const valor_seleccionado = event.target.value;
    console.log(valor_seleccionado)

    cuentas_select.innerHTML = '';

    todas_las_opciones.forEach(opcion => {
        // Si el valor de data-opt de la opción coincide con el valor seleccionado
        if (opcion.getAttribute('data-opt') === valor_seleccionado) {
            cuentas_select.appendChild(opcion);
            cuentas_select.removeAttribute('disabled');
        }
    });
    
    if (valor_seleccionado === '') {
        todas_las_opciones.forEach(opcion => {
            cuentas_select.appendChild(opcion);
        });
        cuentas_select.value = ''
        cuentas_select.setAttribute('disabled','disabled');
    }

}
</script>