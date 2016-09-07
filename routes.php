<?php 
    if(isset($_GET['url'])){

        Router::init($_GET['url']);

        Router::get('/', 'HomeController');

        Router::get('/trip', 'TripController');
        Router::get('/trip/:id', 'TripController.edit')->with(':id', '[0-9]+');
        Router::post('/trip/:id', 'TripController.save')->with(':id', '[0-9]+');
        Router::get('/trip/delete/:id', 'TripController.delete')->with(':id', '[0-9]+');

        Router::get('/destination/-1/:idTrip', 'DestinationController.create')->with(':idTrip', '[0-9]+');
        Router::get('/destination/:id', 'DestinationController.edit')->with(':id', '[0-9]+');
        Router::post('/destination/:id', 'DestinationController.save')->with(':id', '[0-9]+');
        Router::get('/destination/delete/:id', 'DestinationController.delete')->with(':id', '[0-9]+');

        Router::get('/user', 'UserController');
        Router::get('/user/logout', 'UserController.logout');

        Router::get('/about', 'AboutController');

        Router::run();
    }
?>