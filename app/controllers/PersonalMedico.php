<?php
    class PersonalMedico extends Controller{
        public function __construct(){
            $this->personalMedicoModel = $this->model('Medico');
            $this->especialidadModel = $this->model('Especialidad');
            $this->ciudadModel = $this->model('Ciudad');
            $this->horarioAtencionModel = $this->model('HorarioAtencion');
        }

        public function index(){

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
                'ciudad' => '',
                'ciudad_error' => '',
                'especialidad' => '',
                'especialidad_error' => '',
                'horarioAtencion' => '',
                'horarioAtencion_error' => ''
            ];
        
            return $this->view('personalMedico/index', $data);
        }

        public function agregar(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // Sanitize POST array
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

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
                $dataValidated = validarFormularioAgregarMedico($data);
                $data = $dataValidated['data'];
                $dataValid = $dataValidated['valid'];

                // Asegurarse que no haya errores
                if($dataValid){

                    // Crear Usuario
                    
                    // Crear Perfil

                    // Crear 
                    if($this->especialidadModel->agregarEspecialidad($data['nombreEspecialidad'])){
                        flash('agregarMedico_success', 'El médico fue regsitrado exitosamente');
                        redirect('personalMedico');
                    }
                    else{
                        die('Ocurrió un error inesperado');
                    }
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


    }