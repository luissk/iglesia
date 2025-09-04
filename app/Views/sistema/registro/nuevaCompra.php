<?php echo $this->extend('plantilla/layout')?>

<?php echo $this->section('contenido');?>

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
                        <input type="date" class="form-control" id="fecha" name="fecha" value="<?=date('Y-m-d')?>">
                        <div id="msj-fecha" class="form-text text-danger"></div>
                    </div>
                    <div class="col-sm-2">
                        <label for="factura" class="form-label fw-semibold">Nro Factura</label>
                        <input type="text" class="form-control" id="factura" name="factura" value="" placeholder="F-1-120" maxlength="10">
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

                                echo "<option value=$idproveedor>$ruc - $razon</option>";
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
                    <div class="col-sm-5">
                        <label for="glosa" class="form-label fw-semibold">Glosa</label>
                        <input type="text" class="form-control" id="glosa" name="glosa" value="" placeholder="" maxlength="100">
                        <div id="msj-glosa" class="form-text text-danger"></div>
                    </div>
                    <div class="col-sm-2">
                        <label for="precio" class="form-label fw-semibold">Precio</label>
                        <input type="text" class="form-control numerocondecimal" id="precio" name="precio" value="" placeholder="" maxlength="10" autocomplete="off">
                        <div id="msj-precio" class="form-text text-danger"></div>
                    </div>
                    <div class="col-sm-1">
                        <label for="cantidad" class="form-label fw-semibold">Cant</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad" value="" placeholder="" maxlength="5" autocomplete="off">
                        <div id="msj-cantidad" class="form-text text-danger"></div>
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

                                echo "<option value=$idcuenta  data-obs='$cu_observacion' data-codigo='$cu_codigo'>$cu_codigo - $cu_cuenta</option>";
                            }
                            ?>
                        </select>
                        <div id="msjObs" class="small text-secondary-emphasis"></div>
                        <div id="msj-cuenta" class="form-text text-danger"></div>
                    </div>
                    <div class="col-sm-12 mt-3 text-center">
                        <a class="btn btn-outline-danger" id="addGlosa">Agregar Glosa a Detalle</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-danger card-outline">
            <div class="card-header pt-1 pb-0 border-bottom-1">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h5 class="">Detalle</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 table-responsive">
                        <table class="table table-sm" id="detalleTabla">
                            <thead>
                                <tr>
                                    <th>Glosa</th>
                                    <th>Cuenta</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Precio T</th>
                                    <th>Opcion</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
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

// LocalStorage
const FACTURA_KEY = 'detalle';
// Array en memoria que contiene los detalles de la factura
let detallesFactura = [];

$(function(){
    cargarDetalle();

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
        console.log(txtbtn)
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

    $('#frmCompra').on('change', '#cuenta', function(e){
        $('#msjObs').text('');
        if( $(this).val() != '' ){
            $('#msjObs').text($(this).find(':selected').data('obs'));
        }
    });

    $("#addGlosa").on('click', function(e){
        const glosa = $('#glosa'),
            precio = $('#precio'),
            cantidad = $('#cantidad'),
            cuenta = $('#cuenta'),
            idcuenta = cuenta.val(),
            codcuenta = cuenta.find(':selected').data('codigo'),
            fecha = $('#fecha'),
            factura = $('#factura'),
            proveedor = $('#proveedor');

        let men = '';
        if( fecha.val().trim() == '' ) men = 'Ingrese una fecha';
        else if( factura.val().trim() == '' ) men = 'Ingrese la factura';
        else if( proveedor.val() == '' ) men = 'Seleccione el proveedor';
        else if( glosa.val().trim() == '' ) men = 'Ingrese la glosa';
        else if( precio.val() == '' ) men = 'Ingrese el precio';
        else if( cantidad.val() == '' ) men = 'Ingrese una cantidad';
        else if( cuenta.val() == '' ) men = 'Seleccione una cuenta';

        if( men != '' ){
            Swal.fire({title: men, icon: "error"});
            return;
        }

        const detalle = {
            glosa: glosa.val(),
            codcuenta,
            idcuenta,
            precio: precio.val(),
            cantidad: cantidad.val(),
            subt: parseFloat(precio.val()) * parseInt(cantidad.val())
        }

        detallesFactura.push(detalle);

        localStorage.setItem(FACTURA_KEY, JSON.stringify(detallesFactura));

        mostrarDetalleEnTabla();

        glosa.val('');
        precio.val('');
        cantidad.val('');

        cuenta.prop('selectedIndex', 0);
        $('#msjObs').text('');
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

// Función para cargar los datos desde localStorage
function cargarDetalle() {
    const datosGuardados = localStorage.getItem(FACTURA_KEY);
    if (datosGuardados) {
        // JSON.parse() convierte el string de vuelta a un array/objeto
        detallesFactura = JSON.parse(datosGuardados);
        mostrarDetalleEnTabla();
    }
}

function mostrarDetalleEnTabla() {
    const tablaBody = document.querySelector('#detalleTabla tbody');
    tablaBody.innerHTML = ''; // Limpiar la tabla

    detallesFactura.forEach((item, index) => {
        const fila = document.createElement('tr');
        fila.innerHTML = `
            <td>${item.glosa}</td>
            <td>${item.codcuenta}</td>
            <td>${item.precio}</td>
            <td>${item.cantidad}</td>
            <td>${item.precio * item.cantidad}</td>
            <td><a onclick="eliminarItem(${index})"><i class='fas fa-trash-alt'></i></a></td>
        `;
        tablaBody.appendChild(fila);
    });
}

function eliminarItem(index){
    detallesFactura.splice(index, 1);
    // Actualizar localStorage con el nuevo array
    localStorage.setItem(FACTURA_KEY, JSON.stringify(detallesFactura));
    // Actualizar la tabla en la pantalla
    mostrarDetalleEnTabla();
}

///MODEOLOOOO
document.getElementById('guardarBtn').addEventListener('click', function() {
    // Obtener los datos del encabezado
    const facturaCompleta = {
        nroFactura: document.getElementById('nroFactura').value,
        fecha: document.getElementById('fechaFactura').value,
        proveedor: document.getElementById('proveedor').value,
        // Y el detalle que está en el array de JavaScript
        detalle: detallesFactura
    };

    // Verificar que haya productos en el detalle
    if (facturaCompleta.detalle.length === 0) {
        alert("El detalle no puede estar vacío.");
        return;
    }

    // Enviar los datos a un script de PHP (por ejemplo, 'guardar_factura.php')
    fetch('guardar_factura.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        // Convertir todo el objeto a un string JSON para enviarlo
        body: JSON.stringify(facturaCompleta)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Factura guardada con éxito!');
            // Opcional: limpiar localStorage después de guardar
            localStorage.removeItem(FACTURA_KEY);
            // Redireccionar o limpiar la interfaz
            window.location.reload();
        } else {
            alert('Error al guardar la factura: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ocurrió un error al conectar con el servidor.');
    });
});
</script>

<?php echo $this->endSection();?>