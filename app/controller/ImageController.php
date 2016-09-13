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

            $imageFolder = '';

            $this->loadModel('UserModel');
            $user = $this->UserModel->getUserInfo();
            if($user)
                $imageFolder = USER_IMAGES_FOLDER_NAME . '/' . $user['image_folder'];

            $this->loadView('image/edit', compact('image', 'success', 'errors', 'imageFolder'));
            $this->render();
        }

        public function save($id){
            $image = ['id' => $id];

            $formResult = ['id' => $id,
                           'caption' => (isset($_POST['db-image-caption']) && !empty(trim($_POST['db-image-caption']))) ? $_POST['db-image-caption'] : '',
                           'description' => (isset($_POST['db-image-description']) && !empty(trim($_POST['db-image-description']))) ? $_POST['db-image-description'] : ''];
            $formResult['id_destination'] = (isset($_POST['id-destination']) && !empty(trim($_POST['id-destination']))) ? $_POST['id-destination'] : '';
            $formResult['filename'] = (isset($_POST['db-image-filename']) && !empty(trim($_POST['db-image-filename']))) ? $_POST['db-image-filename'] : '';

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
            $image['filename'] = '';
            $image['filedir'] = '';
            if(isset($_FILES['db-image-file'])){
                if($_FILES['db-image-file']['error'] == 0){
                    if($_FILES['db-image-file']['size'] != 0){
                        $imageExtensions = ['jpg', 'jpeg', 'png'];
                        $explodedFilename = explode('.', $_FILES['db-image-file']['name']);
                        $extension = strtolower(end($explodedFilename));

                        if(in_array($extension, $imageExtensions)){
                                $image['filename'] =  hash('sha256', session_id() . microtime()) . '.' . $extension;
                                $this->loadModel('UserModel');
                                $user = $this->UserModel->getUserInfo();
                                $image['filedir'] = ASSETS_FOLDER . DS . 'img' . DS . USER_IMAGES_FOLDER_NAME . DS . $user['image_folder'] . DS . '_temp' . DS;
                                if(!move_uploaded_file($_FILES['db-image-file']['tmp_name'], $image['filedir'] . $image['filename']))
                                    $errors['file'] = 'An internal error occured. Cannot transfer the file for the moment';
                        }
                        else
                            $errors['file'] = 'Supported file extensions are: .jpg, .jpeg or .png';
                    }
                    else
                        $errors['file'] = 'No image file selected';
                }
                else {
                    switch ($_FILES['db-image-file']['error']) {
                        case UPLOAD_ERR_INI_SIZE:
                            $errors['file'] = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
                            break;
                        case UPLOAD_ERR_PARTIAL:
                            $errors['file'] = "The uploaded file was only partially uploaded";
                            break;
                        case UPLOAD_ERR_NO_TMP_DIR:
                            $errors['file'] = "Missing a temporary folder";
                            break;
                        case UPLOAD_ERR_CANT_WRITE:
                            $errors['file'] = "Failed to write file to disk";
                            break;
                        case UPLOAD_ERR_EXTENSION:
                            $errors['file'] = "File upload stopped by extension";
                            break;

                        default:
                            break;
                    }
                }
            }
            elseif($formResult['filename'] == '')
                $errors['file'] = 'No image file selected';

            //Destination id
            if($formResult['id_destination'] != '')
                $image['id_destination'] = $formResult['id_destination'];
            else
                $image['id_destination'] = -1;

            if(count($errors) == 0){
                $retId = $this->ImageModel->addOrUpdate($image);
                $destinationId = $this->ImageModel->getImageById($retId)['id_destination'];
                $successMessage = ($id == $retId) ? 'Your changes have been saved !' : 'New image created !';
                $successMessage .= ' <a href=' . url('destination/' . $destinationId . '#img' . $retId) . '>Back to the destination</a>';
                return $this->edit($retId, $successMessage, $errors);
            }
            else{
                return $this->edit($id, '', $errors, $formResult);
            }
        }

        public function delete($id){
            $destinationId = $this->ImageModel->getImageById($id)['id_destination'];
            $this->ImageModel->deleteImageById($id);
            header('Location: ' . cleanUrl('destination/' . $destinationId . '#destination-picture'));
        }
    }
?>