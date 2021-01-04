
        <!-- Cargar solo para usuarios logueados para adaptarse al menú lateral -->
        <?php if(isset($_SESSION['user_id'])) : ?>
            </div>
        </div>
        <?php endif; ?>
    

    </div>

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <!--Popper and Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <!-- Custom JS -->
    <script src="<?php echo URLROOT ?>/js/main.js"></script>
</body>
</html>