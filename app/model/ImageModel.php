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
            return $sth->fetchAll()[0];
       }

        public function addOrUpdate($image){
            //todo
            return 1;
        }


        public function deleteDestinationById($id){
            if(!$this->isUserValid($id))
                return false;
            $sth = $this->db->prepare('DELETE FROM image WHERE id = :id');
            $sth->execute([':id' => $id]);
            return true;
        }

    }
?>