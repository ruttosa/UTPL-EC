<?php
    class RecetaMedica{

        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        public function obtenerRecetas(){
            $this->db->query('SELECT * FROM recetamedica');

            return $this->db->resultSet();
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

    }