<?php
    class PersonalMedico extends Controller{
        public function __construct(){
            $this->userModel = $this->model('Usuario');
            $this->perfilPersonaModel = $this->model('PerfilPersona');
            $this->especialidadModel = $this->model('Especialidad');
            $this->ciudadModel = $this->model('Ciudad');
            $this->horarioAtencionModel = $this->model('HorarioAtencion');
            $this->pacienteModel = $this->model('Paciente');
        }

        public function index(){

            //check User is loggedIn
            if(!isLoggedIn()){
                redirect('usuarios/login');
            }
            //check User Role -- Only ADMINISTRADOR allowed
            if(!checkLoggedUserRol("ADMINISTRADOR")){
                redirect('dashboard');
            }

            $data = [];

            $perfilesMedicos = $this->perfilPersonaModel->obtenerPerfilesUsuarioPorRol("MEDICO");
            foreach ($perfilesMedicos as $perfilMedico) {
                $especialidadData = $this->especialidadModel->obtenerEspecialidadesPorPerfilPersona($perfilMedico->idPerfilPersona);
                
                $personalMedicoData = [
                    "perfil" => $perfilMedico,
                    "especialidades" => $especialidadData
                ];
                array_push($data, $personalMedicoData);
            }
        
            return $this->view('personalMedico/index', $data);
        }

        public function agregar(){

            //check User is loggedIn
            if(!isLoggedIn()){
                redirect('usuarios/login');
            }
            //check User Role -- Only ADMINISTRADOR allowed
            if(!checkLoggedUserRol("ADMINISTRADOR")){
                redirect('dashboard');
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Sanitize POST array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                //Obtener catálogos para la vista
                $especialidades = $this->especialidadModel->obtenerEspecialidades();
                $ciudades = $this->ciudadModel->obtenerCiudades();
                $horariosDeAtencion = $this->horarioAtencionModel->obtenerHorariosDeAtencion();

                $data = [
                    'nombreCompleto' => trim($_POST['nombreCompleto']),
                    'fechaNacimiento' => trim($_POST['fechaNacimiento']),
                    'apellidoCompleto' => trim($_POST['apellidoCompleto']),
                    'telefono' => trim($_POST['telefono']),
                    'correo' => trim($_POST['correo']),
                    'direccion' => trim($_POST['direccion']),
                    'documento' => trim($_POST['documento']),
                    'ciudades' => $ciudades,
                    'especialidades' => $especialidades,
                    'horariosDeAtencion' => $horariosDeAtencion                  
                ];

                if(empty($_POST['genero'])){$data['genero'] = '';}else{$data['genero'] = $_POST['genero'];}
                if(empty($_POST['tipoDocumento'])){$data['tipoDocumento'] = '';}else{$data['tipoDocumento'] = $_POST['tipoDocumento'];}
                if(empty($_POST['ciudad'])){$data['ciudad'] = '';}else{$data['ciudad'] = $_POST['ciudad'];}
                if(!isset($_POST['especialidad'])){$data['especialidad'] = [];}else{$data['especialidad'] = $_POST['especialidad'];}
                if(!isset($_POST['horarioAtencion'])){$data['horarioAtencion'] = [];}else{$data['horarioAtencion'] = $_POST['horarioAtencion'];}

                // Validar Datos
                $dataValidated = validarFormularioPerfil("MEDICO", $data);
                $data = $dataValidated['data'];
                $dataValid = $dataValidated['valid'];

                // Asegurarse que no haya errores
                if($dataValid){

                    // Validar si el usuario ya existe
                    $validarUsuario = $this->userModel->validarUsuarioPorCorreo($data['correo']);
                    if($validarUsuario){

                        $usuario = $this->userModel->obtenerUsuarioPorCorreo($data['correo']);
                        $usuarioID = $usuario->idUsuario;
                        // Verificar si el usuario ya tiene un perfil asignado
                        if($usuario->perfilPersonaId != null){
                            flash('agregarMedico_error', "El médico ya tiene un perfil creado.", 'alert alert-danger');
                            return $this->view('personalMedico/agregar', $data);
                        }
                    }
                    else{

                        // Hash Generic Password
                        $generic_Password = 'Medico2021';
                        $pass = password_hash($generic_Password, PASSWORD_DEFAULT);

                        $userData = [
                            'nombreUsuario' => explode('@', $data['correo'])[0],
                            'correo' => $data['correo'],
                            'password' => $pass
                        ];

                        // Registrar Usuario
                        $nuevoUsuarioID = $this->userModel->crearUsuario($userData);
                        if($nuevoUsuarioID != null){
                            // Asignar rol 'MEDICO'
                            if(!$this->userModel->asignarUsuarioRol($nuevoUsuarioID, "MEDICO")){
                                flash('agregarMedico_error', 'Ocurrió un error inesperado durante la asignación de roles de usuario.');                    
                                return $this->view('personalMedico/agregar', $data);
                            }
                            $usuarioID = $nuevoUsuarioID;
                        }
                        else{
                            flash('agregarMedico_error', 'Ocurrió un error inesperado durante el registro del usuario.');                    
                            return $this->view('personalMedico/agregar', $data);
                        }
                    }

                    // Crear perfil del usuario
                    $perfilCreadoId = $this->perfilPersonaModel->crearPerfilPersona($data);

                    if($perfilCreadoId != null){
                        // Asignar perfil al usuario
                        $this->userModel->actualizarUsuarioPerfil($usuarioID, $perfilCreadoId);

                        // Asignar Especialidad
                        foreach ($data['especialidad'] as $especialidadSelected) {
                            $this->perfilPersonaModel->asignarEspecialidad($perfilCreadoId, $especialidadSelected);
                        }

                        // Asignar Horario de Atención
                        foreach ($data['horarioAtencion'] as $horarioAtencionSelected) {
                            $this->perfilPersonaModel->asignarHorarioAtencion($perfilCreadoId, $horarioAtencionSelected);
                        }
                    }
                    else{
                        flash('agregarMedico_error', 'Ocurrió un error inesperado durante la creación del perfil del usuario.');                    
                        return $this->view('personalMedico/agregar', $data);
                    }
                    
                    flash('agregarMedico_success', 'El registro del médico finalizó correctamente. Su contraseña actual es: ' . $generic_Password);                    
                    redirect('personalMedico/agregar');
                }
                else{
                    flash('agregarMedico_error', "Faltan campos obligatorios por completar", 'alert alert-danger');
                    return $this->view('personalMedico/agregar', $data);
                }
            }
            else{
                $especialidades = $this->especialidadModel->obtenerEspecialidades();
                $ciudades = $this->ciudadModel->obtenerCiudades();
                $horariosDeAtencion = $this->horarioAtencionModel->obtenerHorariosDeAtencion();

                $data = [
                    'nombreCompleto' => '',
                    'nombreCompleto_error' => '',
                    'fechaNacimiento' => '',
                    'fechaNacimiento_error' => '',
                    'genero' => '',
                    'apellidoCompleto' => '',
                    'apellidoCompleto_error' => '',
                    'telefono' => '',
                    'telefono_error' => '',
                    'correo' => '',
                    'correo_error' => '',
                    'direccion' => '',
                    'direccion_error' => '',
                    'documento' => '',
                    'documento_error' => '',
                    'tipoDocumento' => '',
                    'tipoDocumento_error' => '',
                    'ciudades' => $ciudades,
                    'ciudad' => '',
                    'ciudad_error' => '',
                    'especialidades' => $especialidades,
                    'especialidad' => [],
                    'especialidad_error' => '',
                    'horariosDeAtencion' => $horariosDeAtencion,
                    'horarioAtencion' => [],
                    'horarioAtencion_error' => ''
                ];
            
                return $this->view('personalMedico/agregar', $data);
            }
        }

        public function editar($id){

            //check User is loggedIn
            if(!isLoggedIn()){
                redirect('usuarios/login');
            }
            //check User Role -- Only ADMINISTRADOR allowed
            if(!checkLoggedUserRol("ADMINISTRADOR")){
                redirect('dashboard');
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Sanitize POST array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                //Obtener catálogos para la vista
                $especialidades = $this->especialidadModel->obtenerEspecialidades();
                $ciudades = $this->ciudadModel->obtenerCiudades();
                $horariosDeAtencion = $this->horarioAtencionModel->obtenerHorariosDeAtencion();

                $data = [
                    'id'=> $id,
                    'nombreCompleto' => trim($_POST['nombreCompleto']),
                    'fechaNacimiento' => trim($_POST['fechaNacimiento']),
                    'apellidoCompleto' => trim($_POST['apellidoCompleto']),
                    'telefono' => trim($_POST['telefono']),
                    'correo' => trim($_POST['correo']),
                    'direccion' => trim($_POST['direccion']),
                    'documento' => trim($_POST['documento']),
                    'ciudades' => $ciudades,
                    'especialidades' => $especialidades,
                    'horariosDeAtencion' => $horariosDeAtencion
                ];

                if(empty($_POST['genero'])){$data['genero'] = '';}else{$data['genero'] = $_POST['genero'];}
                if(empty($_POST['tipoDocumento'])){$data['tipoDocumento'] = '';}else{$data['tipoDocumento'] = $_POST['tipoDocumento'];}
                if(empty($_POST['ciudad'])){$data['ciudad'] = '';}else{$data['ciudad'] = $_POST['ciudad'];}
                if(!isset($_POST['especialidad'])){$data['especialidad'] = [];}else{$data['especialidad'] = $_POST['especialidad'];}
                if(!isset($_POST['horarioAtencion'])){$data['horarioAtencion'] = [];}else{$data['horarioAtencion'] = $_POST['horarioAtencion'];}

                // Validar Datos
                $dataValidated = validarFormularioPerfil("MEDICO", $data);
                $data = $dataValidated['data'];
                $dataValid = $dataValidated['valid'];

                // Asegurarse que no haya errores
                if($dataValid){

                    $perfilUsuario = $this->perfilPersonaModel->obtenerPerfilPersonaPorUsuarioId($id);

                    // Actualizar perfil
                    $this->perfilPersonaModel->actualizarPerfilPersona($perfilUsuario->idPerfilPersona, $data);

                    // Actualizar especialidades
                    $this->especialidadModel->eliminarEspecialidadesPorPerfilPersona($perfilUsuario->idPerfilPersona);
                    foreach($data['especialidad'] as $especialidadId){
                        $this->perfilPersonaModel->asignarEspecialidad($perfilUsuario->idPerfilPersona, $especialidadId);
                    }

                    // Actualizar horarios de atencion
                    $this->horarioAtencionModel->eliminarHorariosDeAtencionPorPerfilPersona($perfilUsuario->idPerfilPersona);
                    foreach($data['horarioAtencion'] as $horarioAtencionId){
                        $this->perfilPersonaModel->asignarHorarioAtencion($perfilUsuario->idPerfilPersona, $horarioAtencionId);
                    }
                    
                    flash('editarMedico_success', 'Los datos del médico fueron editados correctamente.');                    
                    return $this->view('personalMedico/editar', $data);
                }
                else{
                    flash('editarMedico_error', "Faltan campos obligatorios por completar", 'alert alert-danger');
                    return $this->view('personalMedico/editar', $data);
                }
            }
            else{
                $especialidades = $this->especialidadModel->obtenerEspecialidades();
                $ciudades = $this->ciudadModel->obtenerCiudades();
                $horariosDeAtencion = $this->horarioAtencionModel->obtenerHorariosDeAtencion();

                $perfilUsuario = $this->perfilPersonaModel->obtenerPerfilPersonaPorUsuarioId($id);
                $especialidadesUsuario = $this->especialidadModel->obtenerEspecialidadesPorPerfilPersona($perfilUsuario->idPerfilPersona);
                $horariosAtencionUsuario = $this->horarioAtencionModel->obtenerHorariosDeAtencionPorPerfilPersona($perfilUsuario->idPerfilPersona);
                
                $data = [
                    'id' => $id,
                    'nombreCompleto' => $perfilUsuario->NombreCompleto,
                    'nombreCompleto_error' => '',
                    'fechaNacimiento' => $perfilUsuario->fechaNacimiento,
                    'fechaNacimiento_error' => '',
                    'genero' => $perfilUsuario->genero,
                    'apellidoCompleto' => $perfilUsuario->apellidoCompleto,
                    'apellidoCompleto_error' => '',
                    'telefono' => $perfilUsuario->telefono,
                    'telefono_error' => '',
                    'correo' => $perfilUsuario->correo,
                    'correo_error' => '',
                    'direccion' => $perfilUsuario->direccion,
                    'direccion_error' => '',
                    'documento' => $perfilUsuario->documento,
                    'documento_error' => '',
                    'tipoDocumento' => $perfilUsuario->tipoDocumento,
                    'tipoDocumento_error' => '',
                    'ciudades' => $ciudades,
                    'ciudad' => $perfilUsuario->idCiudad,
                    'ciudad_error' => '',
                    'especialidades' => $especialidades,
                    'especialidad' => array_column($especialidadesUsuario, 'idEspecialidad'),
                    'especialidad_error' => '',
                    'horariosDeAtencion' => $horariosDeAtencion,
                    'horarioAtencion' => array_column($horariosAtencionUsuario, 'idHorarioAtencion'),
                    'horarioAtencion_error' => ''
                ];
            
                return $this->view('personalMedico/editar', $data);
            }
        }

        public function eliminar($id){

            //check User is loggedIn
            if(!isLoggedIn()){
                redirect('usuarios/login');
            }
            //check User Role -- Only ADMINISTRADOR allowed
            if(!checkLoggedUserRol("ADMINISTRADOR")){
                redirect('dashboard');
            }

            // Verificar si el médico tiene citas asignadas
            
            // Obtener perfil de usuario
            $perfilUsuario = $this->perfilPersonaModel->obtenerPerfilPersonaPorUsuarioId($id);

            // Eliminar horarios de atencion del usuario
            $this->horarioAtencionModel->eliminarHorariosDeAtencionPorPerfilPersona($perfilUsuario->idPerfilPersona);

            // Eliminar especialidades asignadas al doctor
            $this->especialidadModel->eliminarEspecialidadesPorPerfilPersona($perfilUsuario->idPerfilPersona);

            // Obtener Roles del usuario
            $rolesUsuario = $this->userModel->obtenerRolesPorUsuarioId($id);

            // Quitar rol de usario
            foreach ($rolesUsuario as $rolUsuario) {
                if($rolUsuario->nombreRol == "MEDICO"){
                    if($this->userModel->quitarUsuarioRol($id,$rolUsuario->idRol));
                }
            }
             // Obtener Roles del usuario actualizados
             $rolesUsuario = $this->userModel->obtenerRolesPorUsuarioId($id);

             // Si no posee ningún rol de usuario, se procede con la eliminación del usuario y del perfil
             if(count($rolesUsuario) < 1){

                                
                // Quitar asignación de perfil del usuario
                $this->userModel->actualizarUsuarioPerfil($id, NULL);

                // Eliminar usuario
                $this->userModel->eliminarUsuario($id);

                // Verificar si el perfil se encuentra registrado como Paciente
                $paciente = $this->pacienteModel->obtenerPacientePorPerfilPersona($perfilUsuario->idPerfilPersona);
                if($paciente == null){
                    // Eliminar perfil de usuario
                    $this->perfilPersonaModel->eliminarPerfilPersona($perfilUsuario->idPerfilPersona);
                }

             }

            flash('eliminarMedico_success', 'Los datos del médico fueron eliminados correctamente.');                    
            redirect('personalMedico');

        }
    }