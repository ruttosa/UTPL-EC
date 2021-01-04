<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container">
    <div class="jumbotron">
        <div class="container">
            <h1 class="display-3"><?php echo $data['titulo']; ?></h1>
            <div class="lead"><?php echo $data['subtitulo']; ?></div>
            <div class="mt-5">
                <p class="lead">Si deseas ser cliente de nuestro hospital puedes hacer clic en <strong>Registrarse</strong> y completar el formulario.</p>
                <p class="lead">Si ya tienes una cuenta puedes hacer clic en <strong>Iniciar Sesión</strong> e ingresar al sistema para agendar citas médicas o revisar tu historial médico.</p>
            </div>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>     