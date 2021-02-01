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
                        <p class="m-0 pt-2">Aquí puedes visualizar el historial de citas médicas atendidas.</p>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped bg-light text-center">
                        <thead>
                            <tr class="text-muted">
                                <th>#</th>
                                <th>Fecha</th>
                                <th>Especialidad</th>
                                <th>Paciente</th>
                                <th>Motivo</th>
                                <th>Diagnóstico</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['citasMedicas'] as $citaMedica) : ?>
                                <tr>
                                    <td><?php echo $citaMedica->idCitaMedica ?></td>
                                    <td><?php echo $citaMedica->fechaSolicitud ?></td>
                                    <td><?php echo $citaMedica->especialidad ?></td>
                                    <td><?php echo $citaMedica->medicoNombre . ' ' . $citaMedica->medicoApellido ?></td>
                                    <td><?php echo $citaMedica->motivo ?></td>
                                    <td><a class="btn btn-transparent btn-sm" href="<?php echo URLROOT; ?>/consultas/historiaMedica/<?php echo $citaMedica->idCitaMedica ?>"><i class="fas fa-notes-medical fa-2x text-info"></i></a></td>
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