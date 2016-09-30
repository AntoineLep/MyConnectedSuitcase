<?php
    class HelpController extends Controller {

        public function __construct(){
            parent::__construct('administration');
        }

        public function index(){
            $this->loadView('help/help');
            $this->render();
        }
    }

?>