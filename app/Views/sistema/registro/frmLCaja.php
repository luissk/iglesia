<?php
//echo "<pre>";print_r($cuentas);echo "</pre>";
if( isset($registro_bd) && $registro_bd ){
    //echo "<pre>";print_r($registro_bd);echo "</pre>";
    $idregistro_bd    = $registro_bd['idregistro'];
    $idresponsable_bd = $registro_bd['idresponsable_caja'];
    $mov_bd           = $registro_bd['re_mov'];
    $fecha_bd         = $registro_bd['re_fecha'];
    $concepto_bd      = $registro_bd['re_desc'];
    $idcuenta_bd      = $registro_bd['idcuenta'];
    $importe_bd       = $registro_bd['re_importe'];

    $idcompra_bd      = $registro_bd['idcompra'];

    $btn_title = "MODIFICAR REGISTRO";
}else{
    $idregistro_bd    = "";
    $idresponsable_bd = "";
    $mov_bd           = "";
    $fecha_bd         = date('Y-m-d');
    $concepto_bd      = "";
    $idcuenta_bd      = "";
    $importe_bd       = "";

    $idcompra_bd      = "";

    $btn_title = "GUARDAR REGISTRO";
}
?>
<form id="frmLCaja">
    <div class="row">
        <div class="col-sm-12">
            <label for="caja" class="form-label fw-semibold">Seleccione una Caja</label>
            <select class="form-select" name="caja" id="caja">
                <option value="">Seleccione</option>
                <?php
                foreach( $cajas as $c ){
                    $idcaja        = $c['idcaja'];
                    $caja          = $c['ca_caja'];
                    $nombres       = $c['re_nombres'];
                    $idresponsable = $c['idresponsable_caja'];

                    $select_caja = $idresponsable_bd == $idresponsable ? 'selected' : '';
                    echo "<option value=$idresponsable  $select_caja>$caja ($nombres)</option>";
                }
                ?>
            </select>
            <div id="msj-caja" class="form-text text-danger"></div>
        </div>
        <div class="col-sm-6 mt-3">
            <label for="mov" class="form-label fw-semibold">Seleccione el movimiento</label>
            <select class="form-select" name="mov" id="mov">
                <option value="">Seleccione</option>
                <option value="1" <?=$mov_bd == 1 ? 'selected':''?>>Ingreso</option>
                <option value="2" <?=$mov_bd == 2 ? 'selected':''?>>Egreso</option>
            </select>
            <div id="msj-mov" class="form-text text-danger"></div>
        </div>
        <div class="col-sm-6 mt-3">
            <label for="fecha" class="form-label fw-semibold">Ingrese una fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" value="<?=$fecha_bd?>">
            <div id="msj-fecha" class="form-text text-danger"></div>
        </div>        
        <div class="col-sm-12 mt-3">
            <label for="cuenta" class="form-label fw-semibold">Seleccione una Cuenta &nbsp;</label> <a class="btn btn-sm btn-danger d-none" id="btnVerFacturas" tipo=1>Ver Facturas</a>
            <select class="form-select" name="cuenta" id="cuenta">
                <option value="">Seleccione</option>
                <?php
                foreach( $cuentas as $cu ){
                    $idcuenta       = $cu['idcuenta'];
                    $cu_dh          = $cu['cu_dh'];
                    $cu_codigo      = $cu['cu_codigo'];
                    $cu_cuenta      = $cu['cu_cuenta'];
                    $cu_observacion = $cu['cu_observacion'];

                    $opt = $cu_dh == 'Haber' ? 1 : 2;
                    $select_cuenta = $idcuenta_bd == $idcuenta ? 'selected' : '';
                    echo "<option value=$idcuenta data-opt='$opt' data-obs='$cu_observacion' $select_cuenta>$cu_codigo - $cu_cuenta</option>";
                }
                ?>
            </select>
            <div id="msjObs"></div>
            <div id="msj-cuenta" class="form-text text-danger"></div>
        </div>
        <div class="col-sm-12 mt-3">
            <label for="concepto" class="form-label fw-semibold">Concepto</label>
            <input type="text" class="form-control" id="concepto" name="concepto" maxlength="200" value="<?=$concepto_bd?>">
            <div id="msj-concepto" class="form-text text-danger"></div>
        </div>
        <div class="col-sm-4 mt-3">
            <label for="importe" class="form-label fw-semibold">Ingrese el importe</label>
            <input type="text" class="form-control" id="importe" name="importe" maxlength="10" value="<?=$importe_bd?>">
            <div id="msj-importe" class="form-text text-danger"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 mt-3 text-end">
            <button type="submit" class="btn btn-danger" id="btnGuardar"><?=$btn_title?></button>
            <input type="hidden" class="form-control" id="idregistroe" name="idregistroe" value="<?=$idregistro_bd?>">
            <input type="hidden" class="form-control" id="idcompra" name="idcompra" value="<?=$idcompra_bd?>">
        </div>
        <div id="msjRegistro"></div>
    </div>
</form>

<div class="modal fade" id="modalFacturas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalFacturasLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h1 class="modal-title fs-5" id="tituloModalFact">Facturas por pagar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body table-responsive" style="font-size: 14px;">
                    <table id="tblFacturas" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Total (S/.)</th>
                                <th>Comprobante</th>
                                <th>Doc</th>                                        
                                <th>Razon/Nombre</th>
                                <th>Glosa</th>
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

<script>
$('#frmLCaja').on('change', '#mov', function(e){
    $('#msjObs').text("");
    $("#cuenta").prop('selectedIndex', 0);

    mostrarOpciones($(this).val());

    verFacturas();
});

$('#frmLCaja').on('change', '#cuenta', function(e){
    if( $(this).val() != '' ){
        $('#msjObs').text($(this).find(':selected').data('obs'));

        verFacturas();
    }
});

ocultarOpciones();

function ocultarOpciones(){
    $.each($('#cuenta option'), (i,v)=>{
        if( i > 0 ){
            v.style.display = 'none';
        }
    });
}

function mostrarOpciones(cri){
    let mov_bd = <?=$mov_bd != '' ? $mov_bd : 0?>,
        cuenta_bd = <?=$idcuenta_bd != '' ? $idcuenta_bd : 0?>;

    $.each($('#cuenta option'), (i,v)=>{
        if( i > 0 ){
            if( v.getAttribute('data-opt') == cri ){
                v.style.display = 'block';
            }else{
                v.style.display = 'none';
            }

            if( mov_bd == cri && v.value == cuenta_bd )
                $("#cuenta").val(cuenta_bd).trigger('change');
        }
    });
}

<?php
if( $mov_bd != '' ){
?>
    $("#mov").trigger('change');
    $("#cuenta").trigger('change');
<?php
}
?>


function verFacturas(){
    if( $('#cuenta').val() == 4 && $('#mov').val() == 2 ){
        $('#btnVerFacturas').removeClass('d-none');
        $('#btnVerFacturas').text('Ver Facturas');
        $('#btnVerFacturas').attr('tipo', 1)
        $('#tituloModalFact').html('Facturas por pagar');
    }else if( $('#cuenta').val() == 35 && $('#mov').val() == 1 ){
        $('#btnVerFacturas').removeClass('d-none');
        $('#btnVerFacturas').text('Ver Boletas');
        $('#btnVerFacturas').attr('tipo', 2)
        $('#tituloModalFact').html('Boletas por cobrar');
    }else{
        $('#btnVerFacturas').addClass('d-none');
        if( $("#idcompra").val() > 0 )//para limpiar los campos siempre y cuando no haya sido antes seleccionado una factura
            limpiarDatosFactura();
    }
}
function limpiarDatosFactura(){//
    $("#concepto").val('');
    $("#importe").val('');
    $("#idcompra").val('');
}

$(function(){
    
    var $dtFacturas_x_pagar;

    $("#frmLCaja").on('submit', function(e){
        e.preventDefault();
        let btn = document.querySelector('#btnGuardar'),
            txtbtn = btn.textContent,
            btnHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        btn.setAttribute('disabled', 'disabled');
        btn.innerHTML = `${btnHTML} PROCESANDO...`;

        $.post('registro-lcaja', $(this).serialize(), function(data){
            //console.log(data);
            $('[id^="msj-"').text("");                
            if( data.errors ){  
                let errors = data.errors;
                for( let err in errors ){
                    $('#msj-' + err).text(errors[err]);
                }
            }
            $("#msjRegistro").html(data);
            btn.removeAttribute('disabled');
            btn.innerHTML = txtbtn;
        });
    });


    $("#btnVerFacturas").on('click', function(e){
        $("#modalFacturas").modal('show');
        
        $dtFacturas_x_pagar.DataTable().ajax.reload();
    });

    $dtFacturas_x_pagar = $('#tblFacturas').dataTable({
        "ajax":{
            "url": 'lista-lcompra-dt',
            "dataSrc":"",
            "type": "POST",
            "data": function (d) {
                d.tipo = $('#btnVerFacturas').attr('tipo');
                d.status =  0;
                //"desc": function() { return $('#desc').val() },
                //"fecha_ini": function() { return $('#fecha_ini').val() }, 
                //"fecha_fin": function() { return $('#fecha_fin').val() }
                return d;
            },
            "complete": function(xhr, responseText){
                /* console.log(xhr);
                console.log(xhr.responseText); //*** responseJSON: Array[0] */
            }
        },
        "columns":[
            {"data": "co_fecha"},
            {"data": "co_total"},
            {"data": "co_factura"},
            {"data": "pr_ruc"},
            {"data": "pr_razon"},
            {"data": "co_glosa"},
            {"data": "idcompra",
                "mRender": function (data, type, row) {
                    //console.log(row);
                    return `
                    <a title='seleccionar' style='font-size:16px' class='link-danger ms-1 seleccionar' role='button' data-id=${data}>
                        <i class="fa-solid fa-square-check"></i>
                    </a>`;
                }
            }
        ],
        "aaSorting": [[ 0, "desc" ]],
        "pageLength": 25
    });

    $('#tblFacturas').on('click', '.seleccionar', function(e){
        let id = $(this).data('id'),
            fecha = $(this).parent().parent().children()[0].innerText,
            total = $(this).parent().parent().children()[1].innerText,
            factura = $(this).parent().parent().children()[2].innerText,
            ruc = $(this).parent().parent().children()[3].innerText,
            razon = $(this).parent().parent().children()[4].innerText;

        //console.log(id, fecha, total, factura, ruc, razon);
        if( $('#btnVerFacturas').attr('tipo') == 1 )
            $("#concepto").val(`FACTURA ${factura}, ${ruc}`);
        else
            $("#concepto").val(`BOLETA ${factura}, ${ruc}`);
        $("#importe").val(total);
        $("#idcompra").val(id);

        $("#modalFacturas").modal('hide');
    });

});


</script>