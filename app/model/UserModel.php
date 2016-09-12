<?php
    class UserModel extends Model {
        private $idUser = '';

        public function __construct(){
            parent::__construct();
            if(isset($_SESSION['idUser']))
                $this->idUser = $_SESSION['idUser'];
        }

        public function getUserInfo(){
            $sth = $this->db->prepare('SELECT * FROM user WHERE id = :idUser');
            $sth->execute([':idUser' => $this->idUser]);
            return $sth->fetchAll()[0];
        }
    }
?>