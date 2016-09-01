<?php
    class DestinationModel extends Model {

        public function getAllDestinations(){
            return $this->db->query('SELECT * FROM destination')->fetchAll();
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
                $sth = $this->db->prepare('INSERT INTO destination (name, lat, lng, description, startDate, endDate) VALUES(:name, :lat, :lng, :description, :startDate, :endDate)');
                $sth->execute($destination);
                return $this->db->lastInsertID();
            }
            else {
                $sth = $this->db->prepare('UPDATE destination SET name = :name, lat = :lat, lng = :lng, description = :description, startDate = :startDate, endDate = :endDate WHERE id = :id');
                $sth->execute($destination);
                return $destination['id'];
            }
        }
    }
?>