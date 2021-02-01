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
                        <h5 class="m-0">Exámenes</h5>
                        <!-- <a class="btn nav-link text-light ml-auto" disabled='disabled' href="<?php echo URLROOT; ?>/personalMedico/agregar">
                            <i class="fas fa-plus-circle"></i>
                            Añadir cita médico
                        </a> -->
                        <p class="m-0 pt-2">Aquí puedes visualizar todas los exámenes solicitados para tus pacientes.</p>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped bg-light text-center">
                        <thead>
                            <tr class="text-muted">
                                <th>Fecha</th>
                                <th>Examen</th>
                                <th># Cita</th>                                
                                <th>Especialidad</th>
                                <th>Paciente</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['examenes'] as $examen) : ?>
                                <tr>
                                    <td><?php echo date("d/m/Y", strtotime($examen->fechaSolicitud)) ?></td>
                                    <td><?php echo $examen->nombreExamen ?></td>
                                    <td><?php echo $examen->idCitaMedica ?></td>
                                    <td><?php echo $examen->nombreEspecialidad ?></td>
                                    <td><?php echo $examen->pacienteNombre . ' ' . $examen->pacienteApellido ?></td>
                                    <td><a class="btn btn-transparent btn-sm" href="<?php echo URLROOT; ?>/consultas/historiaMedica/<?php echo $examen->idexamen ?>"><i class="fas fa-notes-medical fa-2x text-info"></i></a></td>
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