<?php
    class Usuario{
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        // Registrar usuario
        public function crearUsuario($data){
            $this->db->query('INSERT INTO usuario (nombreUsuario, correo, password) VALUES (:nombreUsuario, :correo, :password)');
            // Bind values
            $this->db->bind(':nombreUsuario', $data['nombreUsuario']);
            $this->db->bind(':correo', $data['correo']);
            $this->db->bind(':password', $data['password']);

            // Execute
            if($this->db->execute()){
                return true;
            }
            else{
                return false;
            }
        }

        // Verificar Usario y Contraseña
        public function login($email, $password){
            $this->db->query('SELECT * FROM usuario where correo = :correo');
            $this->db-> bind(':correo', $email);

            $row = $this->db->single();

            $hashed_password = $row->password;

            if(password_verify($password, $hashed_password)){
                return $row; // return usuario registrado;
            }
            else{
                return false;
            }
        }

        // Obtener usuario por correo
        public function ObtenerUsuarioPorCorreo($email){
            $this->db->query('SELECT * FROM usuario WHERE correo = :correo');
            $this->db->bind(':correo', $email);

            $row = $this->db->single();

            // Check row
            if($this->db->rowCount() > 0){
                return  true;
            }
            else{
                return false;
            }
        }

        // Obtener usuario por ID
        public function ObtenerUsuarioPorId($id){
            $this->db->query('SELECT * FROM usuario WHERE idUsuario = :idUsuario');
            $this->db->bind(':idUsuario', $id);

            $row = $this->db->single();

            return $row;
        }

        // Obtener Rol por Usuario
        public function ObtenerRolesPorUsurioId($userId){

            $this->db->query('SELECT r.idRol, r.nombreRol 
                                FROM usuariorol ur 
                                JOIN rol r ON r.idRol = ur.RolId
                                WHERE ur.usuarioId = :idUsuario');
            $this->db->bind(':idUsuario', $userId);

            $rows = $this->db->resultSet();

            return $rows;
        }
    }