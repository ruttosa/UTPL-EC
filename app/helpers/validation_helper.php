<?php

    // Validar datos formularios de perfil
    function validarFormularioPerfil($perfil, $data){

        $dataValidated = [
            "data" => $data,
            "valid" => false
        ];

        $dataMedicoValid = false;
        $dataBasicaValid = false;
        
        // Validación de campos basicos para todos los perfiles
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
        /* if(empty($data['correo'])){
            $data['correo_error'] = 'Por favor ingrese el correo';
        } */

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

        $dataValidated['data'] = $data;

        if(
            empty($data['nombreCompleto_error']) && empty($data['fechaNacimiento_error']) && empty($data['apellidoCompleto_error']) &&
            empty($data['telefono_error']) && empty($data['correo_error']) && empty($data['direccion_error']) && empty($data['documento_error']) &&
            empty($data['tipoDocumento_error']) && empty($data['ciudad_error'])
        ){
           //$dataValidated['valid'] = true;
           $dataBasicaValid = true;
        }

        // Validación de campos adicionales para el perfil médico
        if($perfil == "MEDICO"){
            // Validar Especialidad obligatorio
            if(empty($data['especialidad'])){
                $data['especialidad_error'] = 'Por favor ingrese al menos una especialidad';
            }

            // Validar Horario de Atencion obligatorio
            if(empty($data['horarioAtencion'])){
                $data['horarioAtencion_error'] = 'Por favor ingrese el horario de atencion';
            }

            $dataValidated['data'] = $data;
            if(empty($data['especialidad_error']) && empty($data['horarioAtencion_error'])){
                $dataMedicoValid = true;
            }
        }
        else{
            $dataMedicoValid = true;
        }        

        if($dataBasicaValid && $dataMedicoValid){
            $dataValidated['valid'] = true;
        }
        

        return $dataValidated;
    }

    // Validar datos formulario de agendamiento de citas
    function validarFormularioAgendamientoCita($data){
        $dataValidated = [
            "data" => $data,
            "valid" => false
        ];

        // Validar Especialidad obligatorio
        if(empty($data['especialidad'])){
            $data['especialidad_error'] = 'Por favor seleccione una especialidad';
        }

        // Validar Fecha Cita Médica obligatorio
        if(empty($data['fechaCitaMedica'])){
            $data['fechaCitaMedica_error'] = 'Por favor seleccione una fecha para la cita médica';
        }

        // Validar Doctor obligatorio
        if(empty($data['doctor'])){
            $data['doctor_error'] = 'Por favor seleccione un doctor';
        }

        // Validar Horario de Atención obligatorio
        if(empty($data['horarioAtencion'])){
            $data['horarioAtencion_error'] = 'El doctor seleccionado no tiene un horario de atención asignado.';
        }

        // Validar Paciente obligatorio
        if(empty($data['paciente'])){
            $data['paciente_error'] = 'Por favor seleccione un paciente';
        }

        // Validar Motivo de la consulta
        if(empty($data['motivoConsulta'])){
            $data['motivoConsulta_error'] = 'Por favor ingrese el motivo de su consulta';
        }

        // Verificar errores
        $dataValidated['data'] = $data;
        if(
            empty($data['especialidad_error']) && empty($data['fechaCitaMedica_error']) && empty($data['doctor_error']) &&
            empty($data['horarioAtencion_error']) && empty($data['paciente_error']) && empty($data['motivoConsulta_error'])
        ){
           $dataValidated['valid'] = true;
        }
        return $dataValidated;
    }

    function validarFormularioRegistroDiagnostico($data){
        $dataValidated = [
            "data" => $data,
            "valid" => false
        ];

        // Validar Resumen Diagnostico obligatorio
        if(empty($data['resumenDiagnostico'])){
            $data['resumenDiagnostico_error'] = 'Por favor complete un resumen del diagnóstico';
        }

        // Validar Detalle Diagnóstico obligatorio
        if(empty($data['detalleDiagnostico'])){
            $data['detalleDiagnostico_error'] = 'Por favor complete el detalle del diagnóstico';
        }

        // Verificar errores
        $dataValidated['data'] = $data;
        if(empty($data['resumenDiagnostico_error']) && empty($data['detalleDiagnostico_error'])){
           $dataValidated['valid'] = true;
        }
        return $dataValidated;
    }