<?php
    class HomeController extends Controller {

        public function index(){
            $this->loadView('home/homecontent');
            $this->render();
        }

        public function gcu(){
            $this->loadView('termsconditions/termsconditionscontent');
            $this->render();
        }
    }

?>