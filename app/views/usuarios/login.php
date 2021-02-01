<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light my-5">
                <?php flash('register_success'); ?>
                <h2 class="text-center">Login</h2>
                <p>Please fiil in your credentials to loging</p>
                <form action="<?php echo URLROOT; ?>/usuarios/login" method="post">
                    <div class="form-group">
                        <label for="correo">Correo: <sup>*</sup></label>
                        <input type="email" name="correo" 
                            class="form-control form-control-lg <?php echo (!empty($data['correo_error'])) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $data['correo']; ?>">
                        <span class="invalid-feedback"><?php echo $data['correo_error']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña: <sup>*</sup></label>
                        <input type="password" name="password" 
                            class="form-control form-control-lg <?php echo (!empty($data['password_error'])) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $data['password']; ?>">
                        <span class="invalid-feedback"><?php echo $data['password_error']; ?></span>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Login" class="btn btn-success btn-block">
                        </div>
                        <div class="col">
                            <a href="<?php echo URLROOT; ?>/clientes/registro" class="btn btn-light">¿Aún no tiene una cuenta? Regístrese</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>