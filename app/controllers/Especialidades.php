<?php
    class Especialidades extends Controller{
        public function __construct(){
            $this->especialidadModel = $this->model('Especialidad');
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

            $especialidades = $this->especialidadModel->obtenerEspecialidades();
            
            $data = [
                'especialidades' => $especialidades,
                'nombreEspecialidad' => ''
            ];
             
            $this->view('especialidades/index', $data);
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

                $data = [
                    'nombreEspecialidad' => trim($_POST['nombreEspecialidad'])
                ];

                // Validar Nombre Especialidad obligatorio
                if(empty($data['nombreEspecialidad'])){
                    $data['nombreEspecialidad_error'] = 'Por favor ingrese un titulo para la especialidad';
                }

                // Validar Nombre Especialidad existente
                if($this->especialidadModel->checkEspecialidad($data['nombreEspecialidad'])){
                    $data['nombreEspecialidad_error'] = 'La especialidad que intentó agregar ya existe';
                }

                // Asegurarse que no haya errores
                if(empty($data['nombreEspecialidad_error'])){
                    // Crear especialidad
                    if($this->especialidadModel->agregarEspecialidad($data['nombreEspecialidad'])){
                        flash('especialidad_success', 'Especialidad creada correctamente');
                        redirect('especialidades');
                    }
                    else{
                        die('Ocurrió un error inesperado');
                    }
                }
                else{
                    flash('especialidad_error', $data['nombreEspecialidad_error'], 'alert alert-danger');
                    redirect('especialidades');
                }
            }
        }
        
        public function eliminar(){

            //check User is loggedIn
            if(!isLoggedIn()){
                redirect('usuarios/login');
            }
            //check User Role -- Only ADMINISTRADOR allowed
            if(!checkLoggedUserRol("ADMINISTRADOR")){
                redirect('dashboard');
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
                    'especialidadToDelete' => trim($_POST['especialidadToDelete'])
                ];
                
                // Validar carga de especialidadToDelete
                if(empty($data['especialidadToDelete'])){
                    $data['especialidadToDelete_error'] = 'No se ha seleccionado la especialidad a eliminar';
                }

                // Asegurarse que no haya errores
                if(empty($data['especialidadToDelete_error'])){
                    // Crear especialidad
                    if($this->especialidadModel->eliminarEspecialidad($data['especialidadToDelete'])){
                        flash('especialidad_success', 'Especialidad eliminada exitosamente');
                        redirect('especialidades');
                    }
                    else{
                        die('Ocurrió un error inesperado');
                    }
                }
                else{
                    flash('especialidad_error', $data['especialidadToDelete_error'], 'alert alert-danger');
                    redirect('especialidades');
                }
            }
        }

        public function editar(){

            //check User is loggedIn
            if(!isLoggedIn()){
                redirect('usuarios/login');
            }
            //check User Role -- Only ADMINISTRADOR allowed
            if(!checkLoggedUserRol("ADMINISTRADOR")){
                redirect('dashboard');
            }
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
                    'especialidadToEditId' => trim($_POST['especialidadToEditId']),
                    'especialidadToEditNombre' => trim($_POST['especialidadToEditNombre'])
                ];
                
                // Validar carga de especialidadToEditId
                if(empty($data['especialidadToEditId'])){
                    $data['especialidadToEdit_error'] = 'No se ha seleccionado la especialidad a editar';
                }

                // Validar carga de especialidadToEditId
                if(empty($data['especialidadToEditNombre'])){
                    $data['especialidadToEdit_error'] = 'No se permite editar a un título vacío';
                }

                // Asegurarse que no haya errores
                if(empty($data['especialidadToEdit_error'])){
                    // Crear especialidad
                    if($this->especialidadModel->actualizarEspecialidad($data)){
                        flash('especialidad_success', 'Especialidad editada exitosamente');
                        redirect('especialidades');
                    }
                    else{
                        die('Ocurrió un error inesperado');
                    }
                }
                else{
                    flash('especialidad_error', $data['especialidadToEdit_error'], 'alert alert-danger');
                    redirect('especialidades');
                }
            }
        }
    }