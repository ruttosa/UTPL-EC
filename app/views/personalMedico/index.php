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
            <div class="card-title d-flex justify-content-center">
                <h5 class="m-0">Personal médico</h5>
                <a class="btn nav-link text-light ml-auto" href="<?php echo URLROOT; ?>/personalMedico/agregar">
                    <i class="fas fa-plus-circle"></i>
                    Añadir médico
                </a>
            </div>
            <div class="card-body">
                <table class="table table-striped bg-light text-center">
                  <thead>
                    <tr class="text-muted">
                      <th>#</th>
                      <th>Especialidad</th>
                      <th>Nombre</th>
                      <th>Apellido</th>
                      <th>Telefono</th>
                      <th>Editar</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($data as $medico) : ?>
                        <tr>
                            <td><?php echo $medico['perfil']->idUsuario ?></td>
                            <td>
                            <?php foreach($medico['especialidades'] as $especialidad) : ?> 
                                <?php echo $especialidad->nombreEspecialidad ?>,
                            <?php endforeach; ?>
                            </td>
                            <td><?php echo $medico['perfil']->NombreCompleto ?></td>
                            <td><?php echo $medico['perfil']->apellidoCompleto ?></td>
                            <td><?php echo $medico['perfil']->telefono ?></td>
                            <td><a class="btn btn-dark btn-sm" href="<?php echo URLROOT; ?>/personalMedico/editar/<?php echo $medico['perfil']->idUsuario ?>"><i class="fas fa-edit text-info"></i></a></td>
                            <td><button class="btn btn-dark btn-sm" data-toggle="modal" data-target="#personalMedico-delete" data-id="@<?php echo $medico['perfil']->idUsuario ?>"><i class="fas fa-trash text-danger"></i></button></td>
                        </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
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
                    <a id="btnEliminar" class="btn btn-danger" href="">Eliminar</a>
                </div>
        </div>
    </div>
</div>
<!-- end of Delete modal form -->

<script>

    $('#personalMedico-delete').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var recipient = button.data('id'); // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('#btnEliminar').attr("href", "<?php echo URLROOT; ?>/personalMedico/eliminar/<?php echo $medico['perfil']->idUsuario ?>");
    });
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
