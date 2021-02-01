<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mb-5 shadow">
                <div class="text-center">
                    <h2>Registro de cliente</h2>
                    <p>Completa el formulario para registrarte en nuestra aplicación como cliente del hospital</p>
                </div>
                <form action="<?php echo URLROOT; ?>/clientes/registro" method="post">
                    <div class="form-group">
                        <label for="correo">Correo electrónico: <sup class="text-danger font-weight-bold">*</sup></label>
                        <input type="email" name="correo" 
                            class="form-control form-control-lg <?php echo (!empty($data['correo_error'])) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $data['correo']; ?>">
                        <span class="invalid-feedback"><?php echo $data['correo_error']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña: <sup class="text-danger font-weight-bold">*</sup></label>
                        <input type="password" name="password" 
                            class="form-control form-control-lg <?php echo (!empty($data['password_error'])) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $data['password']; ?>">
                        <span class="invalid-feedback"><?php echo $data['password_error']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirmar Contraseña: <sup class="text-danger font-weight-bold">*</sup></label>
                        <input type="password" name="confirm_password" 
                            class="form-control form-control-lg <?php echo (!empty($data['confirm_password_error'])) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $data['confirm_password']; ?>">
                        <span class="invalid-feedback"><?php echo $data['confirm_password_error']; ?></span>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Registrase" class="btn btn-success btn-block">
                        </div>
                        <div class="col">
                            <a href="<?php echo URLROOT; ?>/usuarios/login" class="btn btn-light">¿Ya tiene cuenta? Ingresar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>