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
            $result = $sth->fetchAll();

            if(isset($result[0]))
                return $result[0];

            return null;
        }

        public function getUserById($id){
            $sth = $this->db->prepare('SELECT * FROM user WHERE id = :id');
            $sth->execute([':id' => $id]);
            $result = $sth->fetchAll();

            if(isset($result[0]))
                return $result[0];

            return null;
        }

        public function activateUserWithId($id){
            $sth = $this->db->prepare('UPDATE user 
                                        SET status = 1
                                        WHERE id = :id');
            $sth->execute([':id' => $id]);
            return $id;
        }

        public function getUserWithEmail($email){
            $sth = $this->db->prepare('SELECT * FROM user WHERE email = :email');
            $sth->execute([':email' => $email]);
            $result = $sth->fetchAll();

            if(isset($result[0]))
                return $result[0];

            return null;
        }

        public function getUserWithUsername($username){
            $sth = $this->db->prepare('SELECT * FROM user WHERE username = :username');
            $sth->execute([':username' => $username]);
            $result = $sth->fetchAll();

            if(isset($result[0]))
                return $result[0];

            return null;
        }

        public function addOrUpdate($user){
            if($user['id'] == -1){

                unset($user['id']);
                unset($user['terms']);

                $repoName = md5(uniqid() . microtime());
                while(file_exists(ASSETS_FOLDER . DS . 'img' . DS . USER_IMAGES_FOLDER_NAME . DS . $repoName))
                    $repoName = md5(uniqid() . microtime());

                $user['image_folder'] = $repoName;
                $user['registred_date'] = date('Y-m-d', time());
                $user['status'] = 0; //not activated

                //create user repos
                mkdir(ASSETS_FOLDER . DS . 'img' . DS . USER_IMAGES_FOLDER_NAME . DS . $repoName);
                mkdir(ASSETS_FOLDER . DS . 'img' . DS . USER_IMAGES_FOLDER_NAME . DS . $repoName . DS . '_temp');

                if(!is_dir(ASSETS_FOLDER . DS . 'img' . DS . USER_IMAGES_FOLDER_NAME . DS . $repoName . DS . '_temp'))
                    return -1;

                unset($user['password2']);
                $user['password1'] = password_hash($user['password1'], PASSWORD_DEFAULT);
                $user['activation_key'] = md5(uniqid() . microtime());

                $sth = $this->db->prepare('INSERT INTO user (username, password, email, registred_date, activation_key, image_folder, status) 
                                            VALUES(:username, :password1, :email, :registred_date, :activation_key, :image_folder, :status)');
                $sth->execute($user);
                $lastID = $this->db->lastInsertID();
                $user['id'] = $lastID;

                sendValidationEmail($user);

                return $lastID;
            }
            else {
                //TODO : user update info
            }
        }
    }
?>