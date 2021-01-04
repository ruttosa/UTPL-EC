<?php
    class Ciudad{
        private $db;
        
        public function __construct(){
            $this->db = new Database();
        }

        public function obtenerCiudades(){
            $this->db->query('SELECT idCiudad, nombreCiudad
                                FROM ciudad
                                ORDER BY nombreCiudad ASC');

            return $this->db->resultSet();
        }



    }