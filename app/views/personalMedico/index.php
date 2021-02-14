<?php require APPROOT . '/views/inc/header.php'; ?>
    
<div class="container">
    <h2>Gestión de personal médico</h2>
    <p class="lead">Aquí podrás realizar la gestión del personal médico disponibles en el hospital</p>
    <div>
        <?php flash('agregarMedico_success'); ?>          
        <?php flash('eliminarMedico_success'); ?>
    </div>
    <div class="col-md-12">
        <div class="card p-3 shadow bg-info text-light">
            <div class="card-title d-flex justify-content-center align-items-center">
                <div>
                <h5 class="m-0">Personal médico</h5>
                    <p class="m-0 pt-2">Aquí puedes visualizar todo el personal médico del hospital.</p>
                </div>                
                <a class="btn btn-success nav-link text-light mr-3 ml-auto p-2 d-inline-flex align-items-center" href="<?php echo URLROOT; ?>/personalMedico/agregar">
                    <i class="fas fa-plus-circle fa-2x mr-2"></i>
                    <div>Añadir médico</div>
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group m-0">
                                <label for="busquedaEspecialidad">Búsqueda por especialidad:</label>                                        
                                <div class="input-group">
                                <input type="search" name="busquedaEspecialidad" id="busquedaEspecialidad" class="form-control" onsearch="filtrarCitasMedicas('especialidad', this.value)"></input>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" onclick="filtrarCitasMedicas('especialidad', document.getElementById('busquedaEspecialidad').value)"><i class="fas fa-search"></button></i>
                                    </div>
                                </div>                                        
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group m-0">
                                <label for="busquedaMedico">Búsqueda por medico:</label>                                        
                                <div class="input-group">
                                <input type="search" name="busquedaMedico" id="busquedaMedico" class="form-control" onsearch="filtrarCitasMedicas('medico', this.value)"></input>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" onclick="filtrarCitasMedicas('medico', document.getElementById('busquedaMedico').value)"><i class="fas fa-search"></button></i>
                                    </div>
                                </div>                                        
                        </div>
                    </div>
                </div>
                <hr class="hr-filter bg-light light px-3">
                <div class="table-responsive rounded">
                    <table class="table rounded table-striped bg-light text-center" id="table_Medicos">
                        <thead class="thead-dark">
                            <tr class="text-muted">
                                <th>#</th>
                                <th>Médico</th>
                                <th>Especialidad</th>
                                <th>Correo</th>
                                <th>Telefono</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data as $medico) : ?>
                                <tr class="table-row-filter">
                                    <td class="align-middle" id="idUsuario"><?php echo $medico['perfil']->idUsuario ?></td>
                                    <td class="align-middle" id="medico"><?php echo $medico['perfil']->NombreCompleto . ' ' . $medico['perfil']->apellidoCompleto ?></td>
                                    <td class="align-middle" id="especialidad">
                                        <ul class="list-unstyled m-0" style="max-height:75px; overflow:auto;">
                                            <?php foreach($medico['especialidades'] as $especialidad) : ?> 
                                                <li style="border-bottom: 1px solid grey"><?php echo $especialidad->nombreEspecialidad ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </td>
                                    <td class="align-middle" id="correo"><?php echo $medico['perfil']->correo ?></td>
                                    <td class="align-middle" id="telefono"><?php echo $medico['perfil']->telefono ?></td>
                                    <td class="align-middle" id="button"><a class="btn btn-dark btn-sm" href="<?php echo URLROOT; ?>/personalMedico/editar/<?php echo $medico['perfil']->idUsuario ?>"><i class="fas fa-edit text-info"></i></a></td>
                                    <td class="align-middle" id="button1"><button class="btn btn-dark btn-sm" data-toggle="modal" data-target="#personalMedico-password" data-id="<?php echo $medico['perfil']->idUsuario ?>"><i class="fas fa-key text-warning"></i></button></td>
                                    <td class="align-middle" id="button2"><button class="btn btn-dark btn-sm" data-toggle="modal" data-target="#personalMedico-delete" data-id="<?php echo $medico['perfil']->idUsuario ?>"><i class="fas fa-trash text-danger"></i></button></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete modal form -->
<div class="modal fade" id="personalMedico-delete" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content text-center">
                <div class="modal-header ">
                    <h4 class="modal-title">Eliminar personal médico</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>La siguiente acción eliminará permanentemente de la base de datos al médico y todas sus dependencias.</p>
                    <p>¿Está seguro que desea eliminar este item?</p>
                </div>
                <div class="modal-footer ">
                    <a id="btnEliminarMedico" class="btn btn-danger" href="">Eliminar</a>
                </div>
        </div>
    </div>
</div>
<!-- end of Delete modal form -->

<!-- Cambiar contraseña modal form -->
<div class="modal fade" id="personalMedico-password" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content text-center">
                <div class="modal-header ">
                    <h4 class="modal-title">Reseteo de contraseña</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="reset-info">
                    <p>La siguiente acción cambiará la contraseña del usuario permanentemente</p>
                    <p>¿Está seguro que desea resetear la contraseña de este usuario?</p>
                </div>
                <div class="modal-body" id="reset-result" style="display: none">
                    <!-- Resultado reseteo contraseña -->
                </div>
                <div class="modal-footer ">
                    <button id="btnCambiarPass" class="btn btn-danger" data-id="">Resetear contraseña</button>
                </div>
        </div>
    </div>
</div>
<!-- end of Cambiar contraseña modal form -->

<!-- Script reseteo contraseña -->
<script>

    // Carga datos modal eliminar
    $('#personalMedico-delete').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var recipient = button.data('id'); // Extract info from data-* attributes

        var modal = $(this);
        modal.find('#btnEliminarMedico').attr("href", "<?php echo URLROOT; ?>/personalMedico/eliminar/" + recipient);
    });

    // Carga datos modal password
    $('#personalMedico-password').on('show.bs.modal', function (event) {
        resetPassResults();
        var button = $(event.relatedTarget); // Button that triggered the modal
        var recipient = button.data('id'); // Extract info from data-* attributes
        $('#btnCambiarPass').data("id", recipient);
    });

    // Resetear Password
    $('#btnCambiarPass').on('click', function(event){
        $.LoadingOverlay("show");
        var button = $(this);
        var recipient = button.data('id'); // Extract info from data-* attributes
        
        // reseteo de contraseña
        $.get("<?php echo URLROOT . "/usuarios/passwordReset/" ?>" + recipient)
            .done(function (result){
                if(result){
                    var res = $.parseJSON(result);
                    showResetPassResults(res);
                }
                else{
                    var res = {
                        "estado":"ERROR",
                        "resultado":"La contraseña no ha sido actualizada. Intente nuevamente"
                    }
                    showResetPassResults(res);
                }
                $.LoadingOverlay("hide");
            });
    });

    function showResetPassResults(resetPassResult){
        $('#reset-info').hide();
        if(resetPassResult.estado == "OK"){
            $('#reset-result').html("<div class='rounded p-2 my-2 list-group-item-success'>Reseteo exitoso! La nueva contraseña es: <span class='font-weight-bold'>" + resetPassResult.resultado + "</span></div>");            
        }
        else{
            $('#reset-result').html("<div class='rounded p-2 my-2 list-group-item-danger'>" + resetPassResult.resultado + "</div>");            
        }
        $('#reset-result').show('slow');
    }
    function resetPassResults(){
        $('#reset-info').show();
        $('#reset-result').hide();
    }
    
</script>

<!-- Script búsqueda -->
<script>
    var data = [];

    $(document).ready(function () {
        
        // Carga de citas médicas en arreglo
        var Rows = $(".table-row-filter").toArray();

        Rows.forEach((row) => {

            // Mapeo de objetos desde el DOM
            item = {
                "idUsuario": $(row).find("#idUsuario").text(),
                "medico": $(row).find("#medico").text(),
                "especialidad": $(row).find("#especialidad").html(),
                "correo": $(row).find("#correo").text(),
                "telefono": $(row).find("#telefono").text(),
                "button": $(row).find("#button")[0],
                "button1": $(row).find("#button1")[0],
                "button2": $(row).find("#button2")[0]
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
        var resultTableBody = $("#table_Medicos tbody");

        dataFiltered.forEach(item => {
            filterResultHTML += "<tr class=\"table-row-filter\">" + 
                                    "<td class=\"align-middle\" id=\"idUsuario\">" + item.idUsuario + "</td>" +
                                    "<td class=\"align-middle\" id=\"medico\">" + item.medico + "</td>" +
                                    "<td class=\"align-middle\" id=\"especialidad\">" + item.especialidad + "</td>" +
                                    "<td class=\"align-middle\" id=\"correo\">" + item.correo + "</td>" +
                                    "<td class=\"align-middle\" id=\"telefono\">" + item.telefono + "</td>" +
                                    item.button.outerHTML +
                                    item.button1.outerHTML +
                                    item.button2.outerHTML +
                                "</tr>";
        });

        resultTableBody.html(filterResultHTML);
    }

</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
