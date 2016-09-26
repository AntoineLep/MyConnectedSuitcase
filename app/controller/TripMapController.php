<?php
    class TripMapController extends Controller {

        public function __construct(){
            parent::__construct('map');
        }

        public function index(){
            $this->loadView('tripmap/map');
            $this->render();
        }
    }

?>