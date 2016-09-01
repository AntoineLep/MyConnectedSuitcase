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

        public function edit($id, $success = '', $errors = [], $destination = null){
            if($id > 0 && $destination == null)
                $destination = $this->DestinationModel->getDestinationByID($id);
            $this->loadView('destination/edit', compact('destination', 'success', 'errors'));
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
                           'endDate' => (isset($_POST['db-location-end-date']) && !empty(trim($_POST['db-location-end-date']))) ? $_POST['db-location-end-date'] : ''];
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
                if(isValidDate($formResult['startDate']))
                    $destination['startDate'] = date_format(DateTime::createFromFormat('m/d/Y', $formResult['startDate']), 'Y-m-d H:i:s');
                else
                    $errors['startDate'] = 'Date format is not valid';
            else 
                $destination['startDate'] = '';

            //End date
            if($formResult['endDate'])
                if(isValidDate($formResult['endDate']))
                    $destination['endDate'] = date_format(DateTime::createFromFormat('m/d/Y', $formResult['endDate']), 'Y-m-d H:i:s');
                else
                    $errors['endDate'] = 'Date format is not valid';
            else 
                $destination['endDate'] = '';



            if(count($errors) == 0){
                $retId = $this->DestinationModel->addOrUpdate($destination);
                $successMessage = ($id == $retId) ? 'Your changes have been saved !' : 'New destination created !';
                return $this->edit($retId, $successMessage, $errors);
            }
            else{
                return $this->edit($id, '', $errors, $formResult);
            }
        }

        public function delete($id){
            $this->DestinationModel->deleteDestinationByID($id);
            return $this->index();
        }
    }
?>