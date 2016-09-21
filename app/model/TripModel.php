<?php
    class TripModel extends Model {

        private $idUser = '';

        public function __construct(){
            parent::__construct();
            if(isset($_SESSION['idUser']))
                $this->idUser = $_SESSION['idUser'];
        }

        public function isUserValid($idTrip = -1){
            if($idTrip == -1){
                $sth = $this->db->prepare('SELECT count(id) as num_rows FROM user WHERE id = :idUser');
                $sth->execute([':idUser' => $this->idUser]);
                return $sth->fetchAll()[0]['num_rows'] == 1;
            }
            else {
                $sth = $this->db->prepare('SELECT count(id) as num_rows FROM trip WHERE id = :id AND id_user = :idUser');
                $sth->execute([':id' => $idTrip, ':idUser' => $this->idUser]);
                return $sth->fetchAll()[0]['num_rows'] == 1;
            }
        }

        public function getAllTrips(){
            if(!$this->isUserValid())
                return [];
            $sth = $this->db->prepare('SELECT * FROM trip WHERE id_user = :idUser');
            $sth->execute([':idUser' => $this->idUser]);
            return $sth->fetchAll();
        }

        public function getTripById($id){
            if(!$this->isUserValid($id))
                return null;
            $sth = $this->db->prepare('SELECT * FROM trip WHERE id = :id AND id_user = :idUser');
            $sth->execute([':id' => $id, ':idUser' => $this->idUser]);
            $result = $sth->fetchAll();

            if(isset($result[0]))
                return $result[0];
            return null;
        }

        public function addOrUpdate($trip){
            if(!$this->isUserValid($trip['id']))
                return false;

            if(isset($_SESSION['idUser']))
                    $trip['idUser'] = $_SESSION['idUser'];

            if($trip['id'] == -1){
                unset($trip['id']);
                $sth = $this->db->prepare('INSERT INTO trip (name, description, id_user) 
                                            VALUES(:name, :description, :idUser)');
                $sth->execute($trip);
                return $this->db->lastInsertID();
            }
            else {
                $sth = $this->db->prepare('UPDATE trip 
                                            SET name = :name, description = :description
                                            WHERE id = :id AND id_user = :idUser');
                $sth->execute($trip);
                return $trip['id'];
            }
        }

        public function deleteTripById($id){
            if(!$this->isUserValid($id))
                return false;

            $imageModel = new ImageModel();
            $imagesInTrip = $imageModel->getImagesWithTripId($id);

            foreach ($imagesInTrip as $image)
                $imageModel->deleteImageById($image['id']);

            $sth = $this->db->prepare('DELETE FROM trip WHERE id = :id AND id_user = :idUser');
            $sth->execute([':id' => $id, ':idUser' => $this->idUser]);

            return true;
        }
    }
?>