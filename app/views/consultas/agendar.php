<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container">
    <h2>Agendar Cita Médica</h2>
    <pc class="lead">Completa el formulario para realizar el agendamiento de una cita médica</p>
    <div> 
        <?php flash('registroConsulta_success'); ?>
        <?php flash('registroConsulta_error'); ?>
    </div>
    <div class="col-md-12">
        <div class="card p-3 shadow bg-info text-light">
            <div class="card-body">
                <form action="<?php echo URLROOT; ?>/consultas/agendar" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="especialidad">Especialidad: <sup>*</sup></label>
                                <select name="especialidad" id="especialidad" class="form-control form-control-lg <?php echo (!empty($data['especialidad_error'])) ? 'is-invalid' : ''; ?>">
                                    <option value=""></option>
                                    <?php foreach($data['especialidades'] as $especialidad) : ?>
                                        <option value="<?php echo $especialidad->idEspecialidad ?>" <?php if($data['especialidad'] == $especialidad->idEspecialidad){echo 'selected';} ?>><?php echo $especialidad->nombreEspecialidad ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="invalid-feedback"><?php echo $data['especialidad_error']; ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fechaCitaMedica">Seleccione una fecha para la consulta: <sup>*</sup></label>
                                <input type="date" name="fechaCitaMedica" id="fechaCitaMedica" onchange="consultarMedicosDisponibles()" value="<?php echo $data['fechaCitaMedica'] ?>"
                                    class="form-control form-control-lg w-50 <?php echo (!empty($data['fechaCitaMedica_error'])) ? 'is-invalid' : ''; ?>">
                                <span class="invalid-feedback"><?php echo $data['fechaCitaMedica_error']; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="apellidoCompleto">Médicos disponibles:</label>
                                <table class="table table-striped bg-light rounded text-center">
                                    <thead class="rounded-top">
                                        <tr class="text-muted">
                                            <th class="p-2 small font-weight-bold">#</th>
                                            <th class="p-2 small font-weight-bold">Médico</th>
                                            <th class="p-2 small font-weight-bold">Horario de atención</th>
                                            <th class="p-2 small font-weight-bold">Agendar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableResult">
                                        <!-- Resultados de búsqueda cargados dinámicamente -->
                                    </tbody>
                                </table>
                                <input type="text" id="doctorSelected" name="doctorSelected" value="<?php echo $data['doctor'] ?>" hidden>
                                <span class="invalid-feedback <?php if($data['doctor_error'] != ''){echo 'd-block';} ?>"><?php echo $data['doctor_error']; ?></span>
                                <input type="text" id="horarioSelected" name="horarioSelected" value="<?php echo $data['horarioAtencion'] ?>" hidden>
                            </div>
                        </div>
                    </div>
                    <hr class="hr-filter">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="paciente">Paciente: <sup>*</sup></label>
                                <select name="paciente" class="form-control form-control-lg <?php echo (!empty($data['paciente_error'])) ? 'is-invalid' : ''; ?>">
                                    <option value=""></option>
                                    <?php foreach($data['pacientes'] as $paciente) : ?>
                                        <option value="<?php echo $paciente->idPaciente ?>" <?php if($data['paciente'] == $paciente->idPaciente){echo 'selected';} ?>><?php echo $paciente->nombreCompleto . " " . $paciente->apellidoCompleto ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="invalid-feedback"><?php echo $data['paciente_error']; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="motivoConsulta">Motivo de la consulta: <sup>*</sup></label>
                                <textarea type="text" name="motivoConsulta" class="form-control form-control-lg <?php echo (!empty($data['motivoConsulta_error'])) ? 'is-invalid' : ''; ?>" rows="4" ><?php echo $data['motivoConsulta'] ?></textarea>
                                <span class="invalid-feedback"><?php echo $data['motivoConsulta_error']; ?></span>
                            </div>
                        </div>
                    </div>                    
                    <div class="row mt-3">
                        <div class="col-md-4 mx-auto">
                            <input type="submit" value="Agendar cita" class="btn btn-block btn-success">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var medicosCargados = <?php if(isset($data['medicosDisponibles'])){ echo json_encode($data['medicosDisponibles']);}else{echo '';} ?>;
        if(medicosCargados){
            showMedicosDisponiblidadResult(medicosCargados);
            var doctorSelected = $("#doctorSelected").val();
            var horaSelected = $("#horarioSelected").val();
            if(doctorSelected && horaSelected){
                seleccionarMedico(doctorSelected, horaSelected); 
            }
        }
    });
    
    function consultarMedicosDisponibles(){
        
        var especialidad = $('#especialidad').val();
        var fechaCitaMedica = $('#fechaCitaMedica').val();
        
        // Consulta Ajax de Médicos disponibles
        var data = {
            "especialidad": especialidad,
            "fechaCitaMedica": fechaCitaMedica
        }
        
        $.post("<?php echo URLROOT . "/consultas/consultaDisponibilidad" ?>", data)
            .done(function (result){
                var medicosDisponibles = $.parseJSON(result);
                showMedicosDisponiblidadResult(medicosDisponibles);
            });
        
    }

    function seleccionarMedico(medicoId, horarioAtencionId){
        var doctorSelected = $("#doctorSelected");
        var horaSelected = $("#horarioSelected");
        var registroId = "#medico" + doctorSelected.val() + horaSelected.val();
        var registroButtonId = "#btnAddMedico" + doctorSelected.val() + horaSelected.val();
        var newRegistroId = "#medico" + medicoId + horarioAtencionId;
        var newRegistroButtonId = "#btnAddMedico" + medicoId + horarioAtencionId;
        
        // Remover estilos
        if(doctorSelected.val() && registroId != newRegistroId){
            $(registroId).removeClass("selected");
            $(registroButtonId).removeClass("active");
        }
        
        // Modificar Valores        
        doctorSelected.val(medicoId);
        horaSelected.val(horarioAtencionId);

        // Aplicar estilos
        $(newRegistroId).addClass("selected");
        $(newRegistroButtonId).addClass("active");               
    }

    function showMedicosDisponiblidadResult(medicosDisponibles){
        var tableResultHtml = "";
        medicosDisponibles.forEach(medicoData => {
            var registroId = "medico" + medicoData.idUsuario + medicoData.idHorarioAtencion;
            var registroButtonId = "btnAddMedico" + medicoData.idUsuario + medicoData.idHorarioAtencion;
            tableResultHtml += 
                "<tr id=\"" + registroId + "\">" +
                    "<td>" + medicoData.idUsuario + "</td>" +
                    "<td>" + medicoData.nombreCompleto + " " + medicoData.apellidoCompleto + "</td>" +
                    "<td>" + medicoData.horaInicio + " - " + medicoData.horaFin +  "</td>" +
                    "<td><button id=\"" + registroButtonId + "\" type=\"button\" class=\"btn btn-transparent btn-sm\" onclick=\"seleccionarMedico(" + medicoData.idUsuario + "," + medicoData.idHorarioAtencion + ");\"><i class=\"fas fa-check text-info rounded-circle p-1 border-1\"></i></button></td>" +
                "</tr>";
        });
        $("#tableResult").html(tableResultHtml);
    }
</script>
<style>
    tr.selected{
        background: #5f9ea04f    !important;
        font-weight: 400;
    }
    .btn.active i{
        color: #28a745 !important;
    }
</style>

<?php require APPROOT . '/views/inc/footer.php'; ?>