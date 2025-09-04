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
                                <a class="btn btn-warning" role="button" href="nueva-compra">Nuevo Registro L. Compra</a>
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