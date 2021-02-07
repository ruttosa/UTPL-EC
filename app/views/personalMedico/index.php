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
                <h5 class="m-0">Personal médico</h5>
                <a class="btn nav-link text-light ml-auto" href="<?php echo URLROOT; ?>/personalMedico/agregar">
                    <i class="fas fa-plus-circle"></i>
                    Añadir médico
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive rounded">
                    <table class="table rounded table-striped bg-light text-center">
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
                                <tr>
                                    <td class="align-middle"><?php echo $medico['perfil']->idUsuario ?></td>
                                    <td class="align-middle"><?php echo $medico['perfil']->NombreCompleto . ' ' . $medico['perfil']->apellidoCompleto ?></td>
                                    <td class="align-middle">
                                        <ul class="list-unstyled m-0">
                                            <?php foreach($medico['especialidades'] as $especialidad) : ?> 
                                                <li><?php echo $especialidad->nombreEspecialidad ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </td>
                                    <td class="align-middle"><?php echo $medico['perfil']->correo ?></td>
                                    <td class="align-middle"><?php echo $medico['perfil']->telefono ?></td>
                                    <td class="align-middle"><a class="btn btn-dark btn-sm" href="<?php echo URLROOT; ?>/personalMedico/editar/<?php echo $medico['perfil']->idUsuario ?>"><i class="fas fa-edit text-info"></i></a></td>
                                    <td class="align-middle"><button class="btn btn-dark btn-sm" data-toggle="modal" data-target="#personalMedico-password" data-id="<?php echo $medico['perfil']->idUsuario ?>"><i class="fas fa-key text-warning"></i></button></td>
                                    <td class="align-middle"><button class="btn btn-dark btn-sm" data-toggle="modal" data-target="#personalMedico-delete" data-id="<?php echo $medico['perfil']->idUsuario ?>"><i class="fas fa-trash text-danger"></i></button></td>
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

<?php require APPROOT . '/views/inc/footer.php'; ?>
