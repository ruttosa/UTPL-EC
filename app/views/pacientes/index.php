<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container">
    <h2>Gestión de pacientes</h2>
    <p class="lead">Aquí podrás realizar la gestión de los pacientes que tengas a tú cargo</p>
    <div>
        <?php flash('agregarPaciente_success'); ?>          
        <?php flash('eliminarPaciente_success'); ?>
    </div>
    <div class="col-md-12">
        <div class="card p-3 shadow bg-info text-light">
            <div class="card-title d-flex justify-content-center">
                <div>
                    <h5 class="m-0">Mis pacientes</h5>
                    <p class="m-0 pt-2">Aquí puedes gestionar la información de todos tus pacientes.</p>
                </div>
                <a class="btn btn-success nav-link text-light mr-3 ml-auto p-2 d-inline-flex align-items-center" href="<?php echo URLROOT; ?>/pacientes/agregar">
                    <i class="fas fa-plus-circle fa-2x mr-2"></i>
                    <div>Añadir paciente</div>
                </a>
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
                    <table class="table table-striped bg-light text-center" id="table_Pacientes">
                    <thead class="thead-dark">
                        <tr class="text-muted">
                        <th>#</th>
                        <th>Paciente</th>
                        <th>Fecha Nacimiento</th>
                        <th>Telefono</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['pacientes'] as $paciente) : ?>
                            <tr class="table-row-filter">
                                <td class="align-middle" id="idPaciente"><?php echo $paciente->idPaciente ?></td>
                                <td class="align-middle" id="paciente"><?php echo $paciente->nombreCompleto . ' ' . $paciente->apellidoCompleto ?></td>
                                <td class="align-middle" id="fechaNacimiento"><?php echo date_format(date_create($paciente->fechaNacimiento), "d/m/Y") ?></td>
                                <td class="align-middle" id="telefono"><?php echo $paciente->telefono ?></td>
                                <td class="align-middle" id="button"><a class="btn btn-dark btn-sm" href="<?php echo URLROOT; ?>/pacientes/editar/<?php echo $paciente->idPaciente ?>"><i class="fas fa-edit text-info"></i></a></td>
                                <td class="align-middle" id="button1"><button class="btn btn-dark btn-sm" data-toggle="modal" data-target="#paciente-delete" data-id="@<?php echo $paciente->idPaciente ?>"><i class="fas fa-trash text-danger"></i></button></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    </table>
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
                "idPaciente": $(row).find("#idPaciente").text(),
                "paciente": $(row).find("#paciente").text(),
                "fechaNacimiento": $(row).find("#fechaNacimiento").text(),
                "telefono": $(row).find("#telefono").text(),
                "button": $(row).find("#button")[0],
                "button1": $(row).find("#button1")[0]
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
        var resultTableBody = $("#table_Pacientes tbody");

        dataFiltered.forEach(item => {
            filterResultHTML += "<tr class=\"table-row-filter\">" + 
                                    "<td class=\"align-middle\" id=\"idPaciente\">" + item.idPaciente + "</td>" +
                                        "<td class=\"align-middle\" id=\"paciente\">" + item.paciente + "</td>" +
                                        "<td class=\"align-middle\" id=\"fechaNacimiento\">" + item.fechaNacimiento + "</td>" +
                                        "<td class=\"align-middle\" id=\"telefono\">" + item.telefono + "</td>" +
                                        item.button.outerHTML +
                                        item.button1.outerHTML +
                                "</tr>";
        });

        resultTableBody.html(filterResultHTML);
    }

</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>