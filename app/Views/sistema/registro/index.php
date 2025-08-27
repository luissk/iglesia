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
                                <a class="btn btn-warning" role="button" data-bs-toggle="modal" data-bs-target="#modalLCaja" id="btnModalLCaja">Nuevo Registro L. Caja</a>
                            </div>
                        </div>
                        <div class="row table-responsive mt-3" id="">
                            <table id="tblLibroCaja" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Caja</th>
                                        <th>Opcion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                /* if( $cajas ){
                                    $cont = 0;
                                    foreach( $cajas as $c){
                                        $cont++;
                                        $idcaja = $c['idcaja'];
                                        $caja   = $c['ca_caja'];

                                        $arr = json_encode(
                                            [
                                                $caja
                                            ],
                                            JSON_HEX_APOS
                                        );

                                        echo "<tr>";
                                        echo "<td>$cont</td>";
                                        echo "<td>$caja</td>";
                                        echo '<td class="d-flex justify-content-center">';
                                        echo '<a href="javascript:;" class="link-success editar" title="Modificar" data-id='.$idcaja.' data-arr=\''.$arr.'\'><i class="fa-solid fa-pen-to-square"></i></a>';
                                        //if( $idiglesia != 1 )
                                            echo '<a href="javascript:;" class="link-danger ms-2 eliminar" title="Eliminar" data-id='.$idcaja.'><i class="fa-solid fa-trash"></i></a>';
                                        echo '</td>';
                                        echo "</tr>";                                    
                                    }
                                } */
                                ?>
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
                                <a class="btn btn-warning" role="button" data-bs-toggle="modal" data-bs-target="#modalLCompras">Nuevo Registro L. Compra</a>
                            </div>
                        </div>
                        <div class="row table-responsive mt-3" id="">
                            <table id="tblLibroCompra" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Caja</th>
                                        <th>Opcion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                /* if( $cajas ){
                                    $cont = 0;
                                    foreach( $cajas as $c){
                                        $cont++;
                                        $idcaja = $c['idcaja'];
                                        $caja   = $c['ca_caja'];

                                        $arr = json_encode(
                                            [
                                                $caja
                                            ],
                                            JSON_HEX_APOS
                                        );

                                        echo "<tr>";
                                        echo "<td>$cont</td>";
                                        echo "<td>$caja</td>";
                                        echo '<td class="d-flex justify-content-center">';
                                        echo '<a href="javascript:;" class="link-success editar" title="Modificar" data-id='.$idcaja.' data-arr=\''.$arr.'\'><i class="fa-solid fa-pen-to-square"></i></a>';
                                        //if( $idiglesia != 1 )
                                            echo '<a href="javascript:;" class="link-danger ms-2 eliminar" title="Eliminar" data-id='.$idcaja.'><i class="fa-solid fa-trash"></i></a>';
                                        echo '</td>';
                                        echo "</tr>";                                    
                                    }
                                } */
                                ?>
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

<div class="modal fade" id="modalLCaja" tabindex="-1" aria-labelledby="modalLCajaLabel" aria-hidden="true">
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
$(function(){
    var $table = $('#tblLibroCaja').dataTable({
        "pageLength": 50
    });

    var $table = $('#tblLibroCompra').dataTable({
        "pageLength": 50
    });

    $('#btnModalLCaja').on('click', function(e){
        formLCaja();
    })
});

function formLCaja(){
    $('#divLCompra').html('Abriendo formulario...');
    $.post('formularioLCaja', {
        id:1
    }, function(data){
        $('#divLCompra').html(data);
    });
}
</script>
  


<?php echo $this->endSection();?>