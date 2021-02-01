<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container">
<h2>Añadir Paciente</h2>
    <p class="lead">Aquí podrás realizar el registro de los pacientes asociados a tu cuenta</p>
    <div> 
        <?php flash('registroPaciente_success'); ?>
        <?php flash('registroPaciente_error'); ?>
    </div>
    <div class="col-md-12">
        <div class="card p-3 shadow bg-info text-light">
            <div class="card-body">
                <form action="<?php echo URLROOT; ?>/pacientes/agregar" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombreCompleto">Nombre completo: <sup>*</sup></label>
                                <input type="text" name="nombreCompleto" 
                                    class="form-control form-control-lg <?php echo (!empty($data['nombreCompleto_error'])) ? 'is-invalid' : ''; ?>"
                                    value="<?php echo $data['nombreCompleto']; ?>">
                                <span class="invalid-feedback"><?php echo $data['nombreCompleto_error']; ?></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="fechaNacimiento">Fecha de nacimiento: <sup>*</sup></label>
                                <input type="date" name="fechaNacimiento" 
                                    class="form-control form-control-lg <?php echo (!empty($data['fechaNacimiento_error'])) ? 'is-invalid' : ''; ?>"
                                    value="<?php echo $data['fechaNacimiento']; ?>">
                                <span class="invalid-feedback"><?php echo $data['fechaNacimiento_error']; ?></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="genero">Género:</label>
                                <div class="d-flex align-self-center">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="genero" id="" value="M" <?php if($data['genero'] == "M"){echo 'checked';} ?>>Masculino
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="genero" id="" value="F" <?php if($data['genero'] == "F"){echo 'checked';} ?>>Femenino
                                        </label>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="apellidoCompleto">Apellido completo: <sup>*</sup></label>
                                <input type="text" name="apellidoCompleto" 
                                    class="form-control form-control-lg <?php echo (!empty($data['apellidoCompleto_error'])) ? 'is-invalid' : ''; ?>"
                                    value="<?php echo $data['apellidoCompleto']; ?>">
                                <span class="invalid-feedback"><?php echo $data['apellidoCompleto_error']; ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telefono">Teléfono: <sup>*</sup></label>
                                <input type="text" name="telefono" 
                                    class="form-control form-control-lg <?php echo (!empty($data['telefono_error'])) ? 'is-invalid' : ''; ?>"
                                    value="<?php echo $data['telefono']; ?>">
                                <span class="invalid-feedback"><?php echo $data['telefono_error']; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="correo">Correo electrónico: <sup>*</sup></label>
                                <input type="email" name="correo" class="form-control form-control-lg" value="<?php echo $data['correo']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="direccion">Dirección: <sup>*</sup></label>
                                <input type="text" name="direccion" 
                                    class="form-control form-control-lg <?php echo (!empty($data['direccion_error'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['direccion']; ?>">
                                <span class="invalid-feedback"><?php echo $data['direccion_error']; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="documento">Documento: <sup>*</sup></label>
                                <input type="text" name="documento" 
                                    class="form-control form-control-lg <?php echo (!empty($data['documento_error'])) ? 'is-invalid' : ''; ?>"
                                    value="<?php echo $data['documento']; ?>">
                                <span class="invalid-feedback"><?php echo $data['documento_error']; ?></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tipoDocumento">Tipo de documento:</label>
                                <div class="d-flex">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="tipoDocumento" id="" value="C" <?php if($data['tipoDocumento'] == "C"){echo 'checked';} ?>>Cédula
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="tipoDocumento" id="" value="P" <?php if($data['tipoDocumento'] == "P"){echo 'checked';} ?>>Pasaporte
                                        </label>
                                    </div>  
                                </div>
                                <span class="invalid-feedback <?php echo (!empty($data['tipoDocumento_error'])) ? 'd-block' : ''; ?>"><?php echo $data['tipoDocumento_error']; ?></span>                           
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ciudad">Ciudad: <sup>*</sup></label>
                                <select name="ciudad" class="form-control form-control-lg <?php echo (!empty($data['ciudad_error'])) ? 'is-invalid' : ''; ?>">
                                    <option value=""></option>
                                    <?php foreach($data['ciudades'] as $ciudad) : ?>
                                        <option value="<?php echo $ciudad->idCiudad ?>" <?php if($data['ciudad'] == $ciudad->idCiudad){echo 'selected';} ?>><?php echo $ciudad->nombreCiudad ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="invalid-feedback"><?php echo $data['ciudad_error']; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4 mx-auto">
                            <input type="submit" value="Añadir" class="btn btn-block btn-success">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>