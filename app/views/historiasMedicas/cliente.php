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
                        <h5 class="m-0">Historias Médicas</h5>
                        <!-- <a class="btn nav-link text-light ml-auto" disabled='disabled' href="<?php echo URLROOT; ?>/personalMedico/agregar">
                            <i class="fas fa-plus-circle"></i>
                            Añadir cita médico
                        </a> -->
                        <p class="m-0 pt-2">Aquí puedes visualizar el historial de citas médicas solicitadas.</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group m-0">
                                        <label for="busquedaPaciente">Búsqueda por paciente:</label>                                        
                                        <div class="input-group">
                                        <input type="search" name="busquedaPaciente" id="busquedaPaciente" class="form-control" onsearch="filtrarCitasMedicas('paciente', this.value)"></input>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button" onclick="filtrarCitasMedicas('paciente', document.getElementById('busquedaPaciente').value)"><i class="fas fa-search"></button></i>
                                            </div>
                                        </div>                                        
                                </div>
                            </div>
                        </div>
                        <hr class="hr-filter bg-light light px-3">
                        <div class="table-responsive rounded">
                            <table class="table rounded table-striped bg-light text-center" id="table_CitasMedicas">
                                <thead class="thead-dark">
                                    <tr class="text-muted">
                                        <th>#</th>
                                        <th>Fecha</th>
                                        <th>Paciente</th>
                                        <th>Especialidad</th>
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
                                            <td class="align-middle" id="especialidad"><?php echo $citaMedica->especialidad ?></td>
                                            <td class="align-middle" id="medico"><?php echo $citaMedica->medicoNombre . ' ' . $citaMedica->medicoApellido ?></td>
                                            <td class="align-middle" id="motivo"><?php echo $citaMedica->motivo ?></td>
                                            <td class="align-middle" id="estado"><?php echo $citaMedica->estado ?></td>
                                            <td class="align-middle" id="button"><a class="btn btn-transparent btn-sm" href="<?php echo URLROOT; ?>/consultas/historiaMedica/<?php echo $citaMedica->idCitaMedica ?>"><i class="fas fa-notes-medical fa-2x text-info"></i></a></td>
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
                "idCitaMedica": $(row).find("#idCitaMedica").text(),
                "fechaSolicitud": $(row).find("#fechaSolicitud").text(),
                "paciente": $(row).find("#paciente").text(),
                "especialidad": $(row).find("#especialidad").text(),
                "medico": $(row).find("#medico").text(),
                "motivo": $(row).find("#motivo").text(),
                "estado": $(row).find("#estado").text(),
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
        var resultTableBody = $("#table_CitasMedicas tbody");

        dataFiltered.forEach(item => {
            filterResultHTML += "<tr class=\"table-row-filter\">" + 
                                    "<td class=\"align-middle\" id=\"idCitaMedica\">" + item.idCitaMedica + "</td>" +
                                        "<td class=\"align-middle\" id=\"fechaSolicitud\">" + item.fechaSolicitud + "</td>" +
                                        "<td class=\"align-middle\" id=\"paciente\">" + item.paciente + "</td>" +
                                        "<td class=\"align-middle\" id=\"especialidad\">" + item.especialidad + "</td>" +
                                        "<td class=\"align-middle\" id=\"medico\">" + item.medico + "</td>" +
                                        "<td class=\"align-middle\" id=\"motivo\">" + item.motivo + "</td>" +
                                        "<td class=\"align-middle\" id=\"estado\">" + item.estado + "</td>" +
                                        item.button.outerHTML +
                                "</tr>";
        });

        resultTableBody.html(filterResultHTML);
    }

</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>