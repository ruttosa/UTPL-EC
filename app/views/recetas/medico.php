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
                        <h5 class="m-0">Recetas</h5>
                        <p class="m-0 pt-2">Aquí puedes visualizar todas las recetas enviadas a tus pacientes.</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group m-0">
                                    <label for="busquedaReceta">Búsqueda por receta:</label>                                        
                                    <div class="input-group">
                                    <input type="search" name="busquedaReceta" id="busquedaReceta" class="form-control" onsearch="filtrarCitasMedicas('detalleMedicacion', this.value); cleanInputText(document.getElementById('busquedaPaciente'))"></input>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" onclick="filtrarCitasMedicas('detalleMedicacion', document.getElementById('busquedaReceta').value); cleanInputText(document.getElementById('busquedaPaciente'))"><i class="fas fa-search"></button></i>
                                        </div>
                                    </div>                                        
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-0">
                                    <label for="busquedaPaciente">Búsqueda por paciente:</label>                                        
                                    <div class="input-group">
                                    <input type="search" name="busquedaPaciente" id="busquedaPaciente" class="form-control" onsearch="filtrarCitasMedicas('paciente', this.value); cleanInputText(document.getElementById('busquedaReceta'))"></input>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" onclick="filtrarCitasMedicas('paciente', document.getElementById('busquedaPaciente').value); cleanInputText(document.getElementById('busquedaReceta'))"><i class="fas fa-search"></button></i>
                                        </div>
                                    </div>                                        
                                </div>
                            </div>
                        </div>
                        <hr class="hr-filter bg-light light px-3">
                        <div class="table-responsive rounded">
                            <table class="table table-striped bg-light text-center"  id="table_Recetas">
                                <thead class="thead-dark">
                                    <tr class="text-muted">
                                        <th>Fecha</th>
                                        <th>Receta</th>
                                        <th>Paciente</th>
                                        <th># Cita</th>
                                        <th>Especialidad</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($data['recetas'] as $receta) : ?>
                                        <tr class="table-row-filter">
                                            <td class="align-middle" id="fechaSolicitud"><?php echo date_format(date_create($receta->fechaSolicitud), "d/m/Y") ?></td>
                                            <td class="align-middle" id="detalleMedicacion"><?php echo $receta->detalleMedicacion ?></td>
                                            <td class="align-middle" id="paciente"><?php echo $receta->pacienteNombre . ' ' . $receta->pacienteApellido ?></td>
                                            <td class="align-middle" id="citaMedicaId"><?php echo $receta->citaMedicaId ?></td>
                                            <td class="align-middle" id="nombreEspecialidad"><?php echo $receta->nombreEspecialidad ?></td>
                                            <td class="align-middle" id="button"><a class="btn btn-transparent btn-sm" href="<?php echo URLROOT; ?>/consultas/historiaMedica/<?php echo $receta->citaMedicaId ?>"><i class="fas fa-capsules fa-2x text-info"></i></a></td>
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

<!-- Script de búsqueda -->
<script>
    var data = [];

    $(document).ready(function () {
        
        // Carga de citas médicas en arreglo
        var Rows = $(".table-row-filter").toArray();

        Rows.forEach((row) => {

            // Mapeo de objetos desde el DOM
            item = {
                "fechaSolicitud": $(row).find("#fechaSolicitud").text(),
                "detalleMedicacion": $(row).find("#detalleMedicacion").text(),
                "paciente": $(row).find("#paciente").text(),
                "citaMedicaId": $(row).find("#citaMedicaId").text(),
                "nombreEspecialidad": $(row).find("#nombreEspecialidad").text(),
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
        var resultTableBody = $("#table_Recetas tbody");

        dataFiltered.forEach(item => {
            filterResultHTML += "<tr class=\"table-row-filter\">" + 
                                        "<td class=\"align-middle\" id=\"fechaSolicitud\">" + item.fechaSolicitud + "</td>" +
                                        "<td class=\"align-middle\" id=\"detalleMedicacion\">" + item.detalleMedicacion + "</td>" +
                                        "<td class=\"align-middle\" id=\"paciente\">" + item.paciente + "</td>" +
                                        "<td class=\"align-middle\" id=\"citaMedicaId\">" + item.citaMedicaId + "</td>" +
                                        "<td class=\"align-middle\" id=\"nombreEspecialidad\">" + item.nombreEspecialidad + "</td>" +
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