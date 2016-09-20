<?php
    class DestinationModel extends Model {


        private $idUser = '';

        public function __construct(){
            parent::__construct();
            if(isset($_SESSION['idUser']))
                $this->idUser = $_SESSION['idUser'];
        }

        public function isUserValid($idDestination = -1){
            if($idDestination == -1){
                $sth = $this->db->prepare('SELECT count(id) as num_rows FROM user WHERE id = :idUser');
                $sth->execute([':idUser' => $this->idUser]);
                return $sth->fetchAll()[0]['num_rows'] == 1;
            }
            else {
                $sth = $this->db->prepare('SELECT count(destination.id) as num_rows 
                                            FROM destination 
                                            JOIN trip ON destination.id_trip = trip.id 
                                            WHERE destination.id = :id AND id_user = :idUser');
                $sth->execute([':id' => $idDestination, ':idUser' => $this->idUser]);
                return $sth->fetchAll()[0]['num_rows'] == 1;
            }
        }

        public function getAllUserDestinations(){
            if(!$this->isUserValid())
                return [];
            $sth = $this->db->prepare('SELECT * FROM destination WHERE id_trip IN (SELECT id FROM trip where id_user = :idUser)');
            $sth->execute([':idUser' => $this->idUser]);
            return $sth->fetchAll();
        }

        public function getDestinationIdAndRelatedImageNumber(){
            return $this->db->query('SELECT id_destination, count(*) AS num_rows 
                                        FROM image 
                                        WHERE id_destination IN 
                                            (SELECT id FROM destination) 
                                        GROUP BY id_destination'
                                    )->fetchAll();
        }

        public function getDestinationById($id){
            if(!$this->isUserValid($id))
                return null;
            $sth = $this->db->prepare('SELECT * FROM destination WHERE id = :id');
            $sth->execute([':id' => $id]);
            $result = $sth->fetchAll();
            if(isset($result[0])) 
                return $result[0];
            return null;
        }

        public function deleteDestinationById($id){
            if(!$this->isUserValid($id))
                return false;

            $imageModel = new ImageModel();
            $imagesInDestination = $imageModel->getImagesWithDestinationId($id);
            
            foreach ($imagesInDestination as $image)
                $imageModel->deleteImageById($image['id']);

            $sth = $this->db->prepare('DELETE FROM destination WHERE id = :id');
            $sth->execute([':id' => $id]);
            return true;
        }

        public function addOrUpdate($destination){
            if(!$this->isUserValid($destination['id']))
                return false;

            if($destination['id'] == -1){
                $tripModel = new TripModel();
                if(count($tripModel->getTripById($destination['id_trip'])) == 0)
                    return false;

                unset($destination['id']);
                $sth = $this->db->prepare('INSERT INTO destination (name, lat, lng, description, startDate, endDate, id_transportation_type, id_trip) 
                                            VALUES(:name, :lat, :lng, :description, :startDate, :endDate, :transportationType, :id_trip)');
                $sth->execute($destination);
                return $this->db->lastInsertID();
            }
            else {
                unset($destination['id_trip']);
                $sth = $this->db->prepare('UPDATE destination 
                                            SET name = :name, lat = :lat, lng = :lng, description = :description, startDate = :startDate, endDate = :endDate, id_transportation_type = :transportationType
                                            WHERE id = :id');
                $sth->execute($destination);
                return $destination['id'];
            }
        }
    }
?>