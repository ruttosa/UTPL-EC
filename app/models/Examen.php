<?php
    class Examen{

        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        /* Obtener el catálogo de exámenes disponibles */
        public function obtenerExamenes(){
            $this->db->query('SELECT idExamen, nombreExamen
                                FROM examen
                                ORDER BY nombreExamen ASC');

            return $this->db->resultSet();
        }

        /* Realizar la solicitud de un exámen para una cita médica */
        public function SolicitarExamen($citaMedicaId, $examenId, $indicaciones){
            $this->db->query('INSERT INTO solicitudexamen (citaMedicaId, examenId, indicaciones) 
                                VALUES (:citaMedicaId, :examenId, :indicaciones)');
            $this->db->bind(':citaMedicaId', $citaMedicaId);
            $this->db->bind(':examenId', $examenId);
            $this->db->bind(':indicaciones', $indicaciones);

            if($this->db->execute()){
                return $this->db->lastInsertId();
            }
            else{
                return null;
            }
        }

        /* Obtener todos los examenes solicitados */
        public function ObtenerExamenesSolicitados(){
            $this->db->query('SELECT e.idExamen, e.nombreExamen, 
                                        cm.idCitaMedica, cm.fechaSolicitud,
                                        cm.pacienteId, pp1.nombreCompleto as pacienteNombre, pp1.apellidoCompleto as pacienteApellido, 
                                        cm.medicoId, pp2.nombreCompleto as medicoNombre, pp2.apellidoCompleto as medicoApellido, cm.especialidadId, es.nombreEspecialidad
                                    FROM examen e
                                        JOIN solicitudexamen se ON se.examenId = e.idExamen
                                        JOIN citamedica cm ON cm.idCitaMedica = se.citaMedicaId
                                        JOIN paciente p ON p.idPaciente = cm.pacienteId
                                        JOIN perfilpersona pp1 ON pp1.idPerfilPersona = p.perfilPersonaId
                                        JOIN usuario u ON u.idUsuario = cm.medicoId
                                        JOIN perfilpersona pp2 ON pp2.idPerfilPersona = u.perfilPersonaId
                                        JOIN especialidad es ON es.idEspecialidad = cm.especialidadId');;
            
            return $this->db->resultSet();
        }

        /* Obtener los examenes por paciente */
        public function obtenerExamenesSolicitadosPorPaciente($pacienteId){
            $this->db->query('SELECT e.idExamen, e.nombreExamen, 
                                        cm.idCitaMedica, cm.fechaSolicitud,
                                        cm.pacienteId, pp1.nombreCompleto as pacienteNombre, pp1.apellidoCompleto as pacienteApellido, 
                                        cm.medicoId, pp2.nombreCompleto as medicoNombre, pp2.apellidoCompleto as medicoApellido, cm.especialidadId, es.nombreEspecialidad
                                    FROM examen e
                                        JOIN solicitudexamen se ON se.examenId = e.idExamen
                                        JOIN citamedica cm ON cm.idCitaMedica = se.citaMedicaId
                                        JOIN paciente p ON p.idPaciente = cm.pacienteId
                                        JOIN perfilpersona pp1 ON pp1.idPerfilPersona = p.perfilPersonaId
                                        JOIN usuario u ON u.idUsuario = cm.medicoId
                                        JOIN perfilpersona pp2 ON pp2.idPerfilPersona = u.perfilPersonaId
                                        JOIN especialidad es ON es.idEspecialidad = cm.especialidadId
                                    WHERE cm.pacienteId = :pacienteId');

            $this->db->bind(':pacienteId', $pacienteId); 

            $row = $this->db->resultSet();
            if($this->db->rowCount() > 0){
                return $row;
            }
            else{
                return null;
            }
        }

        /* Obtener los examenes por medico */
        public function obtenerExamenesSolicitadosPorMedico($medicoId){
            $this->db->query('SELECT e.idExamen, e.nombreExamen, 
                                        cm.idCitaMedica, cm.fechaSolicitud,
                                        cm.pacienteId, pp1.nombreCompleto as pacienteNombre, pp1.apellidoCompleto as pacienteApellido, 
                                        cm.medicoId, pp2.nombreCompleto as medicoNombre, pp2.apellidoCompleto as medicoApellido, cm.especialidadId, es.nombreEspecialidad
                                    FROM examen e
                                        JOIN solicitudexamen se ON se.examenId = e.idExamen
                                        JOIN citamedica cm ON cm.idCitaMedica = se.citaMedicaId
                                        JOIN paciente p ON p.idPaciente = cm.pacienteId
                                        JOIN perfilpersona pp1 ON pp1.idPerfilPersona = p.perfilPersonaId
                                        JOIN usuario u ON u.idUsuario = cm.medicoId
                                        JOIN perfilpersona pp2 ON pp2.idPerfilPersona = u.perfilPersonaId
                                        JOIN especialidad es ON es.idEspecialidad = cm.especialidadId
                                    WHERE cm.medicoId = :medicoId');
            $this->db->bind(':medicoId', $medicoId);            
            
            $row = $this->db->resultSet();
            if($this->db->rowCount() > 0){
                return $row;
            }
            else{
                return null;
            }
        }

    }