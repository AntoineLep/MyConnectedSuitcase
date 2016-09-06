<?php
    class DestinationModel extends Model {

        public function getAllDestinations(){
            return $this->db->query('SELECT * FROM destination')->fetchAll();
        }

        public function getDestinationIdAndRelatedImageNumber(){
            return $this->db->query('SELECT id_destination, count(*) AS num_rows FROM image WHERE id_destination IN (SELECT id FROM destination) GROUP BY id_destination')->fetchAll();
        }

        public function getDestinationByID($id){
            $sth = $this->db->prepare('SELECT * FROM destination WHERE id = :id');
            $sth->execute([':id' => $id]);
            return $sth->fetchAll();
        }

        public function deleteDestinationByID($id){
            $sth = $this->db->prepare('DELETE FROM destination WHERE id = :id');
            $sth->execute([':id' => $id]);
        }

        public function addOrUpdate($destination){
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