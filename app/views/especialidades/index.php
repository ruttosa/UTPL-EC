<?php require APPROOT . '/views/inc/header.php'; ?>
    
<div class="container">
    <h2>Gestión de especialidades</h2>
    <p class="lead">Aquí podrás realizar la gestión del catálogo de especialidades disponibles en el hospital</p>
    <div>
        <?php flash('especialidad_error'); ?>
        <?php flash('especialidad_success'); ?>                
    </div>
    <div class="col-md-12">
        <div class="card p-3 shadow bg-info text-light">
            <div class="card-title d-flex justify-content-center">
                <h5 class="m-0">Especialidades</h5>
                <a class="btn nav-link text-light ml-auto" data-toggle="modal" data-target="#especialidades-add">
                    <i class="fas fa-plus-circle"></i>
                    Añadir especialidad
                </a>
            </div>
            <div class="card-body">
                <table class="table table-striped bg-light text-center">
                  <thead>
                    <tr class="text-muted">
                      <th>#</th>
                      <th>Título</th>
                      <th>Editar</th>
                      <th>Eliminar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($data['especialidades'] as $especialidad) : ?>
                        <tr>
                            <td><?php echo $especialidad->idEspecialidad ?></td>
                            <td class="col"><?php echo $especialidad->nombreEspecialidad ?></td>
                            <td><button class="btn btn-dark btn-sm" data-toggle="modal" data-target="#especialidades-edit" onclick="loadEspecialidadToEdit(<?php echo $especialidad->idEspecialidad ?>, '<?php echo $especialidad->nombreEspecialidad ?>')"><i class="fas fa-edit text-info"></i></button></td>
                            <td><button class="btn btn-dark btn-sm" data-toggle="modal" data-target="#especialidades-delete" onclick="loadEspecialidadToDelete(<?php echo $especialidad->idEspecialidad ?>)"><i class="fas fa-trash text-danger"></i></button></td>
                        </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
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
<?php require APPROOT . '/views/inc/footer.php'; ?>
