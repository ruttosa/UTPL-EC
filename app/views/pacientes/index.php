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
                <h5 class="m-0">Mis pacientes</h5>
                <a class="btn nav-link text-light ml-auto" href="<?php echo URLROOT; ?>/pacientes/agregar">
                    <i class="fas fa-plus-circle"></i>
                    Añadir paciente
                </a>
            </div>
            <div class="card-body">
                <table class="table table-striped bg-light text-center">
                  <thead>
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
                    <?php foreach($data as $paciente) : ?>
                        <tr>
                            <td><?php echo $paciente->idPaciente ?></td>
                            <td><?php echo $paciente->nombreCompleto ?></td>
                            <td><?php echo $paciente->apellidoCompleto ?></td>
                            <td><?php echo $paciente->telefono ?></td>
                            <td><a class="btn btn-dark btn-sm" href="<?php echo URLROOT; ?>/pacientes/editar/<?php echo $paciente->idPaciente ?>"><i class="fas fa-edit text-info"></i></a></td>
                            <td><button class="btn btn-dark btn-sm" data-toggle="modal" data-target="#paciente-delete" data-id="@<?php echo $paciente->idPaciente ?>"><i class="fas fa-trash text-danger"></i></button></td>
                        </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>