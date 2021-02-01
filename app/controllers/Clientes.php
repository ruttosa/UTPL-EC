<?php
    class Clientes extends Controller{

        public function __construct(){
            $this->userModel = $this->model('Usuario');
            $this->ciudadModel = $this->model('Ciudad');
            $this->perfilPersonaModel = $this->model('PerfilPersona');
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

                    // Hash Password
                    $password = $data['password'];
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    $nuevoClienteId = $this->userModel->crearUsuario($data);

                    // Registrar Usuario
                    if($nuevoClienteId != null){

                        // Asignar rol CLIENTE al nuevo usuario creado
                        $rolAsignado = $this->userModel->asignarUsuarioRol($nuevoClienteId, 'CLIENTE');
                        if($rolAsignado){
                            flash('register_success', 'El registro se ha completado exitosamente. Inicie sesión para continuar');

                            // Login automático
                            $loggedInUser = $this->userModel->login($data['correo'], $password);
                            $roles = $this->userModel->obtenerRolesPorUsuarioId($loggedInUser->idUsuario);
                            // Create User Session
                            $this->userModel->crearSesionDeUsuario($loggedInUser, $roles);
                            redirect('clientes/perfil/' . $loggedInUser->idUsuario);
                        }
                        else{
                            die('Ocurrió un error inesperado');
                        }                        
                    }
                    else{
                        die('Ocurrió un error inesperado');
                    }
                }
                else{
                    // Laod view with errors
                    $this->view('clientes/registro', $data);
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
                $this->view('/clientes/registro', $data);              
            }
        }

        public function perfil($usuarioId){

            //check User is loggedIn
            if(!isLoggedIn()){
                redirect('usuarios/login');
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Sanitize POST array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $ciudades = $this->ciudadModel->obtenerCiudades();

                $data = [
                    'id'=> $usuarioId,
                    'nombreCompleto' => trim($_POST['nombreCompleto']),
                    'fechaNacimiento' => trim($_POST['fechaNacimiento']),
                    'apellidoCompleto' => trim($_POST['apellidoCompleto']),
                    'telefono' => trim($_POST['telefono']),
                    'correo' => trim($_POST['correo']),
                    'direccion' => trim($_POST['direccion']),
                    'documento' => trim($_POST['documento']),
                    'ciudades' => $ciudades
                ];

                if(empty($_POST['genero'])){$data['genero'] = '';}else{$data['genero'] = $_POST['genero'];}
                if(empty($_POST['tipoDocumento'])){$data['tipoDocumento'] = '';}else{$data['tipoDocumento'] = $_POST['tipoDocumento'];}
                if(empty($_POST['ciudad'])){$data['ciudad'] = '';}else{$data['ciudad'] = $_POST['ciudad'];}

                // Validar Datos
                $dataValidated = validarFormularioPerfil("CLIENTE", $data);
                $data = $dataValidated['data'];
                $dataValid = $dataValidated['valid'];

                // Asegurarse que no haya errores
                if($dataValid){
                    
                    if($_SESSION['cliente_sin_perfil']){
                        // Crear Perfil
                        $perfilCreadoId = $this->perfilPersonaModel->crearPerfilPersona($data);
                        if($perfilCreadoId != null){
                            // Asignar perfil al usuario
                            $this->userModel->actualizarUsuarioPerfil($usuarioId, $perfilCreadoId);

                            $_SESSION['cliente_sin_perfil'] = !$this->userModel->verificarUsuarioPerfilAsignado($_SESSION['user_correo']);

                            
                            flash('editarPerfil_success', "Perfil completado", 'alert alert-success');
                        }
                    }
                    else{
                        // Editar Perfil
                        $perfilUsuario = $this->perfilPersonaModel->obtenerPerfilPersonaPorUsuarioId($usuarioId);

                        // Actualizar perfil
                        $this->perfilPersonaModel->actualizarPerfilPersona($perfilUsuario->idPerfilPersona, $data);

                        flash('editarPerfil_success', "El perfil ha sido editado exitosamente", 'alert alert-success');
                    }                    
                    return $this->view('clientes/perfil', $data);
                }
                else{
                    flash('editarPerfil_error', "Faltan campos obligatorios por completar", 'alert alert-danger');
                    return $this->view('clientes/perfil', $data);
                }
            }
            else{
                $ciudades = $this->ciudadModel->obtenerCiudades();

                $data = [
                    'id'=> $usuarioId,
                    'nombreCompleto' => '',
                    'nombreCompleto_error' => '',
                    'fechaNacimiento' => '',
                    'fechaNacimiento_error' => '',
                    'genero' => '',
                    'apellidoCompleto' => '',
                    'apellidoCompleto_error' => '',
                    'telefono' => '',
                    'telefono_error' => '',
                    'correo' => $_SESSION['user_correo'],
                    'direccion' => '',
                    'direccion_error' => '',
                    'documento' => '',
                    'documento_error' => '',
                    'tipoDocumento' => '',
                    'tipoDocumento_error' => '',
                    'ciudades' => $ciudades,
                    'ciudad' => '',
                    'ciudad_error' => ''
                ];

                if(!$_SESSION['cliente_sin_perfil']){
                    $perfilUsuario = $this->perfilPersonaModel->obtenerPerfilPersonaPorUsuarioId(intval($usuarioId));
                    $data['nombreCompleto'] = $perfilUsuario ->NombreCompleto;
                    $data['fechaNacimiento'] = $perfilUsuario ->fechaNacimiento;
                    $data['genero'] = $perfilUsuario ->genero;
                    $data['apellidoCompleto'] = $perfilUsuario ->apellidoCompleto;
                    $data['telefono'] = $perfilUsuario ->telefono;
                    $data['correo'] = $perfilUsuario ->correo;
                    $data['direccion'] = $perfilUsuario ->direccion;
                    $data['documento'] = $perfilUsuario ->documento;
                    $data['tipoDocumento'] = $perfilUsuario ->tipoDocumento;
                    $data['ciudad'] = $perfilUsuario ->idCiudad;
                }
            
                return $this->view('clientes/perfil', $data); 
            }            
        }

    }
    