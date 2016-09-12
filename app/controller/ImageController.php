<?php 
    class ImageController extends Controller {

        public function __construct(){
            parent::__construct('administration');
            $this->loadModel('ImageModel');
        }

        public function index(){
            //Nothing to show there
        }

        public function create($idDestination){
            $success = '';
            $errors = [];
            $image = null;
            $this->loadView('image/edit', compact('image', 'success', 'errors', 'idDestination'));
            $this->render();
        }

        public function edit($id, $success = '', $errors = [], $image = null){
            if($id > 0 && $image == null)
                $image = $this->ImageModel->getImageByID($id);

            $this->loadView('image/edit', compact('image', 'success', 'errors'));
            $this->render();
        }

        public function save($id){
            $image = ['id' => $id];

            $formResult = ['id' => $id,
                           'caption' => (isset($_POST['db-image-caption']) && !empty(trim($_POST['db-image-caption']))) ? $_POST['db-image-caption'] : '',
                           'description' => (isset($_POST['db-image-description']) && !empty(trim($_POST['db-image-description']))) ? $_POST['db-image-description'] : '',
                           'file' => (isset($_POST['db-image-file']) && !empty(trim($_POST['db-image-file']))) ? $_POST['db-image-file'] : ''];
            if(isset($_POST['id-destination']))
                $formResult['id_destination'] = !empty(trim($_POST['id-destination'])) ? $_POST['id-destination'] : null;

            $errors = [];

            //caption
            if($formResult['caption'] != '')
                $image['caption'] = $formResult['caption'];
            else
                $errors['caption'] = 'Image caption required';

            //Description
            if($formResult['description'] != '')
                $image['description'] = $formResult['description'];
            else 
                $image['description'] = '';

            //File
            if($formResult['file'] != '')
                $image['file'] = $formResult['file'];
            else 
                $image['file'] = '';

            //Destination id
            if(isset($formResult['idDestination']))
                if($formResult['idDestination'] != null)
                    $image['idDestination'] = $formResult['idDestination'];
                else
                    $image['idDestination'] = -1;
            else
                $image['idDestination'] = -1;

            if(count($errors) == 0){
                $retId = $this->ImageModel->addOrUpdate($image);
                $destinationId = $this->ImageModel->getImageById($retId)['id_destination'];
                $successMessage = ($id == $retId) ? 'Your changes have been saved !' : 'New image created !';
                $successMessage .= ' <a href=' . url('destination/' . $destinationId . '#img' . $retId) . '>Back to the destination</a>';
                return $this->edit($retId, $successMessage, $errors);
            }
            else
                return $this->edit($id, '', $errors, $formResult);
        }

        public function delete($id){
            $destinationId = $this->ImageModel->getImageById($retId)['id_destination'];
            $this->ImageModel->deleteImageById($id);
            header('Location: ' . cleanUrl('destination/' . $destinationId . '#destination-picture'));
        }
    }
?>