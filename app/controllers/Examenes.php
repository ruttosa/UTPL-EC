<?php
    class Examenes extends Controller{

        public function __construct(){
            $this->examenModel = $this->model('Examen');
            $this->especialidadModel = $this->model('Especialidad');
            $this->pacienteModel = $this->model('Paciente');
            $this->citaMedicaModel = $this->model('CitaMedica');
            $this->examenModel = $this->model('Examen');
            $this->recetaModel = $this->model('RecetaMedica');
        }

        public function index(){

            if(!isLoggedIn()){
                redirect('usuarios/login');
            }

            $data = [
                'examenes' => [], 
                'sinExamenes_error' => ''
            ];
            $vista = 'index';
            
            //check User Role -- Only ADMINISTRADOR allowed
            if(checkLoggedUserRol("ADMINISTRADOR")){
                $vista = "administrador";
                $data['examenes'] = $this->examenModel->ObtenerExamenesSolicitados();
            }

            //check User Role -- Only MEDICO allowed
            else if(checkLoggedUserRol("MEDICO")){
                $vista = "medico";
                $examenes = $this->examenModel->obtenerExamenesSolicitadosPorMedico($_SESSION['user_id']);

                if(count($examenes) > 0){
                    $data['examenes'] = $examenes;
                }
                else{
                    $data['sinExamenes_error'] = "Actualmente no tiene ninguna cita pendiente";
                }
            }

            //check User Role -- Only CLIENTE allowed
            else if(checkLoggedUserRol("CLIENTE")){
                $vista = 'cliente';
                // Obligar a completar el perfil para continuar en la aplicación
                if($_SESSION["cliente_sin_perfil"]){
                    flash('perfil_obligatorio_warning', 'Debe completar su perfil para acceder al sistema', 'alert alert-warning');
                    redirect('clientes/perfil/' . $_SESSION['user_id']);
                }

                // Obtener pacientes
                $pacientes = $this->pacienteModel->obtenerPacientesPorCliente($_SESSION['user_id']);
                foreach ($pacientes as $paciente) {
                    // Obtener citas medicas por paciente
                    $examenes = $this->examenModel->obtenerExamenesSolicitadosPorPaciente($paciente->idPaciente);
                    if(isset($examenes)){
                        foreach($examenes as $examen){
                            // Cargar registros para la vista                        
                            array_push($data['examenes'], $examen);
                        }  
                    }                 
                }

                //$data['examenes'] = $this->citaMedicaModel->obtenerexamenesPorPaciente();
                /* $data['examenes'] = $this->citaMedicaModel->obtenerexamenesPorPaciente(); */
            }
             
            $this->view('examenes/' . $vista, $data);
        }

        /* Obtener Catálogo de exámenes */
        public function obtenerExamenes(){

            //check User is loggedIn
            if(!isLoggedIn()){
                redirect('usuarios/login');
            }

            $result = $this->examenModel->obtenerExamenes();

            echo json_encode($result);                
        }

        /* Obtener examenes solicitados por cita médica */
        public function obtenerExamenesPorCitaMedica($citaMedicaId){

            //check User is loggedIn
            if(!isLoggedIn()){
                redirect('usuarios/login');
            }

            $result = $this->examenModel->obtenerExamenesPorCitaMedica($citaMedicaId);

            echo json_encode($result);                
        }
    }