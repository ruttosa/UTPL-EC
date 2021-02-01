<?php
    class PerfilPersona{
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        public function obtenerPerfilPersonaPorUsuarioId($usuarioId){
            $this->db->query("SELECT u.idUsuario, p.idPerfilPersona, u.correo, p.documento, p.tipoDocumento, p.NombreCompleto, p.apellidoCompleto, p.fechaNacimiento, p.genero, p.telefono, p.direccion, c.*
                                FROM usuario u
                                JOIN perfilpersona p ON p.idPerfilPersona = u.perfilPersonaId
                                JOIN ciudad c ON c.idCiudad = p.ciudadResidencia
                                WHERE u.idUsuario = :usuarioId
                                ORDER BY u.nombreUsuario ASC");

            $this->db->bind(':usuarioId', $usuarioId);

            return $this->db->single();
        }

        public function obtenerPerfilPersonaDocumento($documento){
            $this->db->query('SELECT * FROM perfilpersona WHERE documento = :documento');
            $this->db->bind(':documento', $documento);

            $row = $this->db->single();
            
            if($this->db->rowCount() > 0){
                return $row;
            }
            else{
                return null;
            }
        }

        public function crearPerfilPersona($data){
            $this->db->query('INSERT INTO perfilpersona (documento, tipoDocumento, nombreCompleto, apellidoCompleto, correo, telefono, direccion, ciudadResidencia, fechaNacimiento, genero) 
                                VALUES (:documento, :tipoDocumento, :nombreCompleto, :apellidoCompleto, :correo, :telefono, :direccion, :ciudadResidencia, :fechaNacimiento, :genero)');
            $this->db->bind(':documento', $data['documento']);
            $this->db->bind(':tipoDocumento', $data['tipoDocumento']);
            $this->db->bind(':nombreCompleto', $data['nombreCompleto']);
            $this->db->bind(':apellidoCompleto', $data['apellidoCompleto']);
            $this->db->bind(':correo', $data['correo']);
            $this->db->bind(':telefono', $data['telefono']);
            $this->db->bind(':direccion', $data['direccion']);
            $this->db->bind(':ciudadResidencia', $data['ciudad']);
            $this->db->bind(':fechaNacimiento', $data['fechaNacimiento']);
            $this->db->bind(':genero', $data['genero']);

            if($this->db->execute()){
                return $this->db->lastInsertId();
            }
            else{
                return null;
            }
        }

        public function asignarEspecialidad($perfilPersonaId, $especialidadId){
            $this->db->query("INSERT INTO perfilespecialidad (perfilPersonaId, especialidadId) VALUES (:perfilPersonaId, :especialidadId)");
            $this->db->bind(':perfilPersonaId', $perfilPersonaId);
            $this->db->bind(':especialidadId', $especialidadId);
            
            if($this->db->execute()){
                return true;
            }
            else{
                return false;
            }
        }

        public function asignarHorarioAtencion($perfilPersonaId, $horarioAtencionId){
            $this->db->query("INSERT INTO perfilhorarioatencion (perfilPersonaId, horarioAtencionId) VALUES (:perfilPersonaId, :horarioAtencionId)");
            $this->db->bind(':perfilPersonaId', $perfilPersonaId);
            $this->db->bind(':horarioAtencionId', $horarioAtencionId);
            
            if($this->db->execute()){
                return true;
            }
            else{
                return false;
            }
        }

        // Obtener Perfil de Usuarios por Rol
        public function obtenerPerfilesUsuarioPorRol($nombreRol){


            $this->db->query('SELECT u.idUsuario, 
                                    u.correo,
                                    p.idPerfilPersona,
                                    p.documento, 
                                    p.tipoDocumento, 
                                    p.NombreCompleto, 
                                    p.apellidoCompleto, 
                                    p.telefono, 
                                    p.direccion, 
                                    c.*, 
                                    p.fechaNacimiento,
                                    p.genero
                                FROM usuario u
                                JOIN perfilpersona p ON p.idPerfilPersona = u.perfilPersonaId
                                JOIN usuariorol ur ON ur.usuarioId = u.idUsuario
                                JOIN ciudad c ON c.idCiudad = p.ciudadResidencia
                                JOIN rol r ON r.idRol = ur.rolId
                                WHERE r.nombreRol = :nombreRol
                                ORDER BY nombreUsuario ASC');
                                
            $this->db->bind(':nombreRol', $nombreRol);
            $rows = $this->db->resultSet();
            return $rows;
        }

        // Actualizar datos del perfil
        public function actualizarPerfilPersona($perfilPersonaId, $data){
            $this->db->query('UPDATE perfilpersona SET
                                documento = :documento, 
                                tipoDocumento = :tipoDocumento, 
                                nombreCompleto = :nombreCompleto, 
                                apellidoCompleto = :apellidoCompleto, 
                                correo = :correo, 
                                telefono = :telefono, 
                                direccion = :direccion, 
                                ciudadResidencia = :ciudadResidencia, 
                                fechaNacimiento = :fechaNacimiento, 
                                genero = :genero 
                                WHERE idPerfilPersona = :perfilPersonaId');
            $this->db->bind(':documento', $data['documento']);
            $this->db->bind(':tipoDocumento', $data['tipoDocumento']);
            $this->db->bind(':nombreCompleto', $data['nombreCompleto']);
            $this->db->bind(':apellidoCompleto', $data['apellidoCompleto']);
            $this->db->bind(':correo', $data['correo']);
            $this->db->bind(':telefono', $data['telefono']);
            $this->db->bind(':direccion', $data['direccion']);
            $this->db->bind(':ciudadResidencia', $data['ciudad']);
            $this->db->bind(':fechaNacimiento', $data['fechaNacimiento']);
            $this->db->bind(':genero', $data['genero']);
            $this->db->bind(':perfilPersonaId', $perfilPersonaId);

            if($this->db->execute()){
                return $this->db->lastInsertId();
            }
            else{
                return null;
            }
        }

        // Eliminar Perfil Persona
        public function eliminarPerfilPersona($perfilPersonaId){
            $this->db->query("DELETE FROM perfilpersona WHERE idPerfilPersona = :perfilPersonaId");
            $this->db->bind(':perfilPersonaId', $perfilPersonaId);
            
            if($this->db->execute()){
                return true;
            }
            else{
                return false;
            }
        }

    }