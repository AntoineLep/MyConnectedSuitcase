<?php 
    if(isset($_GET['url'])){

        Router::init($_GET['url']);

        Router::get('/', 'HomeController');
        Router::get('/gcu', 'HomeController.gcu');        

        Router::get('/trip', 'TripController');
        Router::get('/trip/:id', 'TripController.edit')->with(':id', '[0-9]+');
        Router::post('/trip/:id', 'TripController.save')->with(':id', '[0-9]+');
        Router::get('/trip/delete/:id', 'TripController.delete')->with(':id', '[0-9]+');

        Router::get('/destination/-1/:idTrip', 'DestinationController.create')->with(':idTrip', '[0-9]+');
        Router::get('/destination/:id', 'DestinationController.edit')->with(':id', '[0-9]+');
        Router::post('/destination/:id', 'DestinationController.save')->with(':id', '[0-9]+');
        Router::get('/destination/delete/:id', 'DestinationController.delete')->with(':id', '[0-9]+');

        Router::get('/image/-1/:idDestination', 'ImageController.create')->with(':idDestination', '[0-9]+');
        Router::get('/image/:id', 'ImageController.edit')->with(':id', '[0-9]+');
        Router::post('/image/:id', 'ImageController.save')->with(':id', '[0-9]+');
        Router::get('/image/delete/:id', 'ImageController.delete')->with(':id', '[0-9]+');

        Router::get('/user', 'UserController');
        Router::get('/user/logout', 'UserController.logout');
        Router::get('/user/login', 'UserController.login');
        Router::post('/user/login', 'UserController.doLogin');
        Router::get('/user/signup', 'UserController.signup');
        Router::post('/user/signup', 'UserController.doSignup');
        Router::get('/user/resendemail', 'UserController.resendemail');
        Router::get('/user/resetPassword/:id/:activationKey', 'UserController.resetPassword');
        Router::get('/user/resetPasswordEmail/:username', 'UserController.resetPasswordEmail');

        Router::get('/about', 'AboutController');

        Router::run();
    }
?>