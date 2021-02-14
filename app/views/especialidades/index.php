<?php require APPROOT . '/views/inc/header.php'; ?>
    
<div class="container">
    <h2>Gestión de especialidades</h2>
    <p class="lead">Aquí podrás realizar la gestión del catálogo de especialidades disponibles en el hospital</p>
    <div>
        <?php flash('main_error'); ?>
        <?php flash('especialidad_error'); ?>
        <?php flash('especialidad_success'); ?>                
    </div>
    <div class="col-md-12">
        <div class="card p-3 shadow bg-info text-light">
            <div class="card-title d-flex justify-content-center">
                <div>
                    <h5 class="m-0">Especialidades</h5>
                    <p class="m-0 pt-2">Aquí puedes gestionar todas las especialidades disponibles en el hospital.</p>
                </div>
                <a class="btn btn-success nav-link text-light mr-3 ml-auto p-2 d-inline-flex align-items-center" data-toggle="modal" data-target="#especialidades-add">
                    <i class="fas fa-plus-circle fa-2x mr-2"></i>
                    <div> Añadir especialidad</div>
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group m-0">
                                <label for="busquedaEspecialidad">Búsqueda por especialidad:</label>                                        
                                <div class="input-group">
                                <input type="search" name="busquedaEspecialidad" id="busquedaEspecialidad" class="form-control" onsearch="filtrarCitasMedicas('nombreEspecialidad', this.value)"></input>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" onclick="filtrarCitasMedicas('nombreEspecialidad', document.getElementById('busquedaEspecialidad').value)"><i class="fas fa-search"></button></i>
                                    </div>
                                </div>                                        
                        </div>
                    </div>
                </div>
                <hr class="hr-filter bg-light light px-3">
                <div class="table-responsive rounded">
                    <table class="table table-striped bg-light text-center" id="table_Especialidades">
                    <thead class="thead-dark">
                        <tr class="text-muted">
                        <th>#</th>
                        <th>Título</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['especialidades'] as $especialidad) : ?>
                            <tr class="table-row-filter">
                                <td class="align-middle" id="idEspecialidad"><?php echo $especialidad->idEspecialidad ?></td>
                                <td class="align-middle" id="nombreEspecialidad"><?php echo $especialidad->nombreEspecialidad ?></td>
                                <td class="align-middle" id="button"><button class="btn btn-dark btn-sm" data-toggle="modal" data-target="#especialidades-edit" onclick="loadEspecialidadToEdit(<?php echo $especialidad->idEspecialidad ?>, '<?php echo $especialidad->nombreEspecialidad ?>')"><i class="fas fa-edit text-info"></i></button></td>
                                <td class="align-middle" id="button1"><button class="btn btn-dark btn-sm" data-toggle="modal" data-target="#especialidades-delete" onclick="loadEspecialidadToDelete(<?php echo $especialidad->idEspecialidad ?>)"><i class="fas fa-trash text-danger"></i></button></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add modal form -->
<div class="modal fade" id="especialidades-add" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo URLROOT; ?>/especialidades/agregar" method="post">
                <div class="modal-header ">
                    <h4 class="modal-title">Añadir especialidad</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombreEspecialidad">Título especialidad: <sup class="text-danger">*</sup></label>
                        <input type="text" name="nombreEspecialidad" 
                            class="form-control form-control-lg <?php echo (!empty($data['nombreEspecialidad'])) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $data['nombreEspecialidad']; ?>">
                        <span class="invalid-feedback"><?php if(isset($data['nombreEspecialidad_error'])){echo $data['nombreEspecialidad_error'];} ?></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Añadir</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end of Add modal form -->

<!-- Edit modal form -->
<div class="modal fade" id="especialidades-edit" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <form action="<?php echo URLROOT; ?>/especialidades/editar" method="post">
                <div class="modal-header ">
                    <h4 class="modal-title">Editar especialidad</h4>
                    <button type="button" class="close" data-dismiss="modal" onclick="unloadEspecialidadToEdit()">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="text" name="especialidadToEditId" id="especialidadToEditId"
                        class="form-control form-control-lg" hidden="hidden">
                    <input type="text" name="especialidadToEditNombre" id="especialidadToEditNombre"
                        class="form-control form-control-lg">  
                </div>
                <div class="modal-footer ">
                    <button type="submit" class="btn btn-success">Editar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end of Edit modal form -->

<!-- Delete modal form -->
<div class="modal fade" id="especialidades-delete" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <form action="<?php echo URLROOT; ?>/especialidades/eliminar" method="post">
                <div class="modal-header ">
                    <h4 class="modal-title">Eliminar especialidad</h4>
                    <button type="button" class="close" data-dismiss="modal" onclick="unloadEspecialidadToDelete()">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="text" name="especialidadToDelete" id="especialidadToDelete"
                        class="form-control form-control-lg" hidden="hidden">
                    ¿Está seguro que desea eliminar este item?</div>
                <div class="modal-footer ">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end of Delete modal form -->



<script type="text/javascript"> 
    function loadEspecialidadToDelete(id){
        $("#especialidadToDelete").val(id);
    }
    function unloadEspecialidadToDelete(){
        $("#especialidadToDelete").val();
    }
    function loadEspecialidadToEdit(id, nombre){
        $("#especialidadToEditId").val(id);
        $("#especialidadToEditNombre").val(nombre);
    }
    function unloadEspecialidadToEdit(){
        $("#especialidadToEditId").val();
        $("#especialidadToEditNombre").val();
    }
</script>

<script>
    var data = [];

    $(document).ready(function () {
        
        // Carga de citas médicas en arreglo
        var Rows = $(".table-row-filter").toArray();

        Rows.forEach((row) => {

            // Mapeo de objetos desde el DOM
            item = {
                "idEspecialidad": $(row).find("#idEspecialidad").text(),
                "nombreEspecialidad": $(row).find("#nombreEspecialidad").text(),
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
        var resultTableBody = $("#table_Especialidades tbody");

        dataFiltered.forEach(item => {
            filterResultHTML += "<tr class=\"table-row-filter\">" + 
                                    "<td class=\"align-middle\" id=\"idEspecialidad\">" + item.idEspecialidad + "</td>" +
                                        "<td class=\"align-middle\" id=\"nombreEspecialidad\">" + item.nombreEspecialidad + "</td>" +
                                        item.button.outerHTML +
                                        item.button1.outerHTML +
                                "</tr>";
        });

        resultTableBody.html(filterResultHTML);
    }

</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>
