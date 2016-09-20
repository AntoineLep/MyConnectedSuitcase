<?php
    class HomeController extends Controller {

        public function index(){
            $this->loadView('home/homecontent');
            $this->render();
        }
    }

?>