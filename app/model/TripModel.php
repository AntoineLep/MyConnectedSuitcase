<?php
	class TripModel extends Model {

		public function getAllTrips(){
			 return $this->db->query('SELECT * FROM trip')->fetchAll();
		}
	}
?>