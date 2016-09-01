<?php 
    if(isset($_GET['url'])){

        Router::init($_GET['url']);

        Router::get('/', 'HomeController');

        Router::get('/destination', 'DestinationController');
        Router::get('/destination/:id', 'DestinationController.edit');
        Router::post('/destination/:id', 'DestinationController.save');
        Router::get('/destination/delete/:id', 'DestinationController.delete');

        Router::get('/user', 'UserController');
        Router::get('/user/logout', 'UserController.logout');

        Router::get('/about', 'AboutController');

        Router::run();
    }
?>