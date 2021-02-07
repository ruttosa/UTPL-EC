
        <!-- Cargar solo para usuarios logueados para adaptarse al menú lateral -->
        <?php if(isset($_SESSION['user_id'])) : ?>
            </div>
        </div>
        <?php endif; ?>
    

    </div>

    

    <!-- Popper and Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- JS Loading Overlay -->
    <script src="<?php echo URLROOT ?>/js/js-loading-overlay.js"></script>

    <!-- Custom JS -->
    <script src="<?php echo URLROOT ?>/js/main.js"></script>
</body>
</html>