<?php
    class Especialidad{
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        public function obtenerEspecialidades(){
            $this->db->query('SELECT idEspecialidad, nombreEspecialidad
                                FROM especialidad
                                ORDER BY nombreEspecialidad ASC');

            return $this->db->resultSet();
        }

        public function checkEspecialidad($tituloEspecialidad){
            $this->db->query('SELECT idEspecialidad, nombreEspecialidad
                                FROM especialidad
                                WHERE nombreEspecialidad = :nombreEspecialidad');
            $this->db->bind(':nombreEspecialidad', $tituloEspecialidad);

            $row = $this->db->single();

            // Check row
            if($this->db->rowCount() > 0){
                return  true;
            }
            else{
                return false;
            }
        }

        public function agregarEspecialidad($nombreEspecialidad){
            $this->db->query('INSERT INTO especialidad (nombreEspecialidad) VALUES (:nombreEspecialidad)');
            // Bind values
            $this->db->bind(':nombreEspecialidad', $nombreEspecialidad);

            // Execute
            if($this->db->execute()){
                return true;
            }
            else{
                return false;
            }
        }

        public function actualizarEspecialidad($data){
            $this->db->query('UPDATE especialidad SET nombreEspecialidad = :nombreEspecialidad WHERE idEspecialidad = :idEspecialidad');
            // Bind values
            $this->db->bind(':nombreEspecialidad', $data['especialidadToEditNombre']);
            $this->db->bind(':idEspecialidad', $data['especialidadToEditId']);
            

            // Execute
            if($this->db->execute()){
                return true;
            }
            else{
                return false;
            }
        }

        public function eliminarEspecialidad($id){
            $this->db->query('DELETE FROM especialidad WHERE idEspecialidad = :idEspecialidad');
            // Bind values
            $this->db->bind(':idEspecialidad', $id);            

            // Execute
            if($this->db->execute()){
                return true;
            }
            else{
                return false;
            }
        }

        public function obtenerEspecialidadesPorPerfilPersona($perfilPersonaId){
            $this->db->query('SELECT e.*
                                FROM especialidad e
                                JOIN perfilespecialidad pe ON pe.especialidadId = e.idEspecialidad
                                WHERE pe.perfilPersonaId = :perfilPersonaId');
            $this->db->bind(':perfilPersonaId', $perfilPersonaId);

            $row = $this->db->resultSet();

            return $row;
        }

        public function eliminarEspecialidadesPorPerfilPersona($perfilPersonaId){
            $this->db->query('DELETE FROM perfilespecialidad WHERE perfilPersonaId = :perfilPersonaId');
            $this->db->bind(':perfilPersonaId', $perfilPersonaId);

            if($this->db->execute()){
                return true;
            }
            else{
                return false;
            }
        }
    }
