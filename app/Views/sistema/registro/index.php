<?php echo $this->extend('plantilla/layout')?>

<?php echo $this->section('contenido');?>

<div class="app-content mt-4">
    <div class="container-fluid">

        <div class="card card-danger card-outline card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#libroCaja" href="#libroCaja">LIBRO DE CAJAS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" data-bs-target="#libroCompras" href="#libroCompras">LIBRO DE COMPRAS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" data-bs-target="#libroVentas" href="#libroVentas">LIBRO DE VENTAS</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">

                    <div class="tab-pane active" id="libroCaja">
                        <div class="row">
                            <div class="col-sm-4 col-lg-3 col-xxl-2">
                                <label for="caja" class="form-label">Seleccione una Caja</label>
                                <select class="form-select" name="caja_filter" id="caja_filter">
                                    <option value="">Seleccione</option>
                                    <?php
                                    foreach( $cajas as $c ){
                                        $idcaja        = $c['idcaja'];
                                        $caja          = $c['ca_caja'];
                                        $nombres       = $c['re_nombres'];
                                        $idresponsable = $c['idresponsable_caja'];

                                        echo "<option value=$idcaja>$caja ($nombres)</option>"; 
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-2 col-xxl-1">
                                <label for="mes_filter" class="form-label">Mes</label>
                                <select class="form-select" name="mes_filter" id="mes_filter" required>
                                    <option value="">Nro de Mes</option>
                                    <?php
                                    for( $i = 1; $i <= 12; $i++ ){                                           
                                        $select_mes = $i == date('m') ? 'selected' : '';
                                        echo "<option value=$i  $select_mes>$i</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-2 col-xxl-1">
                                <label for="anio_filter" class="form-label">Año</label>
                                <input type="text" class="form-control" id="anio_filter" name="anio_filter" maxlength="4" minlength="4" value="<?=date('Y')?>" required>
                            </div>
                            <div class="col-lg-2 col-xxl-1 d-flex align-items-end pb-1">
                                <button class="btn btn-sm btn-outline-primary" id="btnFiltrar"><i class="fa-solid fa-filter"></i> Filtrar</button>
                            </div>
                            <div class="col-lg-3 col-xxl-7 text-end">
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
                                <a class="btn btn-warning" role="button" href="nueva-compra">Nuevo Registro L. Compra</a>
                            </div>
                        </div>
                        <div class="row table-responsive mt-3" id="">
                            <table id="tblLibroCompra" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Total Fact (S/.)</th>
                                        <th>Factura</th>
                                        <th>Ruc</th>                                        
                                        <th>Razon</th>
                                        <th>Glosa</th>
                                        <th>Pagado</th>
                                        <th>Opción</th>
                                    </tr>
                                </thead>
                                <tbody>                                
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="libroVentas">
                        <div class="row">
                            <div class="col-sm-6 d-flex align-items-center">
                                <h5 class="mb-0">Registros Libro de Ventas</h5>
                            </div>
                            <div class="col-sm-6 text-end">
                                <a class="btn btn-warning" role="button" href="nueva-venta">Nuevo Registro L. Venta</a>
                            </div>
                        </div>
                        <div class="row table-responsive mt-3" id="">
                            <table id="tblLibroVenta" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Total Bol. (S/.)</th>
                                        <th>Boleta</th>
                                        <th>DNI</th>                                        
                                        <th>Nombre</th>
                                        <th>Glosa</th>
                                        <th>Cobrado</th>
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

<?php echo $this->endSection();?>

<?php echo $this->section('scripts');?>

<script>
    var $table1;
    var $table2;
    var $table3;
$(function(){
    $table1 = $('#tblLibroCaja').dataTable({
        "ajax":{
            "url": 'lista-lcaja-dt',
            "dataSrc":"",
            "type": "POST",
            "data": {
                "caja": function() { return $('#caja_filter').val() },
                "mes": function() { return $('#mes_filter').val() }, 
                "anio": function() { return $('#anio_filter').val() }
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

    $("#btnFiltrar").on('click', function(e){
        e.preventDefault();
        let btn = document.querySelector('#btnFiltrar'),
            txtbtn = btn.innerHTML,
            btnHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        btn.setAttribute('disabled', 'disabled');
        btn.innerHTML = `${btnHTML} ...`;

        dataTableReload();

        btn.removeAttribute('disabled');
        btn.innerHTML = txtbtn;
    });


    $table2 = $('#tblLibroCompra').dataTable({
        "ajax":{
            "url": 'lista-lcompra-dt',
            "dataSrc":"",
            "type": "POST",
            "data": {
                tipo: 1,
                status: '',
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
            {"data": "co_fecha"},
            {"data": "co_total"},
            {"data": "co_factura"},
            {"data": "pr_ruc"},
            {"data": "pr_razon"},
            {"data": "co_glosa"},
            {"data": "pagado"},
            {"data": "idcompra",
                "mRender": function (data, type, row) {
                    //console.log(row);
                    let oculto = row.pagado == 'no' ? 'd-none' : '';
                    return `
                    <a title='editar' class='link-success editar' role='button' href="editar-compra-${data}">
                        <i class='fa fa-edit'></i>
                    </a> 
                    <a title='eliminar' class='link-danger ms-1 eliminar' role='button' data-id=${data} data-type=1>
                        <i class='fa fa-trash-alt'></i>
                    </a> &nbsp;
                    <a title='ver' class='link-primary ver ${oculto}' role='button' data-id="${data}" onclick="alert('PAGADO EL: ${row.re_fecha}')">
                        <i class='fa fa-search'></i>
                    </a>`;
                }
            }
        ],
        "aaSorting": [[ 0, "desc" ]],
        "pageLength": 25
    });

    $('#tblLibroCompra').on('click', '.eliminar', function(e){
        Swal.fire({
            title: "¿Estás seguro en eliminar el Registro?",
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('elimina-lcompra', {
                    id: $(this).data('id'),
                    type: $(this).data('type')
                }, function(data){
                    //console.log(data)
                    $('#msj').html(data);
                });
            }
        });        
    });


    $table3 = $('#tblLibroVenta').dataTable({
        "ajax":{
            "url": 'lista-lcompra-dt',
            "dataSrc":"",
            "type": "POST",
            "data": {
                tipo: 2,
                status: '',
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
            {"data": "co_fecha"},
            {"data": "co_total"},
            {"data": "co_factura"},
            {"data": "pr_ruc"},
            {"data": "pr_razon"},
            {"data": "co_glosa"},
            {"data": "pagado"},
            {"data": "idcompra",
                "mRender": function (data, type, row) {
                    //console.log(row);
                    let oculto = row.pagado == 'no' ? 'd-none' : '';
                    return `
                    <a title='editar' class='link-success editar' role='button' href="editar-venta-${data}">
                        <i class='fa fa-edit'></i>
                    </a> 
                    <a title='eliminar' class='link-danger ms-1 eliminar' role='button' data-id=${data} data-type=2>
                        <i class='fa fa-trash-alt'></i>
                    </a> &nbsp;
                    <a title='ver' class='link-primary ver ${oculto}' role='button' data-id="${data}" onclick="alert('COBRADO EL: ${row.re_fecha}')">
                        <i class='fa fa-search'></i>
                    </a>`;
                }
            }
        ],
        "aaSorting": [[ 0, "desc" ]],
        "pageLength": 25
    });

    $('#tblLibroVenta').on('click', '.eliminar', function(e){
        Swal.fire({
            title: "¿Estás seguro en eliminar el Registro?",
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('elimina-lcompra', {
                    id: $(this).data('id'),
                    type: $(this).data('type')
                }, function(data){
                    //console.log(data)
                    $('#msj').html(data);
                });
            }
        });        
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
        $table2.DataTable().ajax.reload();
    else if(opt == 3)
        $table3.DataTable().ajax.reload();
}



$('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
    window.location.hash = e.target.hash; // Actualiza el hash de la URL con el ID de la pestaña
});

//PARA LOS TABS
document.addEventListener('DOMContentLoaded', function() {
  // 1. Obtiene el hash de la URL (ej. #perfil)
  const hash = window.location.hash;

  // 2. Si hay un hash, busca el botón o enlace del tab correspondiente
  if (hash) {
    // Busca el elemento que tiene data-bs-target con el mismo valor que el hash
    const tabTriggerEl = document.querySelector(`[data-bs-target="${hash}"]`);

    // 3. Si se encuentra el elemento, activa la pestaña
    if (tabTriggerEl) {
      // Crea una nueva instancia del componente Tab de Bootstrap
      const tab = new bootstrap.Tab(tabTriggerEl);
      
      // Muestra la pestaña
      tab.show();
    }
  }
});
</script>

<?php echo $this->endSection();?>