<?php
    class DestinationModel extends Model {


        private $idUser = '';

        public function __construct(){
            parent::__construct();
            if(isset($_SESSION['idUser']))
                $this->idUser = $_SESSION['idUser'];
        }

        private function isUserValid($idDestination = -1){
            if($idDestination == -1){
                $sth = $this->db->prepare('SELECT count(id) as num_rows FROM user WHERE id = :idUser');
                $sth->execute([':idUser' => $this->idUser]);
                return $sth->fetchAll()[0]['num_rows'] == 1;
            }
            else {
                $sth = $this->db->prepare('SELECT count(destination.id) as num_rows FROM destination JOIN trip ON destination.id_trip = trip.id WHERE destination.id = :id AND id_user = :idUser');
                $sth->execute([':id' => $idDestination, ':idUser' => $this->idUser]);
                return $sth->fetchAll()[0]['num_rows'] == 1;
            }
        }

        public function getAllDestinations(){
            if(!$this->isUserValid())
                return [];
            return $this->db->query('SELECT * FROM destination')->fetchAll();
        }

        public function getDestinationIdAndRelatedImageNumber(){
            return $this->db->query('SELECT id_destination, count(*) AS num_rows FROM image WHERE id_destination IN (SELECT id FROM destination) GROUP BY id_destination')->fetchAll();
        }

        public function getDestinationByID($id){
            if(!$this->isUserValid($id))
                return null;
            $sth = $this->db->prepare('SELECT * FROM destination WHERE id = :id');
            $sth->execute([':id' => $id]);
            return $sth->fetchAll();
        }

        public function deleteDestinationByID($id){
            if(!$this->isUserValid($id))
                return false;
            $sth = $this->db->prepare('DELETE FROM destination WHERE id = :id');
            $sth->execute([':id' => $id]);
            return true;
        }

        public function addOrUpdate($destination){
            if(!$this->isUserValid($destination['id']))
                return false;

            if($destination['id'] == -1){
                unset($destination['id']);
                $sth = $this->db->prepare('INSERT INTO destination (name, lat, lng, description, startDate, endDate, id_transportation_type, id_trip) 
                                            VALUES(:name, :lat, :lng, :description, :startDate, :endDate, :transportationType, :idTrip)');
                $sth->execute($destination);
                return $this->db->lastInsertID();
            }
            else {
                unset($destination['idTrip']);
                $sth = $this->db->prepare('UPDATE destination 
                                            SET name = :name, lat = :lat, lng = :lng, description = :description, startDate = :startDate, endDate = :endDate, id_transportation_type = :transportationType
                                            WHERE id = :id');
                $sth->execute($destination);
                return $destination['id'];
            }
        }
    }
?>