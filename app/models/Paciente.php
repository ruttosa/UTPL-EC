<?php
    class Paciente{
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        public function obtenerPacientePorId($pacienteId){
            $this->db->query('SELECT p.idPaciente, pp.*
                                FROM paciente p  
                                JOIN perfilpersona pp ON pp.idPerfilPersona = p.perfilPersonaId 
                                WHERE p.idPaciente = :pacienteId');
            $this->db->bind(':pacienteId', $pacienteId);

            $row = $this->db->single();

            if($this->db->rowCount() > 0){
                return $row;
            }
            else{
                return null;
            }
        }

        public function obtenerPacientePorPerfilPersona($perfilPersonaId){
            $this->db->query('SELECT * FROM paciente WHERE perfilPersonaId = :perfilPersonaId');
            $this->db->bind(':perfilPersonaId', $perfilPersonaId);

            $row = $this->db->single();

            if($this->db->rowCount() > 0){
                return $row;
            }
            else{
                return null;
            }
        }

        public function obtenerPerfilPacientePorDocumento($documento){
            $this->db->query('SELECT p.idPaciente, pp.*
                                FROM paciente p  
                                JOIN perfilpersona pp ON pp.idPerfilPersona = p.perfilPersonaId
                                WHERE pp.documento = :documento');
            $this->db->bind(':perfilPersonaId', $documento);

            $row = $this->db->single();

            if($this->db->rowCount() > 0){
                return $true;
            }
            else{
                return false;
            }
        }

        public function crearPaciente($perfilPersonaId){
            $this->db->query("INSERT INTO paciente (perfilPersonaId) VALUES (:perfilPersonaId)");
            $this->db->bind(':perfilPersonaId', $perfilPersonaId);

            if($this->db->execute()){
                return $this->db->lastInsertId();
            }
            else{
                return null;
            }
        }

        public function asignarPacienteCliente($pacienteId, $clienteId){
            $this->db->query("INSERT INTO clientepaciente (usuarioId, pacienteId) VALUES (:clienteId, :pacienteId)");
            $this->db->bind(':clienteId', $clienteId);
            $this->db->bind(':pacienteId', $pacienteId);

            if($this->db->execute()){
                return $this->db->lastInsertId();
            }
            else{
                return null;
            }
        }

        public function obtenerPacientes(){
            $this->db->query('SELECT p.idPaciente, pp.*
                                FROM paciente p  
                                JOIN perfilpersona pp ON pp.idPerfilPersona = p.perfilPersonaId');
            $this->db->bind(':clienteId', $clienteId);

            $row = $this->db->resultSet();

            if($this->db->rowCount() > 0){
                return $row;
            }
            else{
                return null;
            }
        }

        public function obtenerPacientesPorCliente($clienteId){
            $this->db->query('SELECT p.idPaciente, pp.*
                                FROM paciente p  
                                JOIN perfilpersona pp ON pp.idPerfilPersona = p.perfilPersonaId
                                JOIN clientepaciente cp ON cp.pacienteId = p.idPaciente
                                WHERE cp.usuarioId = :clienteId');
            $this->db->bind(':clienteId', $clienteId);

            $row = $this->db->resultSet();

            if($this->db->rowCount() > 0){
                return $row;
            }
            else{
                return null;
            }
        }
    }
