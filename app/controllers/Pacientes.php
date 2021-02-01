<?php
    class Pacientes extends Controller{

        public function __construct(){
            $this->ciudadModel = $this->model('Ciudad');
            $this->pacienteModel = $this->model('Paciente');
            $this->perfilPersonaModel = $this->model('PerfilPersona');
        }

        public function index(){

            //check User is loggedIn
            if(!isLoggedIn()){
                redirect('usuarios/login');
            }
            //check User Role -- Only CLIENTE allowed
            if(!checkLoggedUserRol("CLIENTE")){
                redirect('dashboard');
            }
            
            $data = [];

            // Obtener pacientes del usuario actual
            $pacientes = $this->pacienteModel->obtenerPacientesPorCliente($_SESSION['user_id']);
            if(isset($pacientes)){
                $data = $pacientes;
            }

            return $this->view('pacientes/index', $data);
        }

        public function agregar(){

            //check User is loggedIn
            if(!isLoggedIn()){
                redirect('usuarios/login');
            }
            //check User Role -- Only CLIENTE allowed
            if(!checkLoggedUserRol("CLIENTE")){
                redirect('dashboard');
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Sanitize POST array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                //Obtener catálogos para la vista
                $ciudades = $this->ciudadModel->obtenerCiudades();

                //Cargar objeto con datos de la solicitud
                $data = [
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
                $dataValidated = validarFormularioPerfil("PACIENTE", $data);
                $data = $dataValidated['data'];
                $dataValid = $dataValidated['valid'];

                // Asegurarse que no haya errores
                if($dataValid){

                    // Verificar si el perfil ya existe mediante numero de documento
                    $perfilPersona = $this->perfilPersonaModel->obtenerPerfilPersonaDocumento($data['documento']);
                    if(!isset($perfilPersona)){
                        // Crear perfil de paciente
                        $perfilPersonaId = $this->perfilPersonaModel->crearPerfilPersona($data);
                    }
                    else{
                        $perfilPersonaId = $perfilPersona->idPerfilPersona;                      
                    }

                    // Verificar si el perfil es de un paciente
                    $paciente = $this->pacienteModel->obtenerPacientePorPerfilPersona($perfilPersonaId);
                    if(!isset($paciente)){
                        // Crear paciente
                        $pacienteId = $this->pacienteModel->crearPaciente($perfilPersonaId);
                    }
                    else{
                        $pacienteId = $paciente->idPaciente;
                    }

                    // Asociar paciente al cliente logueado actualmente
                    $asignacionPacienteCliente = $this->pacienteModel->asignarPacienteCliente($pacienteId, $_SESSION['user_id']);
                    flash('registroPaciente_success', "El registro del paciente ha sido realizado exitosamente", 'alert alert-success');

                    return $this->view('pacientes/agregar', $data);
                }
                else{
                    flash('registroPaciente_error', "Faltan campos obligatorios por completar", 'alert alert-danger');
                    return $this->view('pacientes/agregar', $data);
                }
            }
            else{
                $ciudades = $this->ciudadModel->obtenerCiudades();

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
                    'ciudad_error' => ''
                ];

                return $this->view('pacientes/agregar', $data);
            }
        }
    
        public function editar($pacienteId){

            //check User is loggedIn
            if(!isLoggedIn()){
                redirect('usuarios/login');
            }
            //check User Role -- Only CLIENTE allowed
            if(!checkLoggedUserRol("CLIENTE")){
                redirect('dashboard');
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                //Obtener catálogos para la vista
                $ciudades = $this->ciudadModel->obtenerCiudades();

                $data = [
                    'id'=> $pacienteId,
                    'nombreCompleto' => trim($_POST['nombreCompleto']),
                    'fechaNacimiento' => trim($_POST['fechaNacimiento']),
                    'apellidoCompleto' => trim($_POST['apellidoCompleto']),
                    'telefono' => trim($_POST['telefono']),
                    'correo' => trim($_POST['correo']),
                    'direccion' => trim($_POST['direccion']),
                    'documento' => trim($_POST['documento']),
                    'ciudades' => $ciudades,
                ];

                if(empty($_POST['genero'])){$data['genero'] = '';}else{$data['genero'] = $_POST['genero'];}
                if(empty($_POST['tipoDocumento'])){$data['tipoDocumento'] = '';}else{$data['tipoDocumento'] = $_POST['tipoDocumento'];}
                if(empty($_POST['ciudad'])){$data['ciudad'] = '';}else{$data['ciudad'] = $_POST['ciudad'];}

                // Validar Datos
                $dataValidated = validarFormularioPerfil("PACIENTE", $data);
                $data = $dataValidated['data'];
                $dataValid = $dataValidated['valid'];

                // Asegurarse que no haya errores
                if($dataValid){

                    $paciente = $this->pacienteModel->obtenerPacientePorId($pacienteId);

                    // Actualizar perfil
                    $this->perfilPersonaModel->actualizarPerfilPersona($paciente->idPerfilPersona, $data);


                    flash('edicionPaciente_success', 'Los datos del paciente fueron editados correctamente.', 'alert alert-success');                    
                    return $this->view('pacientes/editar', $data);
                }
                else{
                    flash('edicionPaciente_error', 'Los datos del paciente fueron editados correctamente.', 'alert alert-danger');                    
                    return $this->view('pacientes/editar', $data);
                }
            }
            else{
                $ciudades = $this->ciudadModel->obtenerCiudades();
                $paciente = $this->pacienteModel->obtenerPacientePorId($pacienteId);

                $data = [
                    'id' => $paciente->idPaciente,
                    'nombreCompleto' => $paciente->nombreCompleto,
                    'nombreCompleto_error' => '',
                    'fechaNacimiento' => $paciente->fechaNacimiento,
                    'fechaNacimiento_error' => '',
                    'genero' => $paciente->genero,
                    'apellidoCompleto' => $paciente->apellidoCompleto,
                    'apellidoCompleto_error' => '',
                    'telefono' => $paciente->telefono,
                    'telefono_error' => '',
                    'correo' => $paciente->correo,
                    'correo_error' => '',
                    'direccion' => $paciente->direccion,
                    'direccion_error' => '',
                    'documento' => $paciente->documento,
                    'documento_error' => '',
                    'tipoDocumento' => $paciente->tipoDocumento,
                    'tipoDocumento_error' => '',
                    'ciudades' => $ciudades,
                    'ciudad' => $paciente->ciudadResidencia,
                    'ciudad_error' => ''
                ];
                
                return $this->view('pacientes/editar', $data);              
            }
        }
    }
