<?php
    class Dashboard extends Controller{
        public function __construct(){
            $this->citaMedicaModel = $this->model('CitaMedica');
            $this->pacienteModel = $this->model('Paciente');;
        }

        public function index(){

            if(!isLoggedIn()){
                redirect('usuarios/login');
            }

            $data = [
                'dashboard_type' => '',
                'citasMedicas' => [], 
                'sinCitas_error' => ''
            ];
            $vista = 'index';
            
            //check User Role -- Only ADMINISTRADOR allowed
            if(checkLoggedUserRol("ADMINISTRADOR")){
                $vista = "administrador";
                $data['dashboard_type'] = 'ADMINISTRADOR';
                $data['citasMedicas'] = $this->citaMedicaModel->obtenerCitasMedicas();
            }

            //check User Role -- Only MEDICO allowed
            if(checkLoggedUserRol("MEDICO")){
                $vista = "medico";
                $citasMedicas = $this->citaMedicaModel->obtenerCitasMedicasPorMedico($_SESSION['user_id']);

                if(count($citasMedicas) > 0){
                    $data['citasMedicas'] = $this->citaMedicaModel->obtenerCitasMedicasPorMedico($_SESSION['user_id']);
                }
                else{
                    $data['sinCitas_error'] = "Actualmente no tiene ninguna cita pendiente";
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
                if(isset($pacientes)){
                    foreach ($pacientes as $paciente) {
                        // Obtener citas medicas por paciente
                        $citasMedicas = $this->citaMedicaModel->obtenerCitasMedicasPorPaciente($paciente->idPaciente);
                        if(isset($citasMedicas)){
                            foreach($citasMedicas as $citaMedica){
                                // Cargar registros para la vista                        
                                array_push($data['citasMedicas'], $citaMedica);
                            }
                        }                
                    }
                }
                //$data['citasMedicas'] = $this->citaMedicaModel->obtenerCitasMedicasPorPaciente();
                /* $data['citasMedicas'] = $this->citaMedicaModel->obtenerCitasMedicasPorPaciente(); */
            }
             
            $this->view('dashboards/' . $vista, $data);
        }

        public function cancelar($citaMedicaId){
            
            if($this->citaMedicaModel->cancelarCitaMedica($citaMedicaId)){
                flash('cancelarCita_success', 'La cita médica ha sido cancelada con éxito');
                redirect('dashboards/index');
            }

        }

        public function cliente(){

            if(!isLoggedIn()){
                redirect('usuarios/login');
            }

            $data = [
                'dashboard_type' => '',
                'citasMedicas' => []
            ];

            //check User Role -- Only MEDICO allowed
            if(checkLoggedUserRol("CLIENTE")){



            }
        }

    }