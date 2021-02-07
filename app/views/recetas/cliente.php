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
                        <p class="m-0 pt-2">Aquí puedes visualizar todas las recetas preescriptas en tus citas médicas.</p>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped bg-light text-center">
                        <thead>
                            <tr class="text-muted">
                                <th>Fecha</th>
                                <th>Receta</th>
                                <th>Paciente</th>
                                <th># Cita</th>
                                <th>Especialidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['recetas'] as $receta) : ?>
                                <tr>
                                    <td><?php echo $receta->fechaSolicitud ?></td>
                                    <td><?php echo $receta->detalleMedicacion ?></td>
                                    <td><?php echo $receta->pacienteNombre . ' ' . $receta->pacienteApellido ?></td>
                                    <td><?php echo $receta->citaMedicaId ?></td>
                                    <td><?php echo $receta->nombreEspecialidad ?></td>
                                    <td><a class="btn btn-transparent btn-sm" href="<?php echo URLROOT; ?>/consultas/historiaMedica/<?php echo $receta->idRecetaMedica ?>"><i class="fas fa-capsules fa-2x text-info"></i></a></td>
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

<?php require APPROOT . '/views/inc/footer.php'; ?>