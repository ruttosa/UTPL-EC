<?php
    /*
     * Base class Controller
     * Loads the models and views
     */
    
    class Controller{
        
        // Load model
        public function model ($model){
            
            // Require model file
            require_once '../app/models/' . $model . '.php';

            // Instantiate model
            return new $model;
        }

        // Load view
        public function view($view, $data = []){

            // Check for de the view file
            if(file_exists('../app/views/' . $view . '.php')){
                $_SESSION['activePage'] = $view;
                require_once('../app/views/' . $view . '.php');
            }
            else{
                // La vista no existe
                die('La vista no existe'); // --> Stop de Application but I could handle as I want
            }
        }
    }