<?php
    class Model {

        /**
        * (PDO) Database PDO singleton instance
        */
        protected $db = null;

        public function __construct(){
            if(!$this->db)
                $this->db = DB::getInstance();
        }
    }
?>