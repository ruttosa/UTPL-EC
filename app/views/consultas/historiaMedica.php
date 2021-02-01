<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container">
    <h2 class="h2">Historia médica <span class="h1">#<?php echo $data['citaMedicaId'] ?></span></h2>
    
    <pc class="lead">Aquí podrás revisar el detalle acerca de la cita médico solicitada y realizar el registro del diagnóstico correspondiente</p>
    <div> 
        <?php flash('registroDiagnositco_success'); ?>
        <?php flash('registroDiagnositco_error'); ?>
    </div>
    <div class="col-md-12">
        <div class="card p-3 shadow bg-info text-light">
            <div class="card-title">
                <h5 class="m-0">Detalle de la cita médica</h5>
            </div>
            <div class="card-body pt-0">
                <!-- Formulario Registro de Diagnóstico -->
                <form action="<?php echo URLROOT . "/consultas/historiaMedica/" . $data['citaMedicaId'] ?>" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="especialidad" class="small">Especialidad:</label>
                                <input name="especialidad" id="especialidad" class="form-control disabled-input" value="<?php echo $data['citaMedica']->especialidad ?>" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fechaCitaMedica" class="small">Fecha:</label>
                                <div class="d-flex">
                                    <input type="text" name="fechaCitaMedica" id="fechaCitaMedica" class="form-control mr-3 disabled-input text-center" value="<?php echo $data['citaMedica']->fechaSolicitud ?>" disabled>
                                    <input type="text" name="horarioCitaMedica" id="horarioCitaMedica" class="form-control disabled-input text-center" value="<?php echo $data['citaMedica']->horaInicio . ' - ' . $data['citaMedica']->horaFin ?>" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="motivoConsulta" class="small">Motivo de consulta:</label>
                                <textarea name="motivoConsulta" id="motivoConsulta" class="form-control disabled-input" rows="4" disabled><?php echo $data['citaMedica']->motivo ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="paciente" class="small">Paciente:</label>
                                <input name="paciente" id="paciente" class="form-control disabled-input" value="<?php echo $data['citaMedica']->pacienteNombre . ' ' . $data['citaMedica']->pacienteApellido ?>" disabled>
                            </div>
                        </div>
                    </div>
                    <hr class="hr-filter">
                <!-- DIAGNOSTICO -->
                    <div class="card-title">
                        <h5 class="m-0">Diagnóstico</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="resumenDiagnostico" class="small">Resumen: <sup>*</sup></label>
                                <input name="resumenDiagnostico" class="form-control <?php echo (!empty($data['resumenDiagnostico_error'])) ? 'is-invalid' : ''; ?>">
                                <span class="invalid-feedback"><?php echo $data['resumenDiagnostico_error']; ?></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="fechaProximoControl" class="small">Próximo control:</label>
                                <input type="date" name="fechaProximoControl" class="form-control <?php echo (!empty($data['fechaProximoControl_error'])) ? 'is-invalid' : ''; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="detalleDiagnostico" class="small">Detalle: <sup>*</sup></label>
                                <textarea type="text" name="detalleDiagnostico" class="form-control  <?php echo (!empty($data['detalleDiagnostico_error'])) ? 'is-invalid' : ''; ?>" rows="4">
                                </textarea>
                                <span class="invalid-feedback"><?php echo $data['detalleDiagnostico_error']; ?></span>
                            </div>
                        </div>      
                    </div> 
                    <div class="row">
                    <!-- RECETAS -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="d-flex justify-content-center">
                                    <label for="recetas" class="small align-self-center">
                                        Recetas 
                                        <input type="text" name="recetasTotales" id="recetasTotales" class="text-center rounded-circle border-0 p-0 label-valor-totales" value="0" readonly>
                                        <input hidden type="text" id="recetasIdCounter" class="text-center rounded-circle border-0 p-0 label-valor-totales" value="0" readonly>
                                    </label>
                                    <button type="button" class="btn nav-link text-light ml-auto" data-toggle="modal" data-target="#recetas-modal" aria-pressed="false" autocomplete="off">
                                        <div class="d-flex justify-content-right">
                                            <span class="mr-2" style="font-size:12px">Añadir</span>
                                            <i class="fas fa-plus-circle"></i>
                                        </div>
                                    </button>
                                </div>
                                <table class="table table-striped bg-light text-center">
                                    <thead class="rounded-top">
                                        <tr class="text-muted">
                                            <th class="p-1 small">#</th>
                                            <th class="p-1 small">Medicamento</th>
                                            <th class="p-1 small"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="recetasMedicas">
                                        <!-- Datos de recetas cargadas dinámicamente -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <!-- EXAMENES -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="d-flex justify-content-center">
                                    <label for="examenes" class="small align-self-center">
                                        Exámenes 
                                        <input type="text" name="examenesTotales" id="examenesTotales" class="text-center rounded-circle border-0 p-0 label-valor-totales" value="0" readonly>
                                        <input hidden type="text" id="examenesIdCounter" class="text-center rounded-circle border-0 p-0 label-valor-totales" value="0" readonly>
                                    </label>
                                    <button type="button" class="btn nav-link text-light ml-auto" data-toggle="modal" data-target="#examenes-modal" aria-pressed="false" autocomplete="off">
                                        <div class="d-flex justify-content-right">
                                            <span class="mr-2" style="font-size:12px">Añadir</span>
                                            <i class="fas fa-plus-circle"></i>
                                        </div>
                                    </button>
                                </div>
                                <table class="table table-striped bg-light text-center">
                                    <thead class="rounded-top">
                                        <tr class="text-muted">
                                            <th class="p-1 small">#</th>
                                            <th class="p-1 small">Exámen</th>
                                            <th class="p-1 small">Ver</th>
                                        </tr>
                                    </thead>
                                    <tbody id="examenesMedicos">
                                        <!-- Datos de examenes cargadas dinámicamente -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>                   
                    <div class="row mt-3">
                        <div class="col-md-4 mx-auto">  
                            <input type="submit" value="Registrar diagnóstico" class="btn btn-block btn-success">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- RECETAS modal form -->
<div class="modal fade" id="recetas-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">Preescripción de receta médica</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p class="text-center">Aquí podrá realizar el registro de las preescripciones de recetas para su paciente</p>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="recetaDetalle">Detalle:</label>
                            <input id="recetaDetalle" name="recetaDetalle" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="recetaIndicaciones">Indicaciones:</label>
                            <textarea id="recetaIndicaciones" name="recetaIndicaciones" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnAgregarReceta" class="btn btn-success" data-dismiss="modal" onclick="agregarReceta()">Agregar</button>
            </div>
        </div>
    </div>
</div>
<!-- end of Delete modal form -->

<!-- EXAMENES modal form -->
<div class="modal fade" id="examenes-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">Solicitud de exámen médico</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p class="text-center">Aquí podrá realizar la solicitud de exámenes médicos para su paciente</p>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="examenDetalle">Exámen:</label>
                            <select id="examenDetalle" name="examenDetalle" class="form-control">
                            <option value=""></option>
                                <!-- opciones de examenes cargadas dinámicamente -->
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="examenIndicaciones">Indicaciones:</label>
                            <textarea id="examenIndicaciones" name="examenIndicaciones" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer ">
                <button type="button" id="btnAgregarExamen" class="btn btn-success" data-dismiss="modal" onclick="agregarExamen()">Agregar</button>
            </div>
        </div>
    </div>
</div>
<!-- end of Delete modal form -->

<script type="text/javascript">

    $(document).ready(function () {
        consultarExamenes();
    });

    function agregarReceta(){
        var inputRecetaDetalle = $("#recetaDetalle");
        var inputRecetaIndicacion = $("#recetaIndicaciones");
        var inputRecetasTotales = $("#recetasTotales");
        var inputIdCounter = $("#recetasIdCounter");
        var nuevaRecetaNumber = parseInt(inputIdCounter.val()) + 1;
        var nuevaRecetaId = "Receta" + nuevaRecetaNumber;
        var tableRecetas = $("#recetasMedicas");
        
        var recetaHTML = 
            "<tr id=\"" + nuevaRecetaId.toLowerCase() + "\">" + 
                "<td><input type=\"text\" id=\"id" + nuevaRecetaId + "\" name=\"recetas[" + nuevaRecetaNumber + "][id]\" value=\"" + nuevaRecetaNumber + "\" hidden>" + nuevaRecetaNumber + "</td>" +
                "<td><input type=\"text\" id=\"detalle" + nuevaRecetaId + "\" name=\"recetas[" + nuevaRecetaNumber + "][detalle]\" value=\"" + inputRecetaDetalle.val() + "\" hidden>" + inputRecetaDetalle.val() + "</td>" +
                "<td hidden><input type=\"text\" id=\"indicaciones" + nuevaRecetaId + "\" name=\"recetas[" + nuevaRecetaNumber + "][indicaciones]\" value=\"" + inputRecetaIndicacion.val() + "\" hidden>" + inputRecetaIndicacion.val() + "</td>" +
                "<td><button type=\"button\" class=\"btn-transparent border-0 p-0\" onclick=\"quitarReceta('" + nuevaRecetaId.toLowerCase() + "')\"><i class=\"fas fa-trash text-danger\"></i></button></td>" +
            "</tr>";      

        tableRecetas.append(recetaHTML);
        inputRecetasTotales.val(parseInt(inputRecetasTotales.val()) + 1);
        inputIdCounter.val(nuevaRecetaNumber);
        inputRecetaDetalle.val('');
        inputRecetaIndicacion.val('');
    }

    function quitarReceta(recetaId){
        var recetaRow = $("#" + recetaId);
        var inputRecetasTotales = $("#recetasTotales");
        var actualValue = parseInt(inputRecetasTotales.val());
        inputRecetasTotales.val(actualValue - 1);
        recetaRow.remove();
    }

    function agregarExamen(){
        var inputExamenDetalle = $("#examenDetalle");
        var inputExamenDetalleText = $("#examenDetalle option:selected").text();
        var inputExamenIndicacion = $("#examenIndicaciones");
        var inputExamenesTotales = $("#examenesTotales");
        var inputIdCounter = $("#examenesIdCounter");
        var nuevoExamenNumber = parseInt(inputIdCounter.val()) + 1;
        var nuevoExamenId = "Examen" + nuevoExamenNumber;
        var tableExamenes = $("#examenesMedicos");
        
        var examenHTML = 
            "<tr id=\"" + nuevoExamenId.toLowerCase() + "\">" + 
                "<td><input type=\"text\" id=\"id" + nuevoExamenId + "\" name=\"examenes[" + nuevoExamenNumber + "][id]\" value=\"" + nuevoExamenNumber + "\" hidden>" + nuevoExamenNumber + "</td>" +
                "<td><input type=\"text\" id=\"detalle" + nuevoExamenId + "\" name=\"examenes[" + nuevoExamenNumber + "][detalle]\" value=\"" + inputExamenDetalle.val() + "\" hidden>" + inputExamenDetalleText + "</td>" +
                "<td hidden><input type=\"text\" id=\"indicaciones" + nuevoExamenId + "\" name=\"examenes[" + nuevoExamenNumber + "][indicaciones]\" value=\"" + inputExamenIndicacion.val() + "\" hidden>" + inputExamenIndicacion.val() + "</td>" +
                "<td><button type=\"button\" class=\"btn-transparent border-0 p-0\" onclick=\"quitarExamen('" + nuevoExamenId.toLowerCase() + "')\"><i class=\"fas fa-trash text-danger\"></i></button></td>" +
            "</tr>";      

        tableExamenes.append(examenHTML);
        inputExamenesTotales.val(parseInt(inputExamenesTotales.val()) + 1);
        inputIdCounter.val(nuevoExamenNumber);
        inputExamenDetalle.val('');
        inputExamenIndicacion.val('');
    }
    
    function quitarExamen(examenId){
        var examenRow = $("#" + examenId);
        var inputExamenesTotales = $("#examenesTotales");
        var actualValue = parseInt(inputExamenesTotales.val());
        inputExamenesTotales.val(actualValue - 1);
        examenRow.remove();
    }

    function consultarExamenes(){
        $.get("<?php echo URLROOT . "/examenes/obtnenerExamenes" ?>")
            .done(function (result){
                var examenes = $.parseJSON(result);
                cargarCatalogoExamenes(examenes);
            })
            .catch(err => {
                alert("Ha ocurrido un error durante la consulta del catálogo de exámenes")
            });
    }

    function cargarCatalogoExamenes(examenes){
        var optionsExamenesHTML = '';

        examenes.forEach(examenData => {
            optionsExamenesHTML += "<option value=\"" + examenData.idExamen + "\" >" + examenData.nombreExamen + "</option>";
        });

        $("#examenDetalle").append(optionsExamenesHTML);
    }

    /* function resizeControl(input){
        input.style.width = ((input.value.length + 1) * 8 * 2) + 'px';
    } */

</script>
<style>
.label-valor-totales{
    cursor: inherit;
    width:24px;
    height:24px;
}
</style>

<?php require APPROOT . '/views/inc/footer.php'; ?>