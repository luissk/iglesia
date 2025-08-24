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
                                <h4 class="mb-0">Responsables de Caja</h4>
                            </div>
                            <div class="col-sm-6 text-end">
                                <a class="btn btn-warning" role="button" data-bs-toggle="modal" data-bs-target="#modalResponsable">Nuevo Responsable de Caja</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive" id="divListar">
                        <table id="responsables" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Responsable</th>
                                    <th>Caja</th>
                                    <th>Opcion</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if( $responsables ){
                                $cont = 0;
                                foreach( $responsables as $r){
                                    $cont++;
                                    $idresponsable = $r['idresponsable_caja'];
                                    $nombre        = $r['re_nombres'];
                                    $idiglesia     = $r['idiglesia'];
                                    $idcaja        = $r['idcaja'];
                                    $caja          = $r['ca_caja'];

                                    $arr = json_encode(
                                        [
                                            $nombre,$idcaja,$caja
                                        ],
                                        JSON_HEX_APOS
                                    );

                                    echo "<tr>";
                                    echo "<td>$cont</td>";
                                    echo "<td>$nombre</td>";
                                    echo "<td>$caja</td>";
                                    echo '<td class="d-flex justify-content-center">';
                                    echo '<a href="javascript:;" class="link-success editar" title="Modificar" data-id='.$idresponsable.' data-arr=\''.$arr.'\'><i class="fa-solid fa-pen-to-square"></i></a>';
                                    //if( $idiglesia != 1 )
                                        echo '<a href="javascript:;" class="link-danger ms-2 eliminar" title="Eliminar" data-id='.$idresponsable.'><i class="fa-solid fa-trash"></i></a>';
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

<div class="modal fade" id="modalResponsable" tabindex="-1" aria-labelledby="modalResponsableLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h1 class="modal-title fs-5" id="tituloModal">Formulario Responsable de Caja</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="frmResponsable">
                <div class="modal-body">            
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="caja" class="form-label">Cajas del Sistema</label>
                            <select class="form-select" name="caja" id="caja">
                                <option value="">Seleccione</option>
                                <?php
                                foreach( $cajas as $c ){
                                    echo "<option value=".$c['idcaja'].">".$c['ca_caja']."</option>";
                                }
                                ?>
                            </select>
                            <div id="msj-caja" class="form-text text-danger"></div>
                        </div>
                        <div class="col-sm-12 mt-3 mb-3">
                            <label for="nombre" class="form-label">Nombre del Responsable</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="" maxlength="100">
                            <div id="msj-nombre" class="form-text text-danger"></div>
                        </div>
                    </div>
                </div>
                <div id="msj"></div>
                <div class="modal-footer py-2">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                    <button type="submit" class="btn btn-danger" id="btnGuardar">REGISTRAR RESPONSABLE</button>
                    <input type="hidden" class="form-control" id="idresponsablee" name="idresponsablee">
                </div>
            </form>
        </div>
    </div>
</div>

<?php echo $this->endSection();?>

<?php echo $this->section('scripts');?>

<script>

    new DataTable('#responsables');

    
$(function(){
    $("#responsables").on('click', '.editar', function(e){
        e.preventDefault();
        let id = $(this).data('id'),
            arr = $(this).data('arr');
        //console.log(arr);

        limpiarCampos();

        $("#caja").val(arr[1]);
        $("#nombre").val(arr[0]);
        
        $("#idresponsablee").val(id);
        $("#btnGuardar").text("MODIFICAR RESPONSABLE");
        $("#modalResponsable").modal('show');
    })

    $("#responsables").on('click', '.eliminar', function(e){
        e.preventDefault();
        let id = $(this).data('id');
        
        Swal.fire({
            title: "¿Estás seguro en eliminar al Responsable?",
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('elimina-responsable', {
                    id
                }, function(data){
                    console.log(data);
                    $('#msj').html(data);
                });
            }
        });
    });

    $("#frmResponsable").on('submit', function(e){
        e.preventDefault();
        let btn = document.querySelector('#btnGuardar'),
            txtbtn = btn.textContent,
            btnHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        btn.setAttribute('disabled', 'disabled');
        btn.innerHTML = `${btnHTML} PROCESANDO...`;

        $.post('registro-responsable', $(this).serialize(), function(data){
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

    const myModalEl = document.getElementById('modalResponsable')
    myModalEl.addEventListener('hidden.bs.modal', event => {
        limpiarCampos();
        $("#msj").html("");
    })
})

function limpiarCampos(){
    $("#frmResponsable")[0].reset();
    $('[id^="msj-"').text("");
    $("#idresponsablee").val("");
    $("#btnGuardar").text("REGISTRAR RESPONSABLE");
}
</script>

<?php echo $this->endSection();?>