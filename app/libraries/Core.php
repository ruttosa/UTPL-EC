<?php
    /*
     * App Core Class
     * Creates URL & loads core controller
     * URL FORMAT - /controller/method/params
     */
    class Core{
        protected $currentController = 'Pages';
        protected $currentMethod = 'index';
        protected $params = [];

        public function __construct(){            
            try {
                //print_r($this->getUrl());

                $url = $this->getUrl();

                // Look in controllers for first value
                if(isset($url[0])){
                    if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')){
                        // If exists, set as controller
                        $this->currentController = ucwords($url[0]);
                        // Unset 0 Index;
                        unset($url[0]);
                    }
                }

                // Require the controller
                require_once '../app/controllers/' . $this->currentController . '.php';

                // Instantiate controller class
                $this->currentController = new $this->currentController;

                // Check for second part of url
                if(isset($url[1])){
                    // Check if method exists in controller
                    if(method_exists($this->currentController, $url[1])){
                        $this->currentMethod = $url[1];
                        // Unset 1 Index
                        unset($url[1]);
                    }
                }
                
                // Get params
                $this->params = $url ? array_values($url) : [];

                if(method_exists($this->currentController, $this->currentMethod)){
                    //Call callback with array of params
                    call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
                }
                else{
                    throw new Exception("No existe el método en el controlador.", 1414);                
                }
            } catch (\Throwable $th) {

                if($th->getCode() == "23000"){
                    flash("main_error", 'La operación no pudo ser completada debido a problemas de integridad de datos.', 'alert alert-warning');
                }
                if($th->getCode() == "1414"){
                    flash("main_error", $th->getMessage(), 'alert alert-warning');
                }
                
                // En caso de error en la carga del controlador, redirige a la página desde donde se originó el REQUEST
                redirect(substr(str_replace(URLROOT, "",$_SERVER['HTTP_REFERER']),1,strlen(str_replace(URLROOT, "",$_SERVER['HTTP_REFERER']))));
            }
        }


        public function getUrl(){
            //echo $_GET['url'];
            if(isset($_GET['url'])){
                $url = rtrim($_GET['url'], '/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);
                $_SESSION['currentUrl'] = $url;
                return $url;
            }
        }
    }