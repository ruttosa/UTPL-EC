<?php
    class HorarioAtencion{
        private $db;
        
        public function __construct(){
            $this->db = new Database();
        }

        public function obtenerHorariosDeAtencion(){
            $this->db->query('SELECT idHorarioAtencion, nombreHorario, horaInicio, horaFin
                                FROM horarioatencion
                                ORDER BY nombreHorario ASC');

            return $this->db->resultSet();
        }

        public function obtenerHorariosDeAtencionPorPerfilPersona($perfilPersonaId){
            $this->db->query('SELECT h.*
                                FROM horarioatencion h
                                JOIN perfilhorarioatencion p ON p.horarioAtencionId = h.idHorarioAtencion
                                WHERE p.perfilPersonaId = :perfilPersonaId');
            $this->db->bind(':perfilPersonaId', $perfilPersonaId);
            return $this->db->resultSet();
        }

        public function eliminarHorariosDeAtencionPorPerfilPersona($perfilPersonaId){
            $this->db->query('DELETE FROM perfilhorarioatencion WHERE perfilPersonaId = :perfilPersonaId');
            $this->db->bind(':perfilPersonaId', $perfilPersonaId);

            if($this->db->execute()){
                return true;
            }
            else{
                return false;
            }
        }

    }