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
                                <h5 class="mb-3">Reporte Libro de Caja</h5>
                            </div>
                        </div>
                        <form id="frmRepLCaja">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label for="mesCa" class="form-label fw-semibold">Seleccione un mes</label>
                                    <select class="form-select" name="mesCa" id="mesCa" required>
                                        <option value="">Nro de Mes</option>
                                        <?php
                                        for( $i = 1; $i <= 12; $i++ ){                                           
                                            $select_mes = $i == date('m') ? 'selected' : '';
                                            echo "<option value=$i  $select_mes>$i</option>";
                                        }
                                        ?>
                                    </select>
                                    <div id="msj-mesCa" class="form-text text-danger"></div>
                                </div>
                                <div class="col-sm-2">
                                    <label for="anioCa" class="form-label fw-semibold">Año</label>
                                    <input type="text" class="form-control" id="anioCa" name="anioCa" maxlength="4" minlength="4" value="<?=date('Y')?>" required>
                                    <div id="msj-anioCa" class="form-text text-danger"></div>
                                </div>
                                <div class="col-sm-4 col-lg-3 col-xxl-2">
                                    <label for="caja" class="form-label fw-semibold">Seleccione una Caja</label>
                                    <select class="form-select" name="cajaCa" id="cajaCa">
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
                                <div class="col-sm-2">
                                    <label for="tipoRepCa" class="form-label fw-semibold">Tipo</label>
                                    <select class="form-select" name="tipoRepCa" id="tipoRepCa" required>
                                        <option value="pdf">PDF</option>
                                        <option value="excel">EXCEL</option>
                                    </select>
                                    <div id="msj-tipoRepCa" class="form-text text-danger"></div>
                                </div>
                                <div class="col-sm-3 d-flex align-items-end pb-1">
                                    <button type="submit" class="btn btn-danger" id="btnReporteCa">Ver Reporte</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <div class="tab-pane fade" id="libroCompras">
                        xD 2
                    </div>
                    
                </div>
            </div>
        </div>

    </div>
</div>


<div id="msj"></div>


<?php echo $this->endSection();?>

<?php echo $this->section('scripts');?>

<script>

$(function(){

    $('#frmRepLCaja').on('submit', function(e){
        e.preventDefault();
        let btn = document.querySelector('#btnReporteCa'),
            txtbtn = btn.textContent,
            btnHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        btn.setAttribute('disabled', 'disabled');
        btn.innerHTML = `${btnHTML} PROCESANDO...`;

        $.post('genera-reportelcaja', $(this).serialize(), function(data){
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
    })

});

</script>

<?php echo $this->endSection();?>