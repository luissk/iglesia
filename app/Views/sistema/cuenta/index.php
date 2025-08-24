<?php echo $this->extend('plantilla/layout')?>

<?php echo $this->section('contenido');?>

<div class="app-content mt-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">                      
                        <div class="row">
                            <div class="col-sm-6 d-flex align-items-center">
                                <h4 class="mb-0">Cuentas del Sistema</h4>
                            </div>
                            <div class="col-sm-6 text-end">
                                <a class="btn btn-warning" role="button" data-bs-toggle="modal" data-bs-target="#modalCuenta">Nueva Cuenta</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive" id="divListar">
                        <table id="cuentas" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>D / H</th>
                                    <th>Codigo</th>                                    
                                    <th>Cuenta</th>
                                    <th>Observación</th>
                                    <th>Opcion</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if( $cuentas ){
                                $cont = 0;
                                foreach( $cuentas as $c){
                                    $cont++;
                                    $idcuenta    = $c['idcuenta'];
                                    $dh          = $c['cu_dh'];
                                    $codigo      = $c['cu_codigo'];
                                    $cuenta      = $c['cu_cuenta'];
                                    $observacion = $c['cu_observacion'];

                                    $arr = json_encode(
                                        [
                                            $dh == 'Debe' ? 1 : 2, $codigo, $cuenta, $observacion
                                        ],
                                        JSON_HEX_APOS
                                    );

                                    echo "<tr>";
                                    echo "<td>$cont</td>";                                    
                                    echo "<td>$dh</td>";
                                    echo "<td>$codigo</td>";
                                    echo "<td>$cuenta</td>";
                                    echo "<td>$observacion</td>";
                                    echo '<td class="d-flex justify-content-center">';
                                    echo '<a href="javascript:;" class="link-success editar" title="Modificar" data-id='.$idcuenta.' data-arr=\''.$arr.'\'><i class="fa-solid fa-pen-to-square"></i></a>';
                                    //if( $idiglesia != 1 )
                                        echo '<a href="javascript:;" class="link-danger ms-2 eliminar" title="Eliminar" data-id='.$idcuenta.'><i class="fa-solid fa-trash"></i></a>';
                                    echo '</td>';
                                    echo "</tr>";                                    
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="msj"></div>

<div class="modal fade" id="modalCuenta" tabindex="-1" aria-labelledby="modalCuentaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h1 class="modal-title fs-5" id="tituloModal">Formulario Cuenta</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="frmCuenta">
                <div class="modal-body">            
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="dh" class="form-label">Debe / Haber</label>
                            <select class="form-select" name="dh" id="dh">
                                <option value="">Seleccione</option>
                                <option value="1">Debe</option>
                                <option value="2">Haber</option>
                            </select>
                            <div id="msj-dh" class="form-text text-danger"></div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="codigo" class="form-label">Código</label>
                            <input type="text" class="form-control" id="codigo" name="codigo" value="" maxlength="3">
                            <div id="msj-codigo" class="form-text text-danger"></div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label for="cuenta" class="form-label">Cuenta</label>
                            <input type="text" class="form-control" id="cuenta" name="cuenta" value="" maxlength="100">
                            <div id="msj-cuenta" class="form-text text-danger"></div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label for="observa" class="form-label">Observación</label>
                            <input type="text" class="form-control" id="observa" name="observa" value="" maxlength="100">
                            <div id="msj-observa" class="form-text text-danger"></div>
                        </div>
                    </div>
                </div>
                <div id="msj"></div>
                <div class="modal-footer py-2">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                    <button type="submit" class="btn btn-danger" id="btnGuardar">REGISTRAR CUENTA</button>
                    <input type="hidden" class="form-control" id="idcuentae" name="idcuentae">
                </div>
            </form>
        </div>
    </div>
</div>

<?php echo $this->endSection();?>

<?php echo $this->section('scripts');?>

<script>

    var $table = $('#cuentas').dataTable({
        "pageLength": 50
    });

    
$(function(){
    $("#cuentas").on('click', '.editar', function(e){
        e.preventDefault();
        let id = $(this).data('id'),
            arr = $(this).data('arr');
        //console.log(arr);

        limpiarCampos();

        $("#dh").val(arr[0]);
        $("#codigo").val(arr[1]);
        $("#cuenta").val(arr[2]);
        $("#observa").val(arr[3]);
        
        $("#idcuentae").val(id);
        $("#btnGuardar").text("MODIFICAR CUENTA");
        $("#modalCuenta").modal('show');
    })

    $("#cuentas").on('click', '.eliminar', function(e){
        e.preventDefault();
        let id = $(this).data('id');
        
        Swal.fire({
            title: "¿Estás seguro en eliminar la Cuenta?",
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('elimina-cuenta', {
                    id
                }, function(data){
                    console.log(data);
                    $('#msj').html(data);
                });
            }
        });
    });

    $("#frmCuenta").on('submit', function(e){
        e.preventDefault();
        let btn = document.querySelector('#btnGuardar'),
            txtbtn = btn.textContent,
            btnHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        btn.setAttribute('disabled', 'disabled');
        btn.innerHTML = `${btnHTML} PROCESANDO...`;

        $.post('registro-cuenta', $(this).serialize(), function(data){
            console.log(data);
            $('[id^="msj-"').text("");                
            if( data.errors ){  
                let errors = data.errors;
                for( let err in errors ){
                    $('#msj-' + err).text(errors[err]);
                }
            }
            $("#msj").html(data);
            btn.removeAttribute('disabled');
            btn.innerHTML = txtbtn;
        });
    });

    const myModalEl = document.getElementById('modalCuenta')
    myModalEl.addEventListener('hidden.bs.modal', event => {
        limpiarCampos();
        $("#msj").html("");
    })
})

function limpiarCampos(){
    $("#frmCuenta")[0].reset();
    $('[id^="msj-"').text("");
    $("#idcuentae").val("");
    $("#btnGuardar").text("REGISTRAR CUENTA");
}
</script>

<?php echo $this->endSection();?>