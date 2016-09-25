<?php
    class TransportationTypeModel extends Model {

    	public function getAllTransportationType(){
    		return $this->db->query('SELECT * FROM mcs_transportation_type')->fetchAll();
    	}

    	public function transportationTypeIdExists($id){
    		$sth = $this->db->prepare('SELECT count(id) as nb_match FROM mcs_transportation_type WHERE id = :id');
            $sth->execute([':id' => $id]);
            return $sth->fetchAll()[0]['nb_match'] != 0;
    	}
    }
?>