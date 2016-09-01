<?php
    class DestinationController extends Controller {

        public function __construct(){
            parent::__construct('administration');
            $this->loadModel('DestinationModel');
        }

        public function index(){
            $destinations = $this->DestinationModel->getAllDestinations();
            $this->loadView('destination/list', compact('destinations'));
            $this->render();
        }

        public function edit($id){
            $destination = null;
            if($id > 0)
                $destination = $this->DestinationModel->getDestinationByID($id);
            $this->loadView('destination/edit', compact('destination'));
            $this->render(['enableLocation' => true]);
        }

        public function save($id){
            echo 'save';
        }

        public function delete($id){
            $this->DestinationModel->deleteDestinationByID($id);
            return $this->index();
        }
    }
?>