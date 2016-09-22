<?php 
    interface IMiddleware {
        public function handle($args = null);
        public function onError($args = null);
        public function onSuccess($args = null);
    }
?>