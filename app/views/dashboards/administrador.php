<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container">
    <div class="my-2">
        <?php flash('cancelarCita_success'); ?>
    </div>
    <!-- Dashboard de Administrador -->
    <?php if($data['dashboard_type'] == 'ADMINISTRADOR') : ?>
        <div class="col-md-12 mt-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="card p-3 shadow bg-info text-light">
                        <div class="card-title d-flex justify-content-center">
                            <div>
                                <h5 class="m-0">Citas médicas agendadas</h5>
                                <p class="m-0 pt-2">Aquí puedes visualizar todas las recetas enviadas a tus pacientes.</p>
                            </div>
                            <a class="btn btn-success nav-link text-light mr-3 ml-auto p-2 d-inline-flex align-items-center" href="<?php echo URLROOT; ?>/consultas/agendar">
                                <i class="fas fa-plus-circle fa-2x mr-2"></i>
                                <div>Añadir cita médica</div>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group m-0">
                                        <label for="busquedaPaciente">Búsqueda por paciente:</label>                                        
                                        <div class="input-group">
                                        <input type="search" name="busquedaPaciente" id="busquedaPaciente" class="form-control" onsearch="filtrarCitasMedicas('paciente', this.value); cleanInputText(document.getElementById('busquedaMedico'))"></input>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button" onclick="filtrarCitasMedicas('paciente', document.getElementById('busquedaPaciente').value); cleanInputText(document.getElementById('busquedaMedico'))"><i class="fas fa-search"></button></i>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-0">
                                        <label for="busquedaMedico">Búsqueda por Médico:</label>                                        
                                        <div class="input-group">
                                        <input type="search" name="busquedaMedico" id="busquedaMedico" class="form-control" onsearch="filtrarCitasMedicas('medico', this.value); cleanInputText(document.getElementById('busquedaPaciente'))"></input>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button" onclick="filtrarCitasMedicas('medico', document.getElementById('busquedaMedico').value); cleanInputText(document.getElementById('busquedaPaciente'))"><i class="fas fa-search"></button></i>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            <hr class="hr-filter bg-light light px-3">
                            <div class="table-responsive rounded" id="table_CitasMedicas">
                                <table class="table rounded table-striped bg-light text-center">
                                    <thead class="thead-dark">
                                        <tr class="text-muted">
                                            <th>#</th>
                                            <th>Fecha</th>
                                            <th>Paciente</th>
                                            <th>Médico</th>
                                            <th>Motivo</th>
                                            <th>Estado</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($data['citasMedicas'] as $citaMedica) : ?>
                                            <tr class="table-row-filter">
                                                <td class="align-middle" id="idCitaMedica"><?php echo $citaMedica->idCitaMedica ?></td>
                                                <td class="align-middle" id="fechaSolicitud"><?php echo date_format(date_create($citaMedica->fechaSolicitud), "d/m/Y") ?></td>
                                                <td class="align-middle" id="paciente"><?php echo $citaMedica->pacienteNombre . ' ' . $citaMedica->pacienteApellido ?></td>
                                                <td class="align-middle" id="medico"><?php echo $citaMedica->medicoNombre . ' ' . $citaMedica->medicoApellido ?></td>
                                                <td class="align-middle" id="motivo"><?php echo $citaMedica->motivo ?></td>
                                                <td class="align-middle" id="estado"><?php echo $citaMedica->estado ?></td>
                                                <td class="align-middle" id="button"><a class="btn btn-transparent btn-sm" href="<?php echo URLROOT; ?>/dashboard/cancelar/<?php echo $citaMedica->idCitaMedica ?>"><i class="fas fa-calendar-times fa-2x text-danger"></i></a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>    
</div>

<script>
    var data = [];

    $(document).ready(function () {
        
        // Carga de citas médicas en arreglo
        var Rows = $(".table-row-filter").toArray();

        Rows.forEach((row) => {

            // Mapeo de objetos desde el DOM
            item = {
                "idCitaMedica": $(row).find("#idCitaMedica").text(),
                "fechaSolicitud": $(row).find("#fechaSolicitud").text(),
                "paciente": $(row).find("#paciente").text(),
                "medico": $(row).find("#medico").text(),
                "motivo": $(row).find("#motivo").text(),
                "estado": $(row).find("#estado").text(),
                "button": $(row).find("#button")[0]
            }
            data.push(item);
        });

        filtrarCitasMedicas('estado', 'AGENDADA');
    });

    function filtrarCitasMedicas(filterName, filterValue){
        if(filterValue != null){
            dataFiltered = data.filter((item) => {
                return item[filterName].toLowerCase().includes(filterValue.toLowerCase());
            });
            showFilterResult(dataFiltered);
        }
        else{
            showFilterResult(data);
        }
    }

    function showFilterResult(dataFiltered){
        var filterResultHTML = "";
        var resultTableBody = $("#table_CitasMedicas tbody");

        dataFiltered.forEach(item => {
            filterResultHTML += "<tr class=\"table-row-filter\">" + 
                                    "<td class=\"align-middle\" id=\"idCitaMedica\">" + item.idCitaMedica + "</td>" +
                                        "<td class=\"align-middle\" id=\"fechaSolicitud\">" + item.fechaSolicitud + "</td>" +
                                        "<td class=\"align-middle\" id=\"paciente\">" + item.paciente + "</td>" +
                                        "<td class=\"align-middle\" id=\"medico\">" + item.medico + "</td>" +
                                        "<td class=\"align-middle\" id=\"motivo\">" + item.motivo + "</td>" +
                                        "<td class=\"align-middle\" id=\"estado\">" + item.estado + "</td>" +
                                        item.button.outerHTML +
                                "</tr>";
        });

        resultTableBody.html(filterResultHTML);
    }

    function cleanInputText(input){
        $(input).val("");
    }

</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
