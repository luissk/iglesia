<?php echo $this->extend('plantilla/layout')?>

<?php echo $this->section('contenido');?>

<?php
if( isset($compra_bd) && $compra_bd ){
    /* echo "<pre>";
    print_r($compra_bd);
    echo "</pre>"; */

    $idcompra_bd   = $compra_bd['idcompra'];
    $fecha_bd      = $compra_bd['co_fecha'];
    $factura_bd    = $compra_bd['co_factura'];
    $proveedor_bd  = $compra_bd['idproveedor'];
    $subt_bd       = $compra_bd['co_subt'];
    $igv_bd        = $compra_bd['co_igv'];
    $total_bd      = $compra_bd['co_total'];
    $cuentabase_bd = $compra_bd['cuentabase'];
    $glosa_bd      = $compra_bd['co_glosa'];

    $btn_title = "MODIFICAR COMPRA";


}else{
    $idcompra_bd   = "";
    $fecha_bd      = date('Y-m-d');
    $factura_bd    = "";
    $proveedor_bd  = "";
    $subt_bd       = "";
    $igv_bd        = "";
    $total_bd      = "";
    $cuentabase_bd = "";
    $glosa_bd      = "";

    $btn_title = "REGISTRAR COMPRA";
}
?>

<div class="app-content mt-4">
    <div class="container-fluid">

        <div class="card card-danger card-outline">
            <div class="card-header pt-1 pb-0 border-bottom-1">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="">REGISTRO DE COMPRAS</h4>
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
                        <label for="factura" class="form-label fw-semibold">Nro Factura</label>
                        <input type="text" class="form-control" id="factura" name="factura" value="<?=$factura_bd?>" placeholder="F-1-120" maxlength="10">
                        <div id="msj-factura" class="form-text text-danger"></div>
                    </div>
                    <div class="col-sm-5">
                        <label for="proveedor" class="form-label fw-semibold">Seleccione un Proveedor</label>
                        <select class="form-select" name="proveedor" id="proveedor">
                            <option value="">Seleccione</option>
                            <?php
                            foreach($proveedores as $pro){
                                $idproveedor = $pro['idproveedor'];
                                $ruc = $pro['pr_ruc'];
                                $razon = $pro['pr_razon'];

                                $selected_pr = $idproveedor == $proveedor_bd ? 'selected' : '';

                                echo "<option value=$idproveedor $selected_pr>$ruc - $razon</option>";
                            }
                            ?>
                        </select>
                        <div id="msj-proveedor" class="form-text text-danger"></div>
                    </div>
                    <div class="col-sm-2 d-flex align-items-end pb-1">
                        <a class="btn btn-outline-secondary btn-sm" role="button" data-bs-toggle="modal" data-bs-target="#modalProveedor">+ Proveedor</a>
                    </div>
                    <div class="col-sm-12">
                        &nbsp;
                    </div>
                    <div class="col-sm-2">
                        <label for="subt" class="form-label fw-semibold">Subtotal</label>
                        <input type="text" class="form-control numerocondecimal" id="subt" name="subt" value="<?=$subt_bd?>" placeholder="" maxlength="10">
                        <div id="msj-subt" class="form-text text-danger"></div>
                    </div>
                    <div class="col-sm-1">
                        <label for="igv" class="form-label fw-semibold">IGV</label>
                        <input type="text" class="form-control numerocondecimal" id="igv" name="igv" value="<?=$igv_bd?>" placeholder="" maxlength="10" autocomplete="off">
                        <div id="msj-igv" class="form-text text-danger"></div>
                    </div>
                    <div class="col-sm-2">
                        <label for="total" class="form-label fw-semibold">Total</label>
                        <input type="number" class="form-control numerocondecimal" id="total" name="total" value="<?=$total_bd?>" placeholder="" maxlength="10" autocomplete="off">
                        <div id="msj-total" class="form-text text-danger"></div>
                    </div>
                    <div class="col-sm-4">
                        <label for="cuenta" class="form-label fw-semibold">Cuenta</label>
                        <select class="form-select" name="cuenta" id="cuenta">
                            <option value="">Seleccione</option>
                            <?php
                            foreach( $cuentas as $cu ){
                                $idcuenta       = $cu['idcuenta'];
                                $cu_dh          = $cu['cu_dh'];
                                $cu_codigo      = $cu['cu_codigo'];
                                $cu_cuenta      = $cu['cu_cuenta'];
                                $cu_observacion = $cu['cu_observacion'];

                                $cuenta_sel = $idcuenta == $cuentabase_bd ? 'selected' : '';

                                echo "<option value=$idcuenta $cuenta_sel  data-obs='$cu_observacion' data-codigo='$cu_codigo'>$cu_codigo - $cu_cuenta</option>";
                            }
                            ?>
                        </select>
                        <div id="msjObs" class="small text-secondary-emphasis"></div>
                        <div id="msj-cuenta" class="form-text text-danger"></div>
                    </div>
                    <div class="col-sm-3">
                        <label for="glosa" class="form-label fw-semibold">Glosa</label>
                        <input type="text" class="form-control" id="glosa" name="glosa" value="<?=$glosa_bd?>" placeholder="" maxlength="100" autocomplete="off">
                        <div id="msj-glosa" class="form-text text-danger"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12 text-end">
                <input type="hidden" id="idcompra_e" name="idcompra_e" value="<?=$idcompra_bd?>">
                <button class="btn btn-primary" id="btnCompra"><?=$btn_title?></button>
            </div>
        </div>
    </div>

    <div id="msj"></div>
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

<script>
var $dtblProveedor;

$(function(){

    $(".numerocondecimal").on("keypress keyup blur",function (event) {
        $(this).val($(this).val().replace(/[^0-9\.]/g,''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    $dtblProveedor = $('#tblProveedor').dataTable({
        "ajax":{
            "url": 'lista-proveedor-dt',
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
            {"data": "pr_ruc"},
            {"data": "pr_razon"},
            {"data": "idproveedor",
                "mRender": function (data, type, row) {
                    //console.log(row);
                    return `
                    <a title='editar' class='link-success editar' role='button' data-id=${data} data-ruc=${row.pr_ruc} data-razon=\'${row.pr_razon}\'>
                        <i class='fa fa-edit'></i>
                    </a> 
                    <a title='eliminar' class='link-danger ms-1 eliminar' role='button' data-id=${data}>
                        <i class='fa fa-trash-alt'></i>
                    </a>`;
                }
            }
        ],
        "aaSorting": [[ 2, "desc" ]],
    });

    $('#frmProveedor').on('submit', function(e){
        e.preventDefault();
        let btn = document.querySelector('#btnProveedor'),
            txtbtn = btn.textContent,
            btnHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        btn.setAttribute('disabled', 'disabled');
        btn.innerHTML = `${btnHTML} PROCESANDO...`;
        //console.log(txtbtn)
        $.post('registro-proveedor', $(this).serialize(), function(data){
            //console.log(data);
            $('[id^="msj-"').text("");                
            if( data.errors ){  
                let errors = data.errors;
                for( let err in errors ){
                    $('#msj-' + err).text(errors[err]);
                }
            }            
            btn.removeAttribute('disabled');
            btn.innerHTML = txtbtn;
            $("#msj").html(data);
        });
    });

    $('#tblProveedor').on('click', '.editar', function(e){
        let id = $(this).data('id'),
            ruc = $(this).data('ruc'),
            razon = $(this).data('razon');
        
        $("#npruc").val(ruc);  
        $("#nprazon").val(razon);    
        $("#idproveedor_e").val(id);
        $("#btnProveedor").text("MODIFICAR");
    });

    $('#tblProveedor').on('click', '.eliminar', function(e){
        Swal.fire({
            title: "¿Estás seguro en eliminar al Proveedor?",
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('elimina-proveedor', {
                    id: $(this).data('id')
                }, function(data){
                    //console.log(data)
                    $('#msj').html(data);
                });
            }
        });        
    });

    const myModalEl = document.getElementById('modalProveedor')
    myModalEl.addEventListener('hidden.bs.modal', event => {
        limpiarCamposProv();
        $("#msj").html("");
    });

    $('#cuenta').on('change', function(e){
        $('#msjObs').text('');
        if( $(this).val() != '' ){
            $('#msjObs').text($(this).find(':selected').data('obs'));
        }
    });

    $('#subt').on('input', function(e){
        let subt = parseFloat($(this).val());
        let igv = 0;
        let total = 0;
        if( subt > 0 ){
            igv = subt * 0.18;
            total = subt + igv;
        }
        $('#igv').val(igv.toFixed(2));
        $('#total').val(total.toFixed(2));
    });

    $('#btnCompra').on('click', function(e){
        e.preventDefault();
        e.preventDefault();
        let btn = document.querySelector('#btnProveedor'),
            txtbtn = btn.textContent,
            btnHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        btn.setAttribute('disabled', 'disabled');
        btn.innerHTML = `${btnHTML} PROCESANDO...`;

        if( $('#subt').val() < 1 || $('#cuenta').val() == '' || $('#glosa').val() == '' || $('#fecha').val() == '' || $('#factura').val() == '' || $('#proveedor').val()== '' ){
            Swal.fire({title: "Por favor, rellena los campos", icon: "error"});
            btn.removeAttribute('disabled');
            btn.innerHTML = txtbtn;
            return;
        }

        let formData = new FormData();
        formData.append('fecha', $('#fecha').val());
        formData.append('factura', $('#factura').val());
        formData.append('proveedor', $('#proveedor').val());
        formData.append('subt', $('#subt').val());
        formData.append('igv', $('#igv').val());
        formData.append('total', $('#total').val());
        formData.append('cuenta', $('#cuenta').val());
        formData.append('glosa', $('#glosa').val());
        formData.append('idcompra_e', $('#idcompra_e').val());

        $.ajax({
            method: 'POST',
            url: 'registro-compra',
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: function(data){
                console.log(data);
                btn.removeAttribute('disabled');
                btn.innerHTML = txtbtn; 
                $('#msj').html(data);
            }
        });

    });

});

function dtProvReload(){
    $dtblProveedor.DataTable().ajax.reload();
}

function limpiarCamposProv(){
    $("#frmProveedor")[0].reset();
    $('[id^="msj-"').text("");
    $("#idproveedor_e").val("");
    $("#btnProveedor").text("REGISTRAR");
}

function cargarSelectProv($opt, ruc = '', razon = '', id){
    if( $opt == 1 ){
        //add
        $("#proveedor").append($('<option>', {value: id, text: ruc + ' - ' + razon}));
    }else if( $opt == 2 ){
        //upd
        $("#proveedor option[value="+id+"]").text(ruc + ' - ' + razon);
    }else if( $opt == 3 ){
        //del
        $("#proveedor option[value="+id+"]").remove();
    }
}

function formateaPrecio(precio){
    const precioFormateado = precio.toLocaleString('es-PE', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
    return precioFormateado;
}

function limpiarCabecera(){
    $('#factura').val('');
    $('#proveedor').val('');
}

</script>

<?php echo $this->endSection();?>