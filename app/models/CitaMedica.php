<?php
    class CitaMedica{
        private $db;
        
        public function __construct(){
            $this->db = new Database();
        }


        // Obtener todas las citas médicas del sistema
        public function obtenerCitasMedicas(){
            $this->db->query("SELECT 
                                    cm.*, 
                                    p.nombreCompleto as pacienteNombre, 
                                    p.apellidoCompleto as pacienteApellido, 
                                    p2.nombreCompleto as medicoNombre, 
                                    p2.apellidoCompleto as medicoApellido, 
                                    e.nombreEspecialidad as especialidad,
                                    h.nombreHorario, 
                                    h.horaInicio, 
                                    h.horaFin
                                FROM citamedica cm
                                    JOIN paciente pu ON pu.idPaciente = cm.pacienteId
                                    JOIN perfilpersona p ON p.idPerfilPersona = pu.perfilPersonaId
                                    JOIN usuario u ON u.idUsuario = cm.medicoId
                                    JOIN perfilpersona p2 ON p2.idPerfilPersona = u.perfilPersonaId
                                    JOIN especialidad e ON e.idEspecialidad = cm.especialidadId
                                    JOIN horarioatencion h ON h.idHorarioAtencion = cm.horarioAtencionId
                                ORDER BY cm.fechaSolicitud DESC");

            return $this->db->resultSet();
        }

        // Obtener citas medicas por paciente
        public function obtenerCitasMedicasPorPaciente($pacienteId){
            $this->db->query("SELECT 
                                    cm.*, 
                                    p.nombreCompleto as pacienteNombre, 
                                    p.apellidoCompleto as pacienteApellido, 
                                    p2.nombreCompleto as medicoNombre, 
                                    p2.apellidoCompleto as medicoApellido, 
                                    e.nombreEspecialidad as especialidad,
                                    h.nombreHorario, 
                                    h.horaInicio, 
                                    h.horaFin
                                FROM citamedica cm
                                    JOIN paciente pu ON pu.idPaciente = cm.pacienteId
                                    JOIN perfilpersona p ON p.idPerfilPersona = pu.perfilPersonaId
                                    JOIN usuario u ON u.idUsuario = cm.medicoId
                                    JOIN perfilpersona p2 ON p2.idPerfilPersona = u.perfilPersonaId
                                    JOIN especialidad e ON e.idEspecialidad = cm.especialidadId
                                    JOIN horarioatencion h ON h.idHorarioAtencion = cm.horarioAtencionId                                    
                                WHERE cm.pacienteId = :pacienteId
                                ORDER BY cm.estado ASC, cm.fechaSolicitud ASC");
            $this->db->bind(":pacienteId", $pacienteId);

            return $this->db->resultSet();
        }

        // Obtener citas medicas por medico
        public function obtenerCitasMedicasPorMedico($medicoId){
            $this->db->query("SELECT 
                                    cm.*, 
                                    p.nombreCompleto as pacienteNombre, 
                                    p.apellidoCompleto as pacienteApellido, 
                                    p2.nombreCompleto as medicoNombre, 
                                    p2.apellidoCompleto as medicoApellido, 
                                    e.nombreEspecialidad as especialidad,
                                    h.nombreHorario, 
                                    h.horaInicio, 
                                    h.horaFin
                                FROM citamedica cm
                                    JOIN paciente pu ON pu.idPaciente = cm.pacienteId
                                    JOIN perfilpersona p ON p.idPerfilPersona = pu.perfilPersonaId
                                    JOIN usuario u ON u.idUsuario = cm.medicoId
                                    JOIN perfilpersona p2 ON p2.idPerfilPersona = u.perfilPersonaId
                                    JOIN especialidad e ON e.idEspecialidad = cm.especialidadId
                                    JOIN horarioatencion h ON h.idHorarioAtencion = cm.horarioAtencionId                                    
                                WHERE cm.medicoId = :medicoId
                                ORDER BY cm.estado ASC, cm.fechaSolicitud ASC");
            $this->db->bind(":medicoId", $medicoId);

            return $this->db->resultSet();
        }

        // Obtener detalle cita médica
        public function obtenerCitaMedica($citaMedicaId){
            $this->db->query("SELECT 
                                    cm.*, 
                                    p.nombreCompleto as pacienteNombre, 
                                    p.apellidoCompleto as pacienteApellido, 
                                    p2.nombreCompleto as medicoNombre, 
                                    p2.apellidoCompleto as medicoApellido, 
                                    e.nombreEspecialidad as especialidad,
                                    h.nombreHorario, 
                                    h.horaInicio, 
                                    h.horaFin
                                FROM citamedica cm
                                    JOIN paciente pu ON pu.idPaciente = cm.pacienteId
                                    JOIN perfilpersona p ON p.idPerfilPersona = pu.perfilPersonaId
                                    JOIN usuario u ON u.idUsuario = cm.medicoId
                                    JOIN perfilpersona p2 ON p2.idPerfilPersona = u.perfilPersonaId
                                    JOIN especialidad e ON e.idEspecialidad = cm.especialidadId
                                    JOIN horarioatencion h ON h.idHorarioAtencion = cm.horarioAtencionId                                    
                                WHERE cm.idCitaMedica = :citaMedicaId
                                ORDER BY cm.fechaSolicitud DESC");
            $this->db->bind(":citaMedicaId", $citaMedicaId);

            $row = $this->db->single();

            if($this->db->rowCount() > 0){
                return $row;
            }
            else{
                return null;
            }
        }

        // Cancelar Cita Médica --> Actualiza el campo Estado a "CANCELADA"
        public function cancelarCitaMedica($citaMedicaId){
            //$this->db->query("UPDATE citamedica SET estado = 'CANCELADA' WHERE idCitaMedica = :citaMedicaId");
            $this->db->query("DELETE FROM citamedica WHERE idCitaMedica = :citaMedicaId");
            $this->db->bind(':citaMedicaId', $citaMedicaId);
            if($this->db->execute()){
                return true;
            }
            else{
                return false;
            }
        }

        // Obtener disponiblidad médica por especialidad y fecha de solicitud
        public function obtenerMedicosDisponibles($especialidadId, $fecha){
            try {
                //$this->db->connect();
                $this->db->query("CALL sp_consultaDisponiblidadMedica(:especialidadId, :fecha)");
                $this->db->bind(':especialidadId', $especialidadId);
                $this->db->bind(':fecha', $fecha);
                
                $row = $this->db->resultSet();
                //$this->db->clear();
                return $row;
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        // Crear Cita Médica
        public function crearCitaMedica($data){
            $this->db->query("INSERT INTO citamedica (fechaSolicitud, especialidadId, medicoId, horarioAtencionId, pacienteId, motivo, estado)
                                VALUES (:fechaSolicitud, :especialidadId, :medicoId, :horarioAtencionId, :pacienteId, :motivo, :estado)");
            $this->db->bind(":fechaSolicitud", $data['fechaCitaMedica']);
            $this->db->bind(":especialidadId", $data['especialidad']);
            $this->db->bind(":medicoId", $data['doctor']);
            $this->db->bind(":horarioAtencionId", $data['horarioAtencion']);
            $this->db->bind(":pacienteId", $data['paciente']);
            $this->db->bind(":motivo", $data['motivoConsulta']);
            $this->db->bind(":estado", "AGENDADA");

            if($this->db->execute()){
                return $this->db->lastInsertId();
            }
            else{
                return null;
            }
        }

        public function registrarDiagnosticoCitaMedica($citaMedicaId, $resumenDiagnostico, $detalleDiagnostico, $fechaProximoControl){
            $this->db->query('UPDATE citaMedica SET 
                                diagnosticoResumen = :resumenDiagnostico,
                                diagnosticoDetalle = :detalleDiagnostico,
                                fechaProximoControl = :fechaProximoControl,
                                estado = "ATENDIDA"
                                WHERE idCitaMedica = :citaMedicaId');
            $this->db->bind(':resumenDiagnostico', $resumenDiagnostico);
            $this->db->bind(':detalleDiagnostico', $detalleDiagnostico);
            if(!empty($fechaProximoControl)){
                $this->db->bind(':fechaProximoControl', $fechaProximoControl);
            }else{
                $this->db->bind(':fechaProximoControl', null);
            }
            $this->db->bind(':citaMedicaId', $citaMedicaId);
            
            // Execute
            if($this->db->execute()){
                return true;
            }
            else{
                return false;
            }
        }
    }