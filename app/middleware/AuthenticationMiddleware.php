<?php 
    class AuthenticationMiddleware implements IMiddleware {
        public function handle($args = null){
            return userIsConnected();
        }

        public function onError($args = null){
            header('location:' . cleanUrl('user/login'));
        }

        public function onSuccess($args = null){

        }
    }
?>