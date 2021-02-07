<?php
    class Usuarios extends Controller{

        public function __construct(){
            $this->userModel = $this->model('Usuario');
        }

        public function registro(){
            
            // Check for POST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Init data
                $data = [
                    'nombreUsuario' => '',
                    'correo' => trim($_POST['correo']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'correo_error' => '',
                    'password_error' => '',
                    'confirm_password_error' => ''
                ];

                // Validate correo
                if(empty($data['correo'])){
                    $data['correo_error'] = 'Por favor ingrese un correo';
                }
                else{
                    // Check correo existente
                    if($this->userModel->validarUsuarioPorCorreo($data['correo'])){
                        $data['correo_error'] = 'El correo ya existe';
                    }
                    else{
                        // Configurar nombre de usario a partir del correo
                        $nombreUsuario = explode('@', $data['correo'])[0];
                        $data['nombreUsuario'] = $nombreUsuario;
                    }
                }

                // Validate Password
                if(empty($data['password'])){
                    $data['password_error'] = 'Por favor ingrese una contraseña';
                } elseif(strlen($data['password']) < 6){
                    $data['password_error'] = 'La contraseña debe tener al menos 6 caracteres';
                }
                // Validate Confirmar Password
                if(empty($data['confirm_password'])){
                    $data['confirm_password_error'] = 'Por favor confirme la contraseña';
                } elseif($data['password'] != $data['confirm_password']){
                    $data['confirm_password_error'] = 'Las contraseñas no coinciden';
                }


                // Asegurarse que no existan errores para proceder con el registro del usuario
                if(empty($data['correo_error']) && empty($data['name_error']) && empty($data['password_error']) && empty($data['confirm_password_error'])){

                    // Registrar Usuario
                    if($this->userModel->crearUsuario($data) != null){
                        flash('register_success', 'El registro se ha completado exitosamente. Inicie sesión para continuar');
                        redirect('usuarios/login');
                    }
                    else{
                        die('Ocurrió un error inesperado');
                    }
                }
                else{
                    // Laod view with errors
                    $this->view('usuarios/registro', $data);
                }

            }
            else{

                // Inicializar datos
                $data = [
                    'correo' => '',
                    'password' => '',
                    'confirm_password' => '',
                    'correo_error' => '',
                    'password_error' => '',
                    'confirm_password_error' => ''
                ];

                // Cargar Vista
                $this->view('/usuarios/registro', $data);              
            }
        }

        public function login(){
            
            // Check for POST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Init data
                $data = [
                    'correo' => trim($_POST['correo']),
                    'password' => trim($_POST['password']),
                    'correo_error' => '',
                    'password_error' => ''
                ];

                // Validar correo
                if(empty($data['correo'])){
                    $data['correo_error'] = 'Por favor ingrese el correo';
                }
                // Validar Password
                if(empty($data['password'])){
                    $data['password_error'] = 'Por favor ingrese la contraseña';
                }

                // Check for usuario/correo
                if($this->userModel->validarUsuarioPorCorreo($data['correo'])){
                    // User found
                }
                else{
                    // User not found
                    $data['correo_error'] = 'Usuario/Contraseña no encontrado';
                }

                // Make sure errors are emtpy
                if(empty($data['correo_error']) && empty($data['password_error'])){

                    // Check and set logged in user
                    $loggedInUser = $this->userModel->login($data['correo'], $data['password']);

                    if($loggedInUser){

                        // Obtener Roles de Usario
                        $roles = $this->userModel->obtenerRolesPorUsuarioId($loggedInUser->idUsuario);

                        // Create User Session
                        if($this->userModel->crearSesionDeUsuario($loggedInUser, $roles)){
                            redirect('dashboard');
                        }
                    }
                    else{
                        $data['password_error'] = 'Password incorrect';
                        $this->view('usuarios/login', $data);
                    }
                }
                else{
                    // Load view with errors
                    $this->view('usuarios/login', $data);
                }

            }
            else{

                // Init data
                $data = [
                    'correo' => '',
                    'password' => '',
                    'correo_error' => '',
                    'password_error' => ''
                ];

                // Load View
                $this->view('/usuarios/login', $data);              
            }
        }

        public function logout(){
            unset($_SESSION['user_id']);
            unset($_SESSION['user_name']);
            unset($_SESSION['user_correo']);
            unset($_SESSION['user_roles']);
            session_destroy();
            redirect('usuarios/login');
        }

        public function passwordReset($usuarioId){

            //check User is loggedIn
            if(!isLoggedIn()){
                redirect('usuarios/login');
            }
            //check User Role -- Only ADMINISTRADOR allowed
            if(!checkLoggedUserRol("ADMINISTRADOR")){
                redirect('dashboard');
            }

            $data = [
                "estado" => "",
                "resultado" => ""
            ];

            if(is_numeric($usuarioId)){
                $password = randomString(8);
                $passwordModificado = $this->userModel->modificarPassword($usuarioId, $password);
                if($passwordModificado){
                    $data['estado'] = "OK";
                    $data['resultado'] = $password;
                }
                else{
                    $data['estado'] = "ERROR";
                    $data['resultado'] = "Ocurrió un error inesperado. La contraseña no ha sido modificada.";
                }
            }
            else{
                $data['estado'] = "ERROR";
                $data['resultado']  = "Identificador de usuario no válido";
            }
            echo json_encode($data);
        }
    }