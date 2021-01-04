<?php if(!isset($_SESSION['user_id'])) : ?>
<!-- Navbar NO LOGIN -->
<nav class="navbar navbar-expand-md navbar-dark bg-info mb-3 p-0">
  <div class="container-fluid">
    <a class="navbar-brand"href="<?php echo URLROOT; ?>">Hospital Nuestra Señora</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav mr-auto">      
          <li class="nav-item">
            <a class="nav-link text-white top-link" href="<?php echo URLROOT; ?>/pages/about">Acerca de</a>
          </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        <?php if(isset($_SESSION['user_id'])) : ?>
        <?php else : ?>
          <li class="nav-item">
            <a class="nav-link text-white top-link" aria-current="page" href="<?php echo URLROOT; ?>/usuarios/registro">Registrarse</a>
          </li>
          <li class="nav-item"></div>
            <a class="nav-link text-white top-link" href="<?php echo URLROOT; ?>/usuarios/login">Iniciar sesión</a>
          </li>          
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<?php else : ?>

<!-- Navbar User Logged In -->
<nav class="navbar navbar-expand-md navbar-dark p-0">      
      <button class="navbar-toggler ml-auto mb-2 bg-light" type="button" data-toggle="collapse" data-target="#mainNavBar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mainNavBar">
        <div class="container-fluid">  
          <div class="row">

            <!-- sidebar -->
            <div class="col-xl-2 col-lg-3 col-md-4 bg-info sidebar fixed-top scrollable">
              <a href="#" class="navbar-brand text-white d-block mx-auto text-center text-wrap py-2 bottom-border">Hospital Nuestra Señora</a>
              <div class="bottom-border py-2 my-2 d-flex flex-column text-center">
                <img src="<?php echo URLROOT; ?>/public/img/admin.jpeg" width="90" class="rounded m-auto" >
                <a href="#" class="text-white text-wrap mt-1"><?php echo $_SESSION['user_name'] ?></a>
              </div>
              <ul class="navbar-nav flex-column mt-4">
              <?php if(isset($_SESSION['user_roles'])) : ?>
                <li class="nav-item">
                  <a href="<?php echo URLROOT; ?>/dashboard" class="nav-link text-white p-1 mb-2 d-flex align-items-center sidebar-link <?php if(startsWith($_SESSION['activePage'],'dashboards')){echo 'current';}?>">
                    <i class="fas fa-home text-light fa-lg ml-2 mr-3"></i>Inicio
                  </a>
                </li>
                <?php if(checkLoggedUserRol('ADMINISTRADOR')) : ?>
                  <li class="nav-item">
                    <a href="<?php echo URLROOT; ?>/especialidades" class="nav-link text-white p-1 mb-2 d-flex align-items-center sidebar-link <?php if(startsWith($_SESSION['activePage'],'especialidades')){echo 'current';}?>">
                      <i class="fas fa-book-medical text-light fa-lg ml-2 mr-3"></i>Especialidades
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo URLROOT; ?>/personalMedico/index" class="nav-link text-white p-1 mb-2 d-flex align-items-center sidebar-link <?php if(startsWith($_SESSION['activePage'],'personalMedico')){echo 'current';}?>">
                      <i class="fas fa-user-md text-light fa-lg ml-2 mr-3"></i>Personal Médico
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo URLROOT; ?>/clientes/index" class="nav-link text-white p-1 mb-2 d-flex align-items-center sidebar-link">
                      <i class="fas fa-user-md text-light fa-lg ml-2 mr-3"></i>Clientes
                    </a>
                  </li>
                <?php endif; ?>
                <?php if(checkLoggedUserRol('CLIENTE')) : ?>
                  <li class="nav-item">
                    <a href="<?php echo URLROOT; ?>/especialidades/index" class="nav-link text-white p-1 mb-2 d-flex align-items-center sidebar-link">
                      <i class="fas fa-hospital-user text-light fa-lg ml-2 mr-3"></i>Pacientes
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo URLROOT; ?>/especialidades/index" class="nav-link text-white p-1 mb-2 d-flex align-items-center sidebar-link">
                      <i class="fas fa-calendar-plus text-light fa-lg ml-2 mr-3"></i>Agendar cita médica
                    </a>
                  </li>                  
                <?php endif; ?>
                <?php if(checkLoggedUserRol('MEDICO') || checkLoggedUserRol('CLIENTE')) : ?>
                  <li class="nav-item">
                    <a href="<?php echo URLROOT; ?>/especialidades/index" class="nav-link text-white p-1 mb-2 d-flex align-items-center sidebar-link">
                      <i class="fas fa-notes-medical text-light fa-lg ml-2 mr-3"></i>Historias Médicas
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo URLROOT; ?>/recetas/index" class="nav-link text-white p-1 mb-2 d-flex align-items-center sidebar-link">
                      <i class="fas fa-capsules text-light fa-lg ml-2 mr-3"></i>Recetas
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo URLROOT; ?>/examenes/index" class="nav-link text-white p-1 mb-2 d-flex align-items-center sidebar-link">
                      <i class="fas fa-file-medical-alt text-light fa-lg ml-2 mr-3"></i>Exámenes
                    </a>
                  </li>
                <?php endif; ?>
              <?php endif; ?>
              </ul>
            </div>
            <!-- end of sidebar -->     

            <!-- top-nav -->
            <div class="col-xl-10 col-lg-9 col-md-8 ml-auto bg-dark fixed-top top-navbar">
              <div class="row align-items-center">
                <div class="col-md-4">
                  <h6 class="text-light mb-0">Breadcumb</h6>
                </div>
                <div class="col-md-5">
                  <!-- <form> //Searh Control - Not used
                    <div class="input-group">
                      <input type="text" class="form-control search-input" placeholder="Search...">
                      <button class="btn btn-white search-button"><i class="fas fa-search text-danger"></i></button>
                    </div>
                  </form> -->
                </div>
                <div class="col-md-3">
                  <ul class="navbar-nav">
                    <li class="nav-item icon-parent"><a href="" class="nav-link icon-bullet"><i class="fas fa-comments text-muted fa-lg"></i></a></li>
                    <li class="nav-item icon-parent"><a href="" class="nav-link icon-bullet"><i class="fas fa-bell text-muted fa-lg"></i></a></li>
                    <li class="nav-item ml-md-auto">
                      <a href="<?php echo URLROOT; ?>/usuarios/logout" class="nav-link d-flex align-items-center">
                        <div class="mr-2">Cerrar Sesión</div>
                        <i class="fas fa-sign-out-alt text-info fa-lg"></i>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <!-- end of top-nav -->

          </div>        
        </div>
      </div>
    </nav>
    <?php endif; ?>
    <!-- end of Navbar User Logged In -->