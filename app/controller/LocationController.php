<?php
    class LocationController extends Controller {

        public function __construct(){
            parent::__construct('location');
            $this->loadModel('DestinationModel');
        }

        public function index(){
            $destinations = $this->DestinationModel->getAllDestinations();
            $this->loadView('location/list', compact('destinations'));
            $this->render();
        }

        public function edit($id){
            $destination = null;
            if($id > 0)
                $destination = $this->DestinationModel->getDestinationByID($id);
            $this->loadView('location/edit', compact('destination'));
            $this->render();
        }

        public function save($id){

        }

        public function delete($id){
            $this->DestinationModel->deleteDestinationByID($id);
            return $this->index();
        }
    }
?>