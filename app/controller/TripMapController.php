<?php
    class TripMapController extends Controller {

        public function __construct(){
            parent::__construct('map');
            $this->loadModel('TripMapModel');
        }

        public function index(){
        }

        public function showTripMap($username, $tripId){
            $dbUser = $this->TripMapModel->getUserByUsername($username);
            $dbTrip = $this->TripMapModel->getTripById($tripId);

            if($dbUser == null || $dbTrip == null)
                header('location:' . cleanUrl(('/404')));

            $mapVars['user'] = $dbUser;
            $mapVars['trip'] = $dbTrip;

            $this->loadView('tripmap/map', compact('mapVars'));
            $this->render();
        }

        public function getDestinations($username, $idTrip){
            $dbUser = $this->TripMapModel->getUserByUsername($username);
            $transportationTypes = $this->TripMapModel->getAllTransportationTypes();
            $simplifiedTransportationType = [];

            foreach ($transportationTypes as $transportationType) {
                $simplifiedTransportationType[$transportationType['id']]= [
                        'iconx32Folder' => str_replace('"', '', img_path('icons/x32')),
                        'folder' => str_replace('"', '', img_path($transportationType['img_folder'])), 
                        'prefix' => $transportationType['img_prefix'],
                        'extension' => $transportationType['img_extension'],
                        'ds' => DS
                        ];
            }

            $imageFolder = USER_IMAGES_FOLDER_NAME . '/' . $dbUser['image_folder'];

            $destinations = $this->TripMapModel->getDestinationsWithTripIdAndUsername($username, $idTrip);
            $retVar = [];

            foreach ($destinations as $destination) {

                $images = $this->TripMapModel->getImagesWithDestinationId($destination['id']);
                $transportationTypeDetail = $simplifiedTransportationType[$destination['id_transportation_type']];
                $infoWindow = $this->loadView('tripmap/infowindow', compact('destination', 'images', 'imageFolder', 'transportationTypeDetail'), true); //return it as html

                $retDest = ['name' => $destination['name'],
                            'description' => $destination['description'],
                            'startDate' => $destination['startDate'],
                            'endDate' => $destination['endDate'],
                            'transportationType' => $transportationTypeDetail,
                            'lat' => floatval($destination['lat']),
                            'lng' => floatval($destination['lng']),
                            'infoWindow' => $infoWindow
                        ];

                array_push($retVar, $retDest);
            }

            echo json_encode($retVar);
        }
    }

?>