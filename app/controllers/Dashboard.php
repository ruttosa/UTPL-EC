<?php
    class Dashboard extends Controller{
        public function __construct(){
            /* $this->postModel = $this->model('Post'); */
        }

        public function index(){
            /* $posts = $this->postModel->getPosts(); */

            if(!isLoggedIn()){
                redirect('usuarios/login');
            }
            
            $data = [
                'dashboard_type' => 'ADMINISTRADOR'
            ];
             
            $this->view('dashboards/index', $data);
        }
    }