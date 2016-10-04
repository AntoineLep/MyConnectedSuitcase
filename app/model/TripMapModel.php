<?php
    class TripMapModel extends Model {

        public function __construct(){
            parent::__construct();
        }

        public function getUserByUsername($username){
            $sth = $this->db->prepare('SELECT * FROM mcs_user WHERE username = :username');
            $sth->execute([':username' => $username]);
            $result = $sth->fetchAll();

            if(isset($result[0]))
                return $result[0];

            return null;
        }

        public function getTripById($id){
            $sth = $this->db->prepare('SELECT * FROM mcs_trip WHERE id = :id');
            $sth->execute([':id' => $id]);
            $result = $sth->fetchAll();

            if(isset($result[0]))
                return $result[0];
            return null;
        }

        public function getDestinationsWithTripIdAndUsername($username, $tripId){
            $sth = $this->db->prepare('SELECT mcs_destination.* FROM mcs_destination 
                                        JOIN mcs_trip ON mcs_destination.id_trip = mcs_trip.id
                                        JOIN mcs_user ON mcs_trip.id_user = mcs_user.id 
                                        WHERE id_trip = :tripId AND username = :username');
            $sth->execute(['username' => $username, ':tripId' => $tripId]);
            $result = $sth->fetchAll();

            if(isset($result[0]))
                return $result;
            return null;      
        }

        public function getAllTransportationTypes(){
            $sth = $this->db->prepare('SELECT * FROM mcs_transportation_type');
            $sth->execute();
            $result = $sth->fetchAll();

            if(isset($result[0]))
                return $result;
            return null;
        }

        public function getImagesWithDestinationId($destinationId){
            $sth = $this->db->prepare('SELECT * FROM mcs_image WHERE id_destination = :destinationId');
            $sth->execute([':destinationId' => $destinationId]);
            $result = $sth->fetchAll();

            if(isset($result[0]))
                return $result;
            return null;
        }
    }
?>