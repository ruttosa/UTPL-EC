<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container">
    <div class="my-2">
        <?php flash('cancelarCita_success'); ?>
    </div>
    <div class="col-md-12 mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card p-3 shadow bg-info text-light shadow">
                    <div class="card-title d-flex flex-column justify-content-center m-0">
                        <h5 class="m-0">Exámenes</h5>
                        <!-- <a class="btn nav-link text-light ml-auto" disabled='disabled' href="<?php echo URLROOT; ?>/personalMedico/agregar">
                            <i class="fas fa-plus-circle"></i>
                            Añadir cita médico
                        </a> -->
                        <p class="m-0 pt-2">Aquí puedes visualizar todas los exámenes solicitados para tus pacientes.</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group m-0">
                                    <label for="busquedaExamen">Búsqueda por examen:</label>                                        
                                    <div class="input-group">
                                    <input type="search" name="busquedaExamen" id="busquedaExamen" class="form-control" onsearch="filtrarCitasMedicas('nombreExamen', this.value); cleanInputText(document.getElementById('busquedaMedico'))"></input>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" onclick="filtrarCitasMedicas('nombreExamen', document.getElementById('busquedaExamen').value); cleanInputText(document.getElementById('busquedaMedico '))"><i class="fas fa-search"></button></i>
                                        </div>
                                    </div>                                        
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-0">
                                    <label for="busquedaMedico">Búsqueda por Paciente:</label>                                        
                                    <div class="input-group">
                                    <input type="search" name="busquedaMedico" id="busquedaMedico" class="form-control" onsearch="filtrarCitasMedicas('medico', this.value); cleanInputText(document.getElementById('busquedaExamen'))"></input>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" onclick="filtrarCitasMedicas('medico', document.getElementById('busquedaMedico').value); cleanInputText(document.getElementById('busquedaExamen'))"><i class="fas fa-search"></button></i>
                                        </div>
                                    </div>                                        
                                </div>
                            </div>
                        </div>
                        <hr class="hr-filter bg-light light px-3">
                        <div class="table-responsive rounded">
                            <table class="table table-striped bg-light text-center" id="table_Examenes">
                                <thead class="thead-dark">
                                    <tr class="text-muted">
                                        <th>Fecha</th>
                                        <th>Examen</th>
                                        <th># Cita</th>
                                        <th>Especialidad</th>
                                        <th>Médico</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($data['examenes'] as $examen) : ?>
                                        <tr class="table-row-filter">
                                            <td class="align-middle" id="fechaSolicitud"><?php echo date_format(date_create($examen->fechaSolicitud), "d/m/Y") ?></td>
                                            <td class="align-middle" id="nombreExamen"><?php echo $examen->nombreExamen ?></td>
                                            <td class="align-middle" id="idCitaMedica"><?php echo $examen->idCitaMedica ?></td>
                                            <td class="align-middle" id="nombreEspecialidad"><?php echo $examen->nombreEspecialidad ?></td>
                                            <td class="align-middle" id="medico"><?php echo $examen->medicoNombre . ' ' . $examen->medicoApellido ?></td>
                                            <td class="align-middle" id="button"><a class="btn btn-transparent btn-sm" href="<?php echo URLROOT; ?>/consultas/historiaMedica/<?php echo $examen->idCitaMedica ?>"><i class="fas fa-file-medical-alt fa-2x text-info"></i></a></td>
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
</div>

<script>
    var data = [];

    $(document).ready(function () {
        
        // Carga de citas médicas en arreglo
        var Rows = $(".table-row-filter").toArray();

        Rows.forEach((row) => {

            // Mapeo de objetos desde el DOM
            item = {
                "fechaSolicitud": $(row).find("#fechaSolicitud").text(),
                "nombreExamen": $(row).find("#nombreExamen").text(),
                "idCitaMedica": $(row).find("#idCitaMedica").text(),
                "nombreEspecialidad": $(row).find("#nombreEspecialidad").text(),
                "medico": $(row).find("#medico").text(),
                "button": $(row).find("#button")[0]
            }
            data.push(item);
        });
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
        var resultTableBody = $("#table_Examenes tbody");

        dataFiltered.forEach(item => {
            filterResultHTML += "<tr class=\"table-row-filter\">" + 
                                        "<td class=\"align-middle\" id=\"fechaSolicitud\">" + item.fechaSolicitud + "</td>" +
                                        "<td class=\"align-middle\" id=\"nombreExamen\">" + item.nombreExamen + "</td>" +
                                        "<td class=\"align-middle\" id=\"idCitaMedica\">" + item.idCitaMedica + "</td>" +
                                        "<td class=\"align-middle\" id=\"nombreEspecialidad\">" + item.nombreEspecialidad + "</td>" +
                                        "<td class=\"align-middle\" id=\"medico\">" + item.medico + "</td>" +
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