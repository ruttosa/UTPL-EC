<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container">
    <div class="my-2">
        <?php flash('cancelarCita_success'); ?>
    </div>

    <!-- Dashboard CLIENTE -->
    <div class="col-md-12 mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card p-3 shadow bg-info text-light">
                    <div class="card-title d-flex justify-content-center">
                        <div>
                            <h5 class="m-0">Citas médicas solicitadas</h5>
                            <p class="m-0 pt-2">Aquí puedes visualizar todas las citas medicas solicitadas para tus pacientes.</p>
                        </div>
                        <a class="btn nav-link text-light ml-auto pt-0" disabled='disabled' href="<?php echo URLROOT; ?>/consultas/agendar">
                            <i class="fas fa-plus-circle"></i>
                            Solicitar una cita médica
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive rounded">
                            <table class="table rounded table-striped bg-light text-center">
                                <thead class="thead-dark">
                                    <tr class="text-muted">
                                        <th>#</th>
                                        <th>Fecha</th>
                                        <th>Paciente</th>
                                        <th>Médico</th>
                                        <th>Motivo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($data['citasMedicas'] as $citaMedica) : ?>
                                        <tr>
                                            <td class="align-middle"><?php echo $citaMedica->idCitaMedica ?></td>
                                            <td class="align-middle"><?php echo $citaMedica->fechaSolicitud ?></td>
                                            <td class="align-middle"><?php echo $citaMedica->pacienteNombre . ' ' . $citaMedica->pacienteApellido ?></td>
                                            <td class="align-middle"><?php echo $citaMedica->medicoNombre . ' ' . $citaMedica->medicoApellido ?></td>
                                            <td class="align-middle"><?php echo $citaMedica->motivo ?></td>
                                            <td class="align-middle"><a class="btn btn-transparent btn-sm" href="<?php echo URLROOT; ?>/dashboard/cancelar/<?php echo $citaMedica->idCitaMedica ?>"><i class="fas fa-eye fa-2x text-info"></i></a></td>
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

<?php require APPROOT . '/views/inc/footer.php'; ?>