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

    }