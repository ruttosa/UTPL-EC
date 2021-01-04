<?php
    class Pages extends Controller{
        public function __construct(){
            /* $this->postModel = $this->model('Post'); */
        }

        public function index(){
            /* $posts = $this->postModel->getPosts(); */

            if(isLoggedIn()){
                redirect('dashboard');
            }
            
            $data = [
                'titulo' => 'Bienvenidos!',
                'subtitulo' => 'a la plataforma web del Hospital Nuestra Familia'
                /* 'posts' => $posts */
            ];
             
            $this->view('pages/index', $data);
        }

        public function about(){
            $data = [
                'titulo' => 'Acerca de',
                'subtitulo' => 'Plataforma web para la gestión de pacientes, médicos y citas médicas online',
                'descripcion' => 'Desarrollado por Ernesto Meneses'
            ];
            $this->view('pages/about', $data);
        }
    }