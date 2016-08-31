<?php
    class AboutController extends Controller {

        public function __construct(){
            parent::__construct('administration');
        }

        public function index(){
            $this->loadView('about/about');
            $this->render(['pageTitle' => 'About']);
        }
    }

?>