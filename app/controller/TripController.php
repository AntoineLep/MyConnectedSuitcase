<?php
    class TripController extends Controller {

        public function __construct(){
            parent::__construct('administration');
            $this->loadModel('DestinationModel');
            $this->loadModel('TripModel');
        }

        public function index(){
            $trips = $this->TripModel->getAllTrips();
            $destinations = $this->DestinationModel->getAllDestinations();
            $destinationsByTripId = [];

            foreach ($destinations as $destination){
                if(!isset($destinationsByTripId[$destination['id_trip']]))
                    $destinationsByTripId[$destination['id_trip']] = [];
                array_push($destinationsByTripId[$destination['id_trip']], $destination);
            }

            $destinationsImageNumber = $this->DestinationModel->getDestinationIdAndRelatedImageNumber();
            $destImgNumArr = [];

            foreach ($destinationsImageNumber as $destinationImageNumber){
                $destImgNumArr[$destinationImageNumber['id_destination']] = $destinationImageNumber['num_rows'];
            }

            $this->loadView('trip/list', compact('trips', 'destinationsByTripId', 'destImgNumArr'));
            $this->render();
        }

        public function edit($id){

        }
    }
?>