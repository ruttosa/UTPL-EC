<?php require APPROOT . '/views/inc/header.php'; ?>

<h2>Dashboard <?php echo $data['dashboard_type'] ?></h2>
<div class="container">
    <div class="my-2">
        <?php flash('cancelarCita_success'); ?>
    </div>
    <!-- Dashboard de Administrador -->
    <?php if($data['dashboard_type'] == 'ADMINISTRADOR') : ?>
        <div class="col-md-12 mt-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="card p-3 shadow bg-info text-light">
                        <div class="card-title d-flex justify-content-center">
                            <h5 class="m-0">Citas médicas agendadas</h5>
                            <a class="btn nav-link text-light ml-auto" disabled='disabled' href="<?php echo URLROOT; ?>/personalMedico/agregar">
                                <i class="fas fa-plus-circle"></i>
                                Añadir cita médico
                            </a>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped bg-light text-center">
                            <thead>
                                <tr class="text-muted">
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Paciente</th>
                                    <th>Médico</th>
                                    <th>Motivo</th>
                                    <th>Cancelar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data['citasMedicas'] as $citaMedica) : ?>
                                    <tr>
                                        <td><?php echo $citaMedica->idCitaMedica ?></td>
                                        <td><?php echo $citaMedica->fechaSolicitud ?></td>
                                        <td><?php echo $citaMedica->pacienteNombre . ' ' . $citaMedica->pacienteApellido ?></td>
                                        <td><?php echo $citaMedica->medicoNombre . ' ' . $citaMedica->medicoApellido ?></td>
                                        <td><?php echo $citaMedica->motivo ?></td>
                                        <td><a class="btn btn-transparent btn-sm" href="<?php echo URLROOT; ?>/dashboard/cancelar/<?php echo $citaMedica->idCitaMedica ?>"><i class="fas fa-calendar-times fa-2x text-danger"></i></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Dashboard Medico -->
    <?php if($data['dashboard_type'] == 'MEDICO') : ?>
        <div class="col-md-12 mt-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="card p-3 shadow bg-info text-light">
                        <div class="card-title d-flex justify-content-center">
                            <h5 class="m-0">Citas médicas agendadas</h5>
                            <a class="btn nav-link text-light ml-auto" disabled='disabled' href="<?php echo URLROOT; ?>/personalMedico/agregar">
                                <i class="fas fa-plus-circle"></i>
                                Añadir cita médico
                            </a>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped bg-light text-center">
                            <thead>
                                <tr class="text-muted">
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Paciente</th>
                                    <th>Médico</th>
                                    <th>Motivo</th>
                                    <th>Cancelar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data['citasMedicas'] as $citaMedica) : ?>
                                    <tr>
                                        <td><?php echo $citaMedica->idCitaMedica ?></td>
                                        <td><?php echo $citaMedica->fechaSolicitud ?></td>
                                        <td><?php echo $citaMedica->pacienteNombre . ' ' . $citaMedica->pacienteApellido ?></td>
                                        <td><?php echo $citaMedica->medicoNombre . ' ' . $citaMedica->medicoApellido ?></td>
                                        <td><?php echo $citaMedica->motivo ?></td>
                                        <td><a class="btn btn-transparent btn-sm" href="<?php echo URLROOT; ?>/dashboard/cancelar/<?php echo $citaMedica->idCitaMedica ?>"><i class="fas fa-calendar-times fa-2x text-danger"></i></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>                                

    <!-- Dashboard Cliente -->
    <?php if($data['dashboard_type'] == 'CLIENTE') : ?>
        <div class="col-md-12 mt-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="card p-3 shadow bg-info text-light">
                        <div class="card-title d-flex justify-content-center">
                            <h5 class="m-0">Citas médicas agendadas</h5>
                            <a class="btn nav-link text-light ml-auto" disabled='disabled' href="<?php echo URLROOT; ?>/personalMedico/agregar">
                                <i class="fas fa-plus-circle"></i>
                                Añadir cita médico
                            </a>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped bg-light text-center">
                            <thead>
                                <tr class="text-muted">
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Paciente</th>
                                    <th>Médico</th>
                                    <th>Motivo</th>
                                    <th>Cancelar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data['citasMedicas'] as $citaMedica) : ?>
                                    <tr>
                                        <td><?php echo $citaMedica->idCitaMedica ?></td>
                                        <td><?php echo $citaMedica->fechaSolicitud ?></td>
                                        <td><?php echo $citaMedica->pacienteNombre . ' ' . $citaMedica->pacienteApellido ?></td>
                                        <td><?php echo $citaMedica->medicoNombre . ' ' . $citaMedica->medicoApellido ?></td>
                                        <td><?php echo $citaMedica->motivo ?></td>
                                        <td><a class="btn btn-transparent btn-sm" href="<?php echo URLROOT; ?>/dashboard/cancelar/<?php echo $citaMedica->idCitaMedica ?>"><i class="fas fa-calendar-times fa-2x text-danger"></i></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>   

</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
