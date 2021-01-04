<?php

    // Validar datos formulario Añadir Médico
    function validarFormularioAgregarMedico($data){

        $dataValidated = [
            "data" => $data,
            "valid" => false
        ];
        
        // Validar Nombre obligatorio
        if(empty($data['nombreCompleto'])){
            $data['nombreCompleto_error'] = 'Por favor ingrese el nombre completo';
        }

        // Validar Fecha de Nacimiento obligatorio
        if(empty($data['fechaNacimiento'])){
            $data['fechaNacimiento_error'] = 'Por favor ingrese la fecha de nacimiento';
        }
        
        // Validar Apellido obligatorio
        if(empty($data['apellidoCompleto'])){
            $data['apellidoCompleto_error'] = 'Por favor ingrese el apellido completo';
        }
        
        // Validar Telefono obligatorio
        if(empty($data['telefono'])){
            $data['telefono_error'] = 'Por favor ingrese el telefono';
        }

        // Validar Correo obligatorio
        if(empty($data['correo'])){
            $data['correo_error'] = 'Por favor ingrese el correo';
        }

        // Validar Direccion obligatorio
        if(empty($data['direccion'])){
            $data['direccion_error'] = 'Por favor ingrese la direccion';
        }

        // Validar Documento obligatorio
        if(empty($data['documento'])){
            $data['documento_error'] = 'Por favor ingrese el documento';
        }
        
        // Validar Tipo Documento obligatorio
        if(empty($data['tipoDocumento'])){
            $data['tipoDocumento_error'] = 'Por favor ingrese el tipo de documento';
        }
        
        // Validar Ciudad obligatorio
        if(empty($data['ciudad'])){
            $data['ciudad_error'] = 'Por favor ingrese la ciudad';
        }

        // Validar Especialidad obligatorio
        if(empty($data['especialidad'])){
            $data['especialidad_error'] = 'Por favor ingrese al menos una especialidad';
        }

        // Validar Horario de Atencion obligatorio
        if(empty($data['horarioAtencion'])){
            $data['horarioAtencion_error'] = 'Por favor ingrese el horario de atencion';
        }

        $dataValidated['data'] = $data;

        if(
            empty($data['nombreCompleto_error']) &&empty($data['fechaNacimiento_error']) &&empty($data['apellidoCompleto_error']) &&
            empty($data['telefono_error']) && empty($data['correo_error']) && empty($data['direccion_error']) && empty($data['documento_error']) &&
            empty($data['tipoDocumento_error']) && empty($data['ciudad_error']) && empty($data['especialidad_error']) && empty($data['horarioAtencion_error'])
        ){
           $dataValidated['valid'] = true;
        }

        return $dataValidated;
    }