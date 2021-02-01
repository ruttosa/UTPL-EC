<?php
    class Consultas extends Controller{

        public function __construct(){
            $this->especialidadModel = $this->model('Especialidad');
            $this->pacienteModel = $this->model('Paciente');
            $this->citaMedicaModel = $this->model('CitaMedica');
            $this->examenModel = $this->model('Examen');
            $this->recetaModel = $this->model('RecetaMedica');
        }

        public function agendar(){

            //check User is loggedIn
            if(!isLoggedIn()){
                redirect('usuarios/login');
            }
            //check User Role -- Only CLIENTE allowed
            if(!checkLoggedUserRol("CLIENTE")){
                redirect('dashboard');
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $especialidades = $this->especialidadModel->obtenerEspecialidades();
                $pacientes =  $this->pacienteModel->obtenerPacientesPorCliente($_SESSION['user_id']);

                $data = [
                    'especialidades' => $especialidades,
                    'especialidad' => trim($_POST['especialidad']),
                    'especialidad_error' => '',
                    'fechaCitaMedica' => trim($_POST['fechaCitaMedica']),
                    'fechaCitaMedica_error' => '',
                    'doctor' => trim($_POST['doctorSelected']),
                    'doctor_error' => '',
                    'horarioAtencion' => trim($_POST['horarioSelected']),
                    'horarioAtencion_error' => '',
                    'pacientes' => $pacientes,
                    'paciente' => trim($_POST['paciente']),
                    'paciente_error' => '',
                    'motivoConsulta' => trim($_POST['motivoConsulta']),
                    'motivoConsulta_error' => ''
                ];
                if($data['especialidad'] != null && $data['fechaCitaMedica'] != null){
                    $data['medicosDisponibles'] = $this->citaMedicaModel->obtenerMedicosDisponibles($data['especialidad'], $data['fechaCitaMedica']); 
                }
                // Validar Datos
                $dataValidated = validarFormularioAgendamientoCita($data);
                $data = $dataValidated['data'];
                $dataValid = $dataValidated['valid'];

                // Asegurarse que no haya errores
                if($dataValid){
                    
                    $citaMedicaId = $this->citaMedicaModel->crearCitaMedica($data);

                    if($citaMedicaId != null){
                        flash('registroConsulta_success', "Su cita ha sido registrada con éxito. Cita #" . $citaMedicaId, 'alert alert-success');
                        redirect('consultas/agendar');
                    }
                    else{
                        flash('registroConsulta_error', "Ha ocurrido un error inesperado durante el registro de su cita. Por favor comuníquese con el administrador del sistema.", 'alert alert-danger');
                        return $this->view('consultas/agendar', $data);
                    }                    
                }
                else{
                    flash('registroConsulta_error', "Faltan campos obligatorios por completar", 'alert alert-danger');
                    return $this->view('consultas/agendar', $data);
                }               
            }
            else{
                $especialidades = $this->especialidadModel->obtenerEspecialidades();
                $pacientes =  $this->pacienteModel->obtenerPacientesPorCliente($_SESSION['user_id']);

                $data = [
                    'especialidades' => $especialidades,
                    'especialidad' => "",
                    'especialidad_error' => "",
                    'pacientes' => $pacientes,
                    'paciente' => '',
                    'paciente_error',
                    'motivoConsulta' => '',
                    'motivoConsulta_error' => '',
                    'medicosDisponibles' => '',
                    'doctor' => '',
                    'doctor_error' => '',
                    'horarioAtencion' => '',
                    'horarioAtencion_error' => '',
                    'fechaCitaMedica' => '',
                    'fechaCitaMedica_error' => ''
                ];

                return $this->view('consultas/agendar', $data);
            }
        }

        public function consultaDisponibilidad(){
            //check User is loggedIn
            if(!isLoggedIn()){
                redirect('usuarios/login');
            }
            //check User Role -- Only CLIENTE allowed
            if(!checkLoggedUserRol("CLIENTE")){
                redirect('dashboard');
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $data = [
                    'especialidad' => trim($_POST['especialidad']),
                    'fechaCitaMedica' => trim($_POST['fechaCitaMedica'])
                ];

                $result = $this->citaMedicaModel->obtenerMedicosDisponibles($data['especialidad'], $data['fechaCitaMedica']);

                echo json_encode($result);                
            }
        }

        public function historiaMedica($citaMedicaId){   
            
            //check User is loggedIn
            if(!isLoggedIn()){
                redirect('usuarios/login');
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // View Model
                $data = [
                    'citaMedicaId' => $citaMedicaId,
                    'citaMedica' => null, 
                    'resumenDiagnostico' => $_POST['resumenDiagnostico'],
                    'resumenDiagnostico_error' => '',
                    'detalleDiagnostico' => trim($_POST['detalleDiagnostico']),
                    'detalleDiagnostico_error' => '',
                    'fechaProximoControl' => $_POST['fechaProximoControl']
                ];

                // Carga datos de la cita medica
                $citaMedica = $this->citaMedicaModel->obtenerCitaMedica($citaMedicaId); 
                if(isset($citaMedica)){
                    $data['citaMedica'] = $citaMedica;
                }

                // Validar Datos
                $dataValidated = validarFormularioRegistroDiagnostico($data);
                $data = $dataValidated['data'];
                $dataValid = $dataValidated['valid'];

                if($dataValid){

                    try {
                        // Registrar Diagnóstico
                        $diagnosticoAplicado = $this->citaMedicaModel->registrarDiagnosticoCitaMedica($citaMedicaId, $data['resumenDiagnostico'], $data['detalleDiagnostico'], $data['fechaProximoControl']);

                        if($diagnosticoAplicado){
                            $errorsCount = 0;
                            $errorsMsgs = '';
                            // Procesar recetas
                            if($_POST['recetasTotales'] > 0){
                                $recetas = $_POST['recetas'];
                                foreach ($recetas as $receta) {
                                    $recetaId = $receta['id'];
                                    $recetaDetalle = $receta['detalle'];
                                    $recetaIndicacion = $receta['indicaciones'];
                                    
                                    $recetaId = $this->recetaModel->registrarReceta($citaMedicaId, $recetaDetalle, $recetaIndicacion);

                                    if(!isset($recetaId)){
                                        $errorsCount += 1;
                                        $errorsMsgs += 'Ocurrió un error registrando la receta #' . $recetaId;
                                    }
                                }
                            }

                            // Procesar examenes
                            if($_POST['examenesTotales'] > 0){
                                $examenes = $_POST['examenes'];
                                foreach ($examenes as $receta) {
                                    $examenId = $receta['id'];
                                    $examenDetalle = $receta['detalle'];
                                    $examenIndicacion = $receta['indicaciones'];

                                    $examenId = $this->examenModel->solicitarExamen($citaMedicaId, $examenDetalle, $examenIndicacion);

                                    if(!isset($examenId)){
                                        $errorsCount += 1;
                                        $errorsMsgs += 'Ocurrió un error registrando el exámen #' . $examenId;
                                    }
                                }
                            }

                            if($errorsCount > 0){
                                flash('registroDiagnositco_error', $errorsMsgs, 'alert alert-danger');
                                return $this->view('consultas/historiaMedica', $data);
                            }

                            // Registro de diagnóstico completo
                            flash('registroDiagnositco_success', "Diagnósitco registrado exitosamente", 'alert alert-success');
                            redirect('consultas/historiaMedica/' . $citaMedicaId);
                        }
                        else{
                            // registro del diagnóstico no realizado
                        }
                    } catch (Exception $err) {
                        flash('registroDiagnositco_error', "Ocurrió un error durante el registro del dignóstico. Mensaje de error: " . $err->getMessage(), 'alert alert-danger');
                        return $this->view('consultas/historiaMedica', $data);
                    }
                }
                else{
                    flash('registroDiagnositco_error', "Faltan campos obligatorios por completar", 'alert alert-danger');
                    return $this->view('consultas/historiaMedica', $data);
                }
            }
            else{
                $data = [
                    'citaMedicaId' => $citaMedicaId,
                    'citaMedica' => null, 
                    'resumenDiagnostico' => '',
                    'resumenDiagnostico_error' => '',
                    'detalleDiagnostico' => '',
                    'detalleDiagnostico_error' => '' ,
                    'fechaProximoControl' => ''     
                ];
    
                $citaMedica = $this->citaMedicaModel->obtenerCitaMedica($citaMedicaId);    
                if(isset($citaMedica)){
                    $data['citaMedica'] = $citaMedica;
                }
    
                // Obtener detalle de la cita médica
                return $this->view("consultas/historiaMedica", $data);
            }
        }

    }