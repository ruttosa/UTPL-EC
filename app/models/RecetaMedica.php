<?php
    class RecetaMedica{

        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        public function obtenerRecetas(){
            $this->db->query('SELECT r.idRecetaMedica, r.detalleMedicacion, r.indicaciones,
                                    r.citaMedicaId, cm.fechaSolicitud, cm.diagnosticoResumen, cm.especialidadId, e.nombreEspecialidad,
                                    cm.pacienteId, pp1.nombreCompleto as pacienteNombre, pp1.apellidoCompleto as pacienteApellido,
                                    cm.medicoId, pp2.nombreCompleto as medicoNombre, pp2.apellidoCompleto as medicoApellido
                                FROM recetamedica r
                                    JOIN citamedica cm ON cm.idCitaMedica = r.citaMedicaId
                                    JOIN especialidad e ON e.idEspecialidad = cm.especialidadId
                                    JOIN paciente p ON p.idPaciente = cm.pacienteId
                                    JOIN perfilpersona pp1 ON pp1.idPerfilPersona = p.perfilPersonaId
                                    JOIN usuario u ON u.idUsuario = cm.medicoId
                                    JOIN perfilpersona pp2 ON pp2.idPerfilPersona = u.perfilPersonaId');
            
            $rows = $this->db->resultSet();
            if($this->db->rowCount() > 0){
                return $rows;
            }
            else{
                return null;
            }
        }

        public function obtenerRecetasPorMedico($medicoId){
            $this->db->query('SELECT r.idRecetaMedica, r.detalleMedicacion, r.indicaciones,
                                    r.citaMedicaId, cm.fechaSolicitud, cm.diagnosticoResumen, cm.especialidadId, e.nombreEspecialidad,
                                    cm.pacienteId, pp1.nombreCompleto as pacienteNombre, pp1.apellidoCompleto as pacienteApellido,
                                    cm.medicoId, pp2.nombreCompleto as medicoNombre, pp2.apellidoCompleto as medicoApellido
                                FROM recetamedica r
                                    JOIN citamedica cm ON cm.idCitaMedica = r.citaMedicaId
                                    JOIN especialidad e ON e.idEspecialidad = cm.especialidadId
                                    JOIN paciente p ON p.idPaciente = cm.pacienteId
                                    JOIN perfilpersona pp1 ON pp1.idPerfilPersona = p.perfilPersonaId
                                    JOIN usuario u ON u.idUsuario = cm.medicoId
                                    JOIN perfilpersona pp2 ON pp2.idPerfilPersona = u.perfilPersonaId
                                WHERE cm.medicoId = :medicoId');
            $this->db->bind(":medicoId", $medicoId);

            $rows = $this->db->resultSet();
            if($this->db->rowCount() > 0){
                return $rows;
            }
            else{
                return null;
            }
        }

        public function obtenerRecetasPorPaciente($pacienteId){
            $this->db->query('SELECT r.idRecetaMedica, r.detalleMedicacion, r.indicaciones,
                                    r.citaMedicaId, cm.fechaSolicitud, cm.diagnosticoResumen, cm.especialidadId, e.nombreEspecialidad,
                                    cm.pacienteId, pp1.nombreCompleto as pacienteNombre, pp1.apellidoCompleto as pacienteApellido,
                                    cm.medicoId, pp2.nombreCompleto as medicoNombre, pp2.apellidoCompleto as medicoApellido
                                FROM recetamedica r
                                    JOIN citamedica cm ON cm.idCitaMedica = r.citaMedicaId
                                    JOIN especialidad e ON e.idEspecialidad = cm.especialidadId
                                    JOIN paciente p ON p.idPaciente = cm.pacienteId
                                    JOIN perfilpersona pp1 ON pp1.idPerfilPersona = p.perfilPersonaId
                                    JOIN usuario u ON u.idUsuario = cm.medicoId
                                    JOIN perfilpersona pp2 ON pp2.idPerfilPersona = u.perfilPersonaId
                                WHERE cm.pacienteId = :pacienteId');
            $this->db->bind(":pacienteId", $pacienteId);

            $rows = $this->db->resultSet();
            if($this->db->rowCount() > 0){
                return $rows;
            }
            else{
                return null;
            }
        }

        public function registrarReceta($citaMedicaId, $detalleMedicacion, $indicaciones){
            $this->db->query('INSERT INTO recetamedica (citaMedicaId, detalleMedicacion, indicaciones) 
                                VALUES (:citaMedicaId, :detalleMedicacion, :indicaciones)');
            $this->db->bind(':citaMedicaId', $citaMedicaId);
            $this->db->bind(':detalleMedicacion', $detalleMedicacion);
            $this->db->bind(':indicaciones', $indicaciones);

            if($this->db->execute()){
                return $this->db->lastInsertId();
            }
            else{
                return null;
            }
        }

        /* Obtener recetas solicitadas por cita médica */
        public function obtenerRecetaPorCitaMedica($citaMedicaId){
            $this->db->query('SELECT r.*
                                FROM recetamedica r
                                WHERE r.citaMedicaId = :citaMedicaId
                                ORDER BY r.idRecetaMedica ASC');
            $this->db->bind(":citaMedicaId", $citaMedicaId);

            $rows = $this->db->resultSet();
            if($this->db->rowCount() > 0){
                return $rows;
            }
            else{
                return null;
            }
        }

    }