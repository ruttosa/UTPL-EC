<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="container">
        <div class="jumbotron jumbotro-fluid">
            <div class="container">
                <h1><?php echo $data['titulo']; ?></h1>
                <div class="lead"><?php echo $data['subtitulo']; ?></div>
                <p>Version: <strong><?php echo APPVERSION; ?></strong></p>
                <p><?php echo $data['descripcion']; ?></p>
            </div>
        </div>
    </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>