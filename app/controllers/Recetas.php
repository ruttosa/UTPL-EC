<?php
    class Recetas extends Controller{

        public function __construct(){
            $this->pacienteModel = $this->model('Paciente');
            $this->recetaModel = $this->model('RecetaMedica');
        }

        public function index(){

            if(!isLoggedIn()){
                redirect('usuarios/login');
            }

            $data = [
                'dashboard_type' => '',
                'recetas' => [], 
                'sinCitas_error' => ''
            ];
            $vista = 'index';
            
            //check User Role -- Only ADMINISTRADOR allowed
            if(checkLoggedUserRol("ADMINISTRADOR")){
                $vista = "administrador";
                $data['dashboard_type'] = 'ADMINISTRADOR';
                $data['recetas'] = $this->recetaModel->obtenerRecetas();
            }

            //check User Role -- Only MEDICO allowed
            if(checkLoggedUserRol("MEDICO")){
                $vista = "medico";
                $recetas = $this->recetaModel->obtenerRecetasPorMedico($_SESSION['user_id']);

                if(isset($recetas)){
                    $data['recetas'] = $this->recetaModel->obtenerRecetasPorMedico($_SESSION['user_id']);
                }
                else{
                    $data['sinRecetas_error'] = "Actualmente no tiene ninguna cita pendiente";
                }
            }

            //check User Role -- Only CLIENTE allowed
            if(checkLoggedUserRol("CLIENTE")){
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
                    $recetas = $this->recetaModel->obtenerRecetasPorPaciente($paciente->idPaciente);
                    if(isset($recetas)){
                        foreach($recetas as $receta){
                            // Cargar registros para la vista                        
                            array_push($data['recetas'], $receta);
                        }
                    }                  
                }

                //$data['recetas'] = $this->recetaModel->obtenerRecetasPorPaciente();
                /* $data['recetas'] = $this->recetaModel->obtenerRecetasPorPaciente(); */
            }
             
            $this->view('recetas/' . $vista, $data);
        }
        
    }