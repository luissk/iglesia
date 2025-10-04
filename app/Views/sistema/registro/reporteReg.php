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
                        <a class="nav-link" data-bs-toggle="tab" data-bs-target="#libroDiario" href="#libroDiario">LIBRO DIARIO</a>
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
                        <div class="row">
                            <div class="col-sm-6 d-flex align-items-center">
                                <h5 class="mb-3">Reporte Libro de Compras</h5>
                            </div>
                        </div>
                        <form id="frmRepLCompra">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label for="mesCo" class="form-label fw-semibold">Seleccione un mes</label>
                                    <select class="form-select" name="mesCo" id="mesCo" required>
                                        <option value="">Nro de Mes</option>
                                        <?php
                                        for( $i = 1; $i <= 12; $i++ ){                                           
                                            $select_mes = $i == date('m') ? 'selected' : '';
                                            echo "<option value=$i  $select_mes>$i</option>";
                                        }
                                        ?>
                                    </select>
                                    <div id="msj-mesCo" class="form-text text-danger"></div>
                                </div>
                                <div class="col-sm-2">
                                    <label for="anioCo" class="form-label fw-semibold">Año</label>
                                    <input type="text" class="form-control" id="anioCo" name="anioCo" maxlength="4" minlength="4" value="<?=date('Y')?>" required>
                                    <div id="msj-anioCo" class="form-text text-danger"></div>
                                </div>
                                <div class="col-sm-2">
                                    <label for="tipoRepCo" class="form-label fw-semibold">Tipo</label>
                                    <select class="form-select" name="tipoRepCo" id="tipoRepCo" required>
                                        <option value="pdf">PDF</option>
                                        <option value="excel">EXCEL</option>
                                    </select>
                                    <div id="msj-tipoRepCo" class="form-text text-danger"></div>
                                </div>
                                <div class="col-sm-3 d-flex align-items-end pb-1">
                                    <button type="submit" class="btn btn-danger" id="btnReporteCo">Ver Reporte</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <div class="tab-pane fade" id="libroDiario">
                        <div class="row">
                            <div class="row">
                                <div class="col-sm-6 d-flex align-items-center">
                                    <h5 class="mb-3">Reporte Libro Diario</h5>
                                </div>
                            </div>
                            <form id="frmRepLDiario">
                            <div class="row">
                                <div class="col-sm-2">
                                    <label for="mesDi" class="form-label fw-semibold">Seleccione un mes</label>
                                    <select class="form-select" name="mesDi" id="mesDi" required>
                                        <option value="">Nro de Mes</option>
                                        <?php
                                        for( $i = 1; $i <= 12; $i++ ){                                           
                                            $select_mes = $i == date('m') ? 'selected' : '';
                                            echo "<option value=$i  $select_mes>$i</option>";
                                        }
                                        ?>
                                    </select>
                                    <div id="msj-mesDi" class="form-text text-danger"></div>
                                </div>
                                <div class="col-sm-2">
                                    <label for="anioDi" class="form-label fw-semibold">Año</label>
                                    <input type="text" class="form-control" id="anioDi" name="anioDi" maxlength="4" minlength="4" value="<?=date('Y')?>" required>
                                    <div id="msj-anioDi" class="form-text text-danger"></div>
                                </div>
                                <!-- <div class="col-sm-2">
                                    <label for="tipoRepDi" class="form-label fw-semibold">Tipo</label>
                                    <select class="form-select" name="tipoRepDi" id="tipoRepDi" required>
                                        <option value="pdf">PDF</option>
                                        <option value="excel">EXCEL</option>
                                    </select>
                                    <div id="msj-tipoRepDi" class="form-text text-danger"></div>
                                </div> -->
                                <div class="col-sm-3 d-flex align-items-end pb-1">
                                    <button type="submit" class="btn btn-danger" id="btnReporteDi">Ver Reporte</button>
                                </div>
                            </div>
                            </form>
                            
                            <div class="row mt-4">
                                <div class="col-sm-2">
                                    <label for="cuentaLD" class="form-label fw-semibold">Cuenta</label>
                                    <input type="text" class="form-control" id="cuentaLD" name="cuentaLD" maxlength="3" value="140" required>
                                    <div id="msj-cuentaLD" class="form-text text-danger"></div>
                                </div>
                                <div class="col-sm-4 d-flex align-items-end pb-1">
                                    <button class="btn btn-success" id="btnReportePorCuenta">Por Cuenta</button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 table-responsive mt-3" id="msjCuenta"></div>
                            </div>
                        </div>
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
    });

    $('#frmRepLCompra').on('submit', function(e){
        e.preventDefault();
        let btn = document.querySelector('#btnReporteCo'),
            txtbtn = btn.textContent,
            btnHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        btn.setAttribute('disabled', 'disabled');
        btn.innerHTML = `${btnHTML} PROCESANDO...`;

        $.post('genera-reportelcompra', $(this).serialize(), function(data){
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

    $('#frmRepLDiario').on('submit', function(e){
        e.preventDefault();
        let btn = document.querySelector('#btnReporteDi'),
            txtbtn = btn.textContent,
            btnHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        btn.setAttribute('disabled', 'disabled');
        btn.innerHTML = `${btnHTML} PROCESANDO...`;

        $.post('genera-reportediario', $(this).serialize(), function(data){
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

    $('#btnReportePorCuenta').on('click', function(e){
        e.preventDefault();
        let btn = document.querySelector('#btnReportePorCuenta'),
            txtbtn = btn.textContent,
            btnHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        btn.setAttribute('disabled', 'disabled');
        btn.innerHTML = `${btnHTML} PROCESANDO...`;

        $("#msjCuenta").html("...CARGANDO...");
        $.post('genera-reportecuenta', {
            mesDi: $("#mesDi").val(),
            anioDi: $("#anioDi").val(),
            cuentaLD: $("#cuentaLD").val()
        }, function(data){
            //console.log(data);
            $('[id^="msj-"').text("");                
            if( data.errors ){  
                let errors = data.errors;
                for( let err in errors ){
                    $('#msj-' + err).text(errors[err]);
                }
            }
            $("#msjCuenta").html(data);
            btn.removeAttribute('disabled');
            btn.innerHTML = txtbtn;
        });
    });

});

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