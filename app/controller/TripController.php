<?php
    class TripController extends Controller {

        public function __construct(){
            parent::__construct('administration');
            $this->loadModel('TripModel');
        }

        public function index(){
            $this->loadModel('DestinationModel');
            $this->loadModel('UserModel');

            $trips = $this->TripModel->getAllTrips();
            $destinations = $this->DestinationModel->getAllUserDestinations();
            $destinationsByTripId = [];

            foreach ($destinations as $destination){
                if(!isset($destinationsByTripId[$destination['id_trip']]))
                    $destinationsByTripId[$destination['id_trip']] = [];
                array_push($destinationsByTripId[$destination['id_trip']], $destination);
            }

            $user = $this->UserModel->getUserInfo();
            $destinationsImageNumber = $this->DestinationModel->getDestinationIdAndRelatedImageNumber();
            $destImgNumArr = [];

            foreach ($destinationsImageNumber as $destinationImageNumber){
                $destImgNumArr[$destinationImageNumber['id_destination']] = $destinationImageNumber['num_rows'];
            }

            $this->loadView('trip/list', compact('trips', 'destinationsByTripId', 'destImgNumArr', 'user'));
            $this->render();
        }

        public function edit($id, $success = '', $errors = [], $trip = null){
            if($id > 0 && $trip == null)
                $trip = $this->TripModel->getTripById($id);
            $this->loadView('trip/edit', compact('trip', 'success', 'errors'));
            $this->render();
        }

        public function save($id){
            $trip = ['id' => $id];

            $formResult = ['id' => $id,
                           'name' => (isset($_POST['db-trip-name']) && !empty(trim($_POST['db-trip-name']))) ? $_POST['db-trip-name'] : '',
                           'description' => (isset($_POST['db-trip-description']) && !empty(trim($_POST['db-trip-description']))) ? $_POST['db-trip-description'] : ''];

            $errors = [];

            //Name
            if($formResult['name'] != '')
                $trip['name'] = $formResult['name'];
            else
                $errors['name'] = 'Trip name required';

            //Description
            if($formResult['description'] != '')
                $trip['description'] = $formResult['description'];
            else 
                $trip['description'] = '';


            if(count($errors) == 0){
                $retId = $this->TripModel->addOrUpdate($trip);
                $successMessage = ($id == $retId) ? 'Your changes have been saved !' : 'New trip created !';
                $successMessage .= ' <a href=' . url('/destination/-1/' . $retId) . '>Create a new trip destination</a> or <a href=' . url('/trip') . '>go back to your trips</a> ';
                return $this->edit($retId, $successMessage, $errors);
            }
            else{
                return $this->edit($id, '', $errors, $formResult);
            }
        }

        public function delete($id){
            $this->TripModel->deleteTripById($id);
            header('Location: ' . cleanUrl('trip'));
        }
    }
?>