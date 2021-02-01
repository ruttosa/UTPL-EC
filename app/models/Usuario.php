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
                return $this->db->lastInsertId();
            }
            else{
                return null;
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

        // Validar usuario por correo
        public function validarUsuarioPorCorreo($email){
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

        // Obtener usuario por correo
        public function obtenerUsuarioPorCorreo($email){
            $this->db->query('SELECT * FROM usuario WHERE correo = :correo');
            $this->db->bind(':correo', $email);

            $row = $this->db->single();

            return $row;
        }

        // Obtener usuario por ID
        public function obtenerUsuarioPorId($id){
            $this->db->query('SELECT * FROM usuario WHERE idUsuario = :idUsuario');
            $this->db->bind(':idUsuario', $id);

            $row = $this->db->single();

            return $row;
        }

        // Obtener Rol por Usuario
        public function obtenerRolesPorUsuarioId($userId){

            $this->db->query('SELECT r.idRol, r.nombreRol 
                                FROM usuariorol ur 
                                JOIN rol r ON r.idRol = ur.RolId
                                WHERE ur.usuarioId = :idUsuario');
            $this->db->bind(':idUsuario', $userId);

            $rows = $this->db->resultSet();

            return $rows;
        }

        // Asignar Rol de Usuario
        public function asignarUsuarioRol($userId, $nombreRol){
            $this->db->query('SELECT idRol FROM rol WHERE nombreRol = :nombreRol');
            $this->db->bind(':nombreRol', $nombreRol);

            $rol = $this->db->single();

            $this->db->query('INSERT INTO usuariorol (usuarioId, rolId) VALUES (:usuarioId, :rolId)');
            $this->db->bind(':usuarioId', $userId);
            $this->db->bind(':rolId', $rol->idRol);

            if($this->db->execute()){
                return true;
            }
            else{
                return false;
            }

        }

        // Quitar Rol de Usuario
        public function quitarUsuarioRol($userId, $rolId){
            $this->db->query('DELETE from usuariorol WHERE usuarioId = :userId AND rolId = :rolId');
            $this->db->bind(':userId', $userId);
            $this->db->bind(':rolId', $rolId);

            if($this->db->execute()){
                return true;
            }
            else{
                return false;
            }
        }

        // Actualizar Perfil de Usuario del Usuario
        public function actualizarUsuarioPerfil($userId, $perfilPersonaId){
            $this->db->query('UPDATE usuario SET perfilPersonaId = :perfilPersonaId WHERE idUsuario = :usuarioId');
            $this->db->bind(':perfilPersonaId', $perfilPersonaId);
            $this->db->bind(':usuarioId', $userId);

            // Execute
            if($this->db->execute()){
                return true;
            }
            else{
                return false;
            }
        }

        // Eliminar Usuario
        public function eliminarUsuario($userId){
            $this->db->query('DELETE from usuario WHERE idUsuario = :userId');
            $this->db->bind(':userId', $userId);

            if($this->db->execute()){
                return true;
            }
            else{
                return false;
            }
        }

        public function crearSesionDeUsuario($user, $userRoles){
            $_SESSION['user_id'] = $user->idUsuario;
            $_SESSION['user_name'] = $user->nombreUsuario;
            $_SESSION['user_correo'] = $user->correo;
            $_SESSION['user_roles'] = $userRoles;

            $_SESSION["cliente_sin_perfil"] = !$this->verificarUsuarioPerfilAsignado($user->correo);
            
            return true;
        }
         
        public function verificarUsuarioPerfilAsignado($usuarioCorreo){

            $usuario = $this->obtenerUsuarioPorCorreo($usuarioCorreo);

            if(isset($usuario)){
                if($usuario->perfilPersonaId != null){
                    return true;
                }
            }
            return false;
        }
    }