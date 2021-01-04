<?php

    // Redireccionamiento de páginas
    function redirect($page){
        header('location: ' . URLROOT . '/' . $page);
    }

    function startsWith ($string, $startString) 
    { 
        $len = strlen($startString); 
        return (substr($string, 0, $len) === $startString); 
    } 