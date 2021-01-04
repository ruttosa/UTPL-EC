<?php
    class Medico{
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        public function obtenerPersonalMedico(){
            $this->db->query("SELECT u.idUsuario, u.correo, p.documento, p.NombreCompleto, p.apellidoCompleto, p.telefono, p.direccion, 
                                FROM usuario u
                                JOIN perfilpersona p ON p.idPerfilPersona = u.perfilPersonaId
                                JOIN usuariorol ur ON ur.usuarioId = u.idUsuario
                                JOIN rol r ON r.idRol = ur.rolId
                                WHERE r.nombreRol = 'ADMINISTRADOR'
                                ORDER BY nombreUsuario ASC");

            return $this->db->resultSet();
        }

        public function agregarPersonalMedico(){
            
        }

    }