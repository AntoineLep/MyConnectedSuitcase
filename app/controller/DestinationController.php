<?php
    class DestinationController extends Controller {

        public function __construct(){
            parent::__construct('administration');
            $this->loadModel('DestinationModel');
            $this->loadModel('TransportationTypeModel');
            $this->loadModel('ImageModel');
        }

        public function index(){
            //Nothing to show there
        }

        public function create($idTrip){
            $success = '';
            $errors = [];
            $destination = null;
            $transportationTypes = $this->TransportationTypeModel->getAllTransportationType();
            $this->loadView('destination/edit', compact('destination', 'transportationTypes', 'success', 'errors', 'idTrip'));
            $this->render(['enableLocation' => true]);
        }

        public function edit($id, $success = '', $errors = [], $destination = null){
            if($id > 0 && $destination == null)
                $destination = $this->DestinationModel->getDestinationById($id);
            $images = (isset($destination['id'])) ? $this->ImageModel->getImageByDestinationId($destination['id']) : null;
            $imageFolder = '';

            if(count($images) > 0){
                $this->loadModel('UserModel');
                $user = $this->UserModel->getUserInfo();
                if($user)
                    $imageFolder = USER_IMAGES_FOLDER_NAME . '/' . $user['image_folder'];
            }

            $transportationTypes = $this->TransportationTypeModel->getAllTransportationType();
            $this->loadView('destination/edit', compact('destination', 'transportationTypes', 'success', 'errors', 'images', 'imageFolder'));
            $this->render(['enableLocation' => true]);
        }

        public function save($id){
            $destination = ['id' => $id];

            $formResult = ['id' => $id,
                           'name' => (isset($_POST['db-location-name']) && !empty(trim($_POST['db-location-name']))) ? $_POST['db-location-name'] : '',
                           'lat' => (isset($_POST['db-location-lat']) && !empty(trim($_POST['db-location-lat']))) ? $_POST['db-location-lat'] : '',
                           'lng' => (isset($_POST['db-location-lng']) && !empty(trim($_POST['db-location-lng']))) ? $_POST['db-location-lng'] : '',
                           'description' => (isset($_POST['db-location-description']) && !empty(trim($_POST['db-location-description']))) ? $_POST['db-location-description'] : '',
                           'startDate' => (isset($_POST['db-location-start-date']) && !empty(trim($_POST['db-location-start-date']))) ? $_POST['db-location-start-date'] : '',
                           'endDate' => (isset($_POST['db-location-end-date']) && !empty(trim($_POST['db-location-end-date']))) ? $_POST['db-location-end-date'] : '',
                           'transportationType' => (isset($_POST['transportation-type']) && !empty(trim($_POST['transportation-type']))) ? $_POST['transportation-type'] : ''];
            $formResult['id_trip'] = (isset($_POST['id-trip']) &&!empty(trim($_POST['id-trip']))) ? $_POST['id-trip'] : '';

            $errors = [];

            //Name
            if($formResult['name'] != '')
                $destination['name'] = $formResult['name'];
            else
                $errors['name'] = 'Destination name required';

            //Latitude
            if($formResult['lat'] != '')
                $destination['lat'] = $formResult['lat'];
            else
                $errors['lat'] = 'Latitude not known';

            //Longitude
            if($formResult['lng'] != '')
                $destination['lng'] = $formResult['lng'];
            else
                $errors['lng'] = 'Longitude not known';

            //Description
            if($formResult['description'] != '')
                $destination['description'] = $formResult['description'];
            else 
                $destination['description'] = '';

            //Start date
            if($formResult['startDate'] != '')
                if(isValidDateString($formResult['startDate']))
                    $destination['startDate'] = date_format(DateTime::createFromFormat('m/d/Y', $formResult['startDate']), 'Y-m-d H:i:s');
                else
                    $errors['startDate'] = 'Date format is not valid';
            else 
                $destination['startDate'] = null;

            //End date
            if($formResult['endDate'] != '')
                if(isValidDateString($formResult['endDate']))
                    $destination['endDate'] = date_format(DateTime::createFromFormat('m/d/Y', $formResult['endDate']), 'Y-m-d H:i:s');
                else
                    $errors['endDate'] = 'Date format is not valid';
            else 
                $destination['endDate'] = null;

            //Transportation type
            if($formResult['transportationType'] != '')
                if($this->TransportationTypeModel->transportationTypeIdExists($formResult['transportationType']))
                    $destination['transportationType'] = $formResult['transportationType'];
                else
                {
                    $destination['transportationType'] = 1;    
                    $errors['transportationType'] = 'Transportation type is not valid';
                }
            else 
                $destination['transportationType'] = 1;

            //Trip id
            if($formResult['id_trip'] != '')
                $destination['id_trip'] = $formResult['id_trip'];
            else
                $destination['id_trip'] = -1;

            if(count($errors) == 0){
                $retId = $this->DestinationModel->addOrUpdate($destination);
                $successMessage = ($id == $retId) ? 'Your changes have been saved !' : 'New destination created !';
                $successMessage .= ' <a href=' . url('trip') . '>Back to my trips</a>';
                return $this->edit($retId, $successMessage, $errors);
            }
            else
                return $this->edit($id, '', $errors, $formResult);
        }

        public function delete($id){
            $this->DestinationModel->deleteDestinationById($id);
            header('Location: ' . cleanUrl('trip'));
        }
    }
?>