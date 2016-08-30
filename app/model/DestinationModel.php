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
    }
?>