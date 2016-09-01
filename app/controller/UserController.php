<?php
    class UserController extends Controller {

        public function __construct(){
            parent::__construct('administration');
        }

        public function index(){
            $this->loadView('user/user');
            $this->render(['pageTitle' => 'User profile']);
        }

        public function logout(){
            $this->loadView('user/user');
            $this->render(['pageTitle' => 'User logout']);
        }
    }

?>