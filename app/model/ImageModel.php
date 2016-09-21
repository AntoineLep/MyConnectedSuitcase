<?php
    class ImageModel extends Model {

        private $idUser = '';

        public function __construct(){
            parent::__construct();
            if(isset($_SESSION['idUser']))
                $this->idUser = $_SESSION['idUser'];
        }

        public function isUserValid($idImage = -1){
            if($idImage == -1){
                $sth = $this->db->prepare('SELECT count(id) as num_rows FROM user WHERE id = :idUser');
                $sth->execute([':idUser' => $this->idUser]);
                return $sth->fetchAll()[0]['num_rows'] == 1;
            }
            else {
                $sth = $this->db->prepare('SELECT count(image.id) as num_rows FROM image 
                                            JOIN destination ON image.id_destination = destination.id 
                                            JOIN trip ON destination.id_trip = trip.id 
                                            WHERE image.id = :id AND id_user = :idUser');
                $sth->execute([':id' => $idImage, ':idUser' => $this->idUser]);
                return $sth->fetchAll()[0]['num_rows'] == 1;
            }
        }

        public function getImageByDestinationId($idDestination){
            $destinationModel = new DestinationModel();
            if($destinationModel->isUserValid($idDestination)){
                $sth = $this->db->prepare('SELECT * FROM image WHERE id_destination = :idDestination');
                $sth->execute([':idDestination' => $idDestination]);
                return $sth->fetchAll();
            }

            return [];
        }

       public function getImageById($id){
            if(!$this->isUserValid($id))
                return null;
            $sth = $this->db->prepare('SELECT * FROM image WHERE id = :id');
            $sth->execute([':id' => $id]);
            $result = $sth->fetchAll();

            if(isset($result[0]))
                return $result[0];
            return null;
       }

        public function addOrUpdate($image){
            if(!$this->isUserValid($image['id']))
                return false;
            if($image['id'] == -1){
                $destinationModel = new DestinationModel();
                if(count($destinationModel->getDestinationById($image['id_destination'])) == 0)
                    return false;

                $userModel = new UserModel();
                $user = $userModel->getUserInfo();
                $repDest = ASSETS_FOLDER . DS . 'img' . DS . USER_IMAGES_FOLDER_NAME . DS . $user['image_folder'] . DS;
                $imgSmallDest = 'small_' . $image['filename'];
                $imgBigDest = 'big_' . $image['filename'];
                
                $redimSmall = resizeImg(400, 400, $repDest, $imgSmallDest, $image['filedir'], $image['filename']);
                $redimBig = resizeImg(1200, 1200, $repDest, $imgBigDest, $image['filedir'], $image['filename']);

                if($redimSmall && $redimBig)
                    unlink($image['filedir'] . $image['filename']);

                unset($image['id']);
                unset($image['filedir']);

                $sth = $this->db->prepare('INSERT INTO image (caption, filename, description, id_destination) 
                                            VALUES(:caption, :filename, :description, :id_destination)');
                $sth->execute($image);
                return $this->db->lastInsertID();
            }
            else {
                unset($image['id_destination']);
                if($image['filename'] == ''){
                    unset($image['filename']);
                    unset($image['filedir']);
                    $sth = $this->db->prepare('UPDATE image 
                                                SET caption = :caption, description = :description
                                                WHERE id = :id');
                }
                else {
                    $userModel = new UserModel();
                    $user = $userModel->getUserInfo();
                    $repDest = ASSETS_FOLDER . DS . 'img' . DS . USER_IMAGES_FOLDER_NAME . DS . $user['image_folder'] . DS;
                    $imgSmallDest = 'small_' . $image['filename'];
                    $imgBigDest = 'big_' . $image['filename'];
                    
                    $redimSmall = resizeImg(400, 400, $repDest, $imgSmallDest, $image['filedir'], $image['filename']);
                    $redimBig = resizeImg(1200, 1200, $repDest, $imgBigDest, $image['filedir'], $image['filename']);

                    if($redimSmall && $redimBig)
                        unlink($image['filedir'] . $image['filename']);

                    $img = $this->getImageById($image['id']);
                    var_dump($img);
                    if($img != null){
                        unlink($repDest . 'small_' . $img['filename']);
                        unlink($repDest . 'big_' . $img['filename']);
                    }

                    unset($image['filedir']);
                    $sth = $this->db->prepare('UPDATE image 
                                                SET caption = :caption, description = :description, filename = :filename
                                                WHERE id = :id');
                }

                $sth->execute($image);
                return $image['id'];
            }
        }


        public function deleteImageById($id){
            if(!$this->isUserValid($id))
                return false;

            $img = $this->getImageById($id);
            $sth = $this->db->prepare('DELETE FROM image WHERE id = :id');
            $sth->execute([':id' => $id]);

            if($img != null){
                $userModel = new UserModel();
                $user = $userModel->getUserInfo();
                $repDest = ASSETS_FOLDER . DS . 'img' . DS . USER_IMAGES_FOLDER_NAME . DS . $user['image_folder'] . DS;

                unlink($repDest . 'small_' . $img['filename']);
                unlink($repDest . 'big_' . $img['filename']);
            }

            return true;
        }

        //This function is called without user verification in it. It have to be done in the calling function
        public function getImagesWithTripId($tripId){
            $sth = $this->db->prepare('SELECT image.id FROM image 
                                        JOIN destination ON image.id_destination = destination.id
                                        JOIN trip ON destination.id_trip = trip.id
                                        WHERE trip.id = :tripId');
            $sth->execute([':tripId' => $tripId]);
            $result = $sth->fetchAll();

            if(isset($result[0]))
                return $result;
            return null;
        }

        //This function is called without user verification in it. It have to be done in the calling function
        public function getImagesWithDestinationId($destinationId){
            $sth = $this->db->prepare('SELECT image.id FROM image 
                                        JOIN destination ON image.id_destination = destination.id
                                        WHERE destination.id = :destinationId');
            $sth->execute([':destinationId' => $destinationId]);
            $result = $sth->fetchAll();
            
            if(isset($result[0]))
                return $result;
            return null;
        }

    }
?>