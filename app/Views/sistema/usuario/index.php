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
                                <h4 class="mb-0">Usuarios del Sistema</h4>
                            </div>
                            <div class="col-sm-6 text-end">
                                <a class="btn btn-warning" role="button" data-bs-toggle="modal" data-bs-target="#modalUsuario">Nuevo Usuario</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive" id="divListar">
                        <table id="usuarios" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Usuario</th>
                                    <th>Tipo</th>
                                    <th>Nombre</th>
                                    <th>Iglesia</th>
                                    <th>Opcion</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            if( $usuarios ){
                                $cont = 0;
                                foreach( $usuarios as $u){
                                    $cont++;
                                    $idusuario      = $u['idusuario'];
                                    $idiglesia      = $u['idiglesia'];
                                    $idtipo_usuario = $u['idtipo_usuario'];
                                    $usuario        = $u['us_usuario'];
                                    $tipo           = $u['tu_tipo'];
                                    $nombre         = $u['us_nombre'];
                                    $iglesia        = $u['ig_iglesia'];

                                    $arr = json_encode(
                                        [
                                            $usuario,$nombre,$idtipo_usuario,$idiglesia
                                        ],
                                        JSON_HEX_APOS
                                    );

                                    echo "<tr>";
                                    echo "<td>$cont</td>";
                                    echo "<td>$usuario</td>";
                                    echo "<td>$tipo</td>";
                                    echo "<td>$nombre</td>";
                                    echo "<td>$iglesia</td>";
                                    echo '<td class="d-flex justify-content-center">';
                                    if( session('idtipo_usuario') == 1 && $idtipo_usuario == 1 ){
                                        echo '<a href="javascript:;" class="link-success editar" title="Modificar" data-id='.$idusuario.' data-arr=\''.$arr.'\'><i class="fa-solid fa-pen-to-square"></i></a>';
                                    }else if( session('idtipo_usuario') == 1 && $idtipo_usuario == 2 ){
                                        echo '<a href="javascript:;" class="link-success editar" title="Modificar" data-id='.$idusuario.' data-arr=\''.$arr.'\'><i class="fa-solid fa-pen-to-square"></i></a>';
                                        echo '<a href="javascript:;" class="link-danger ms-2 eliminar" title="Eliminar" data-id='.$idusuario.'><i class="fa-solid fa-trash"></i></a>';
                                    }else if( session('idtipo_usuario') == 1 && $idtipo_usuario == 3 ){
                                        echo "-";
                                    }else if( session('idtipo_usuario') == 2 && $idtipo_usuario == 2 ){
                                        echo '<a href="javascript:;" class="link-success editar" title="Modificar" data-id='.$idusuario.' data-arr=\''.$arr.'\'><i class="fa-solid fa-pen-to-square"></i></a>';
                                    }else if( session('idtipo_usuario') == 2 && $idtipo_usuario == 3 ){
                                        echo '<a href="javascript:;" class="link-success editar" title="Modificar" data-id='.$idusuario.' data-arr=\''.$arr.'\'><i class="fa-solid fa-pen-to-square"></i></a>';
                                        echo '<a href="javascript:;" class="link-danger ms-2 eliminar" title="Eliminar" data-id='.$idusuario.'><i class="fa-solid fa-trash"></i></a>';
                                    }
                                    
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

<div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="modalUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h1 class="modal-title fs-5" id="tituloModal">Formulario Usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="frmUsuario">
                <div class="modal-body">            
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" value="" maxlength="45">
                            <div id="msj-usuario" class="form-text text-danger"></div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" class="form-control" id="password" name="password" value="" maxlength="20">
                            <div id="msj-password" class="form-text text-danger"></div>
                        </div>                        
                        <div class="col-sm-6 mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="" maxlength="100">
                            <div id="msj-nombre" class="form-text text-danger"></div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="tipo" class="form-label">Tipo usuario</label>
                            <select class="form-select" name="tipo" id="tipo">
                                <option value="">Seleccione</option>
                                <?php
                                foreach( $tipos as $tu ){
                                    echo "<option value=".$tu['idtipo_usuario'].">".$tu['tu_tipo']."</option>";
                                }
                                ?>
                            </select>
                            <div id="msj-tipo" class="form-text text-danger"></div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label for="iglesia" class="form-label">Iglesia</label>
                            <select class="form-select" name="iglesia" id="iglesia">
                                <option value="">Seleccione</option>
                                <?php
                                foreach( $iglesias as $ig){
                                    echo "<option value=".$ig['idiglesia'].">".$ig['ig_iglesia']."</option>";
                                }
                                ?>
                            </select>
                            <div id="msj-iglesia" class="form-text text-danger"></div>
                        </div>
                    </div>
                </div>
                <div id="msj"></div>
                <div class="modal-footer py-2">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                    <button type="submit" class="btn btn-danger" id="btnGuardar">REGISTRAR USUARIO</button>
                    <input type="hidden" class="form-control" id="id_usuarioe" name="id_usuarioe">
                </div>
            </form>
        </div>
    </div>
</div>

<?php echo $this->endSection();?>

<?php echo $this->section('scripts');?>

<script>

    new DataTable('#usuarios');

    
$(function(){
    $("#usuarios").on('click', '.editar', function(e){
        e.preventDefault();
        let id = $(this).data('id'),
            arr = $(this).data('arr');
        //console.log(arr);

        limpiarCampos();

        $("#usuario").val(arr[0]);
        $("#nombre").val(arr[1]);
        $("#tipo").val(arr[2]);
        $("#iglesia").val(arr[3]);

        if( arr[3] == 1 || arr[2] == 2 ){
            $("#tipo").attr('disabled',true);
            $("#iglesia").attr('disabled', true);
        }
        
        $("#id_usuarioe").val(id);
        $("#btnGuardar").text("MODIFICAR USUARIO");
        $("#modalUsuario").modal('show');
    })

    $("#usuarios").on('click', '.eliminar', function(e){
        e.preventDefault();
        let id = $(this).data('id');
        
        Swal.fire({
            title: "¿Estás seguro en eliminar al Usuario?",
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('elimina-usuario', {
                    id
                }, function(data){
                    console.log(data);
                    $('#msj').html(data);
                });
            }
        });
    });

    $("#frmUsuario").on('submit', function(e){
        e.preventDefault();
        let btn = document.querySelector('#btnGuardar'),
            txtbtn = btn.textContent,
            btnHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        btn.setAttribute('disabled', 'disabled');
        btn.innerHTML = `${btnHTML} PROCESANDO...`;

        $.post('registro-usuario', $(this).serialize(), function(data){
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

    const myModalEl = document.getElementById('modalUsuario')
    myModalEl.addEventListener('hidden.bs.modal', event => {
        limpiarCampos();
        $("#msj").html("");
    })
})

function limpiarCampos(){
    $("#frmUsuario")[0].reset();
    $('[id^="msj-"').text("");
    $("#id_usuarioe").val("");
    $("#btnGuardar").text("REGISTRAR USUARIO");
    $("#tipo").removeAttr('disabled');
    $("#iglesia").removeAttr('disabled');
}
</script>

<?php echo $this->endSection();?>