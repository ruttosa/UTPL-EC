<?php
    class Cliente{
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        /* Obtener todos los usuarios con rol CLIENTE */
        public function obtenerClientes(){
            $this->db->query("SELECT u.idUsuario, u.nombreUsuario, u.correo, pp.*
                                FROM usuario u
                                    JOIN perfilpersona pp ON pp.idPerfilPersona = u.perfilPersonaId
                                    JOIN usuariorol ur ON ur.usuarioId = u.idUsuario
                                    JOIN rol r ON r.idRol = ur.rolId
                                WHERE r.nombreRol = 'CLIENTE'");

            $row = $this->db->resultSet();
            if($this->db->rowCount() > 0){
                return $row;
            }
            else{
                return null;
            }
        }

    }