<?php
    class HomeController extends Controller {

        public function index(){
            $this->loadModel('UserModel');
            $this->loadModel('TripModel');
            $this->loadModel('DestinationModel');
            $this->loadModel('ImageModel');

            $homeVars['nbUser'] = $this->UserModel->getNumberOfUsers();
            $homeVars['nbTrip'] = $this->TripModel->getNumberOfTrips();
            $homeVars['nbDestination'] = $this->DestinationModel->getNumberOfDestinations();
            $homeVars['nbImage'] = $this->ImageModel->getNumberOfImages();

            $this->loadView('home/homecontent', compact('homeVars'));
            $this->render();
        }

        public function gcu(){
            $this->loadView('termsconditions/termsconditionscontent');
            $this->render();
        }

        public function notfound(){
            $this->loadView('errors/404');
            $this->render();
        }
    }

?>