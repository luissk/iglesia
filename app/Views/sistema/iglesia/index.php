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
                                <h4 class="mb-0">Iglesias del Sistema</h4>
                            </div>
                            <div class="col-sm-6 text-end">
                                <a class="btn btn-warning" role="button" data-bs-toggle="modal" data-bs-target="#modalIglesia">Nueva Iglesia</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive" id="divListar">
                        <table id="iglesias" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Iglesia</th>
                                    <th>Pastor</th>
                                    <th>Dirección</th>
                                    <th>Opcion</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if( $iglesias ){
                                $cont = 0;
                                foreach( $iglesias as $i){
                                    $cont++;
                                    $idiglesia = $i['idiglesia'];
                                    $iglesia   = $i['ig_iglesia'];
                                    $direccion = $i['ig_direccion'];
                                    $pastor    = $i['ig_pastor'];

                                    $arr = json_encode(
                                        [
                                            $iglesia,$direccion,$pastor
                                        ],
                                        JSON_HEX_APOS
                                    );

                                    echo "<tr>";
                                    echo "<td>$cont</td>";
                                    echo "<td>$iglesia</td>";
                                    echo "<td>$pastor</td>";
                                    echo "<td>$direccion</td>";
                                    echo '<td class="d-flex justify-content-center">';
                                    echo '<a href="javascript:;" class="link-success editar" title="Modificar" data-id='.$idiglesia.' data-arr=\''.$arr.'\'><i class="fa-solid fa-pen-to-square"></i></a>';
                                    if( $idiglesia != 1 )
                                        echo '<a href="javascript:;" class="link-danger ms-2 eliminar" title="Eliminar" data-id='.$idiglesia.'><i class="fa-solid fa-trash"></i></a>';
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

<div class="modal fade" id="modalIglesia" tabindex="-1" aria-labelledby="modalIglesiaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h1 class="modal-title fs-5" id="tituloModal">Formulario Iglesia</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="frmIglesia">
                <div class="modal-body">            
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label for="iglesia" class="form-label">Iglesia</label>
                            <input type="text" class="form-control" id="iglesia" name="iglesia" value="" maxlength="100">
                            <div id="msj-iglesia" class="form-text text-danger"></div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="pastor" class="form-label">Pastor</label>
                            <input type="text" class="form-control" id="pastor" name="pastor" value="" maxlength="100">
                            <div id="msj-pastor" class="form-text text-danger"></div>
                        </div>                        
                        <div class="col-sm-6 mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" value="" maxlength="100">
                            <div id="msj-direccion" class="form-text text-danger"></div>
                        </div>
                    </div>
                </div>
                <div id="msj"></div>
                <div class="modal-footer py-2">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                    <button type="submit" class="btn btn-danger" id="btnGuardar">REGISTRAR IGLESIA</button>
                    <input type="hidden" class="form-control" id="id_iglesiae" name="id_iglesiae">
                </div>
            </form>
        </div>
    </div>
</div>

<?php echo $this->endSection();?>

<?php echo $this->section('scripts');?>

<script>

    new DataTable('#iglesias');

    
$(function(){
    $("#iglesias").on('click', '.editar', function(e){
        e.preventDefault();
        let id = $(this).data('id'),
            arr = $(this).data('arr');
        //console.log(arr);

        limpiarCampos();

        $("#iglesia").val(arr[0]);
        $("#direccion").val(arr[1]);
        $("#pastor").val(arr[2]);
        
        $("#id_iglesiae").val(id);
        $("#btnGuardar").text("MODIFICAR IGLESIA");
        $("#modalIglesia").modal('show');
    })

    $("#iglesias").on('click', '.eliminar', function(e){
        e.preventDefault();
        let id = $(this).data('id');
        
        Swal.fire({
            title: "¿Estás seguro en eliminar la Iglesia?",
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('elimina-iglesia', {
                    id
                }, function(data){
                    console.log(data);
                    $('#msj').html(data);
                });
            }
        });
    });

    $("#frmIglesia").on('submit', function(e){
        e.preventDefault();
        let btn = document.querySelector('#btnGuardar'),
            txtbtn = btn.textContent,
            btnHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        btn.setAttribute('disabled', 'disabled');
        btn.innerHTML = `${btnHTML} PROCESANDO...`;

        $.post('registro-iglesia', $(this).serialize(), function(data){
            //console.log(data);
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

    const myModalEl = document.getElementById('modalIglesia')
    myModalEl.addEventListener('hidden.bs.modal', event => {
        limpiarCampos();
        $("#msj").html("");
    })
})

function limpiarCampos(){
    $("#frmIglesia")[0].reset();
    $('[id^="msj-"').text("");
    $("#id_iglesiae").val("");
    $("#btnGuardar").text("REGISTRAR IGLESIA");
}
</script>

<?php echo $this->endSection();?>