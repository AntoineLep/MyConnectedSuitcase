<?php 
    if(isset($_GET['url'])){

        Router::init($_GET['url']);

        Router::get('/', 'HomeController');
        Router::get('/gcu', 'HomeController.gcu');        

        Router::get('/trip', 'TripController')->middleware('Authentication');
        Router::get('/trip/:id', 'TripController.edit')->with(':id', '[0-9]+')->middleware('Authentication');
        Router::post('/trip/:id', 'TripController.save')->with(':id', '[0-9]+')->middleware('Authentication');
        Router::get('/trip/delete/:id', 'TripController.delete')->with(':id', '[0-9]+')->middleware('Authentication');

        Router::get('/destination/-1/:idTrip', 'DestinationController.create')->with(':idTrip', '[0-9]+')->middleware('Authentication');
        Router::get('/destination/:id', 'DestinationController.edit')->with(':id', '[0-9]+')->middleware('Authentication');
        Router::post('/destination/:id', 'DestinationController.save')->with(':id', '[0-9]+')->middleware('Authentication');
        Router::get('/destination/delete/:id', 'DestinationController.delete')->with(':id', '[0-9]+')->middleware('Authentication');

        Router::get('/image/-1/:idDestination', 'ImageController.create')->with(':idDestination', '[0-9]+')->middleware('Authentication');
        Router::get('/image/:id', 'ImageController.edit')->with(':id', '[0-9]+')->middleware('Authentication');
        Router::post('/image/:id', 'ImageController.save')->with(':id', '[0-9]+')->middleware('Authentication');
        Router::get('/image/delete/:id', 'ImageController.delete')->with(':id', '[0-9]+')->middleware('Authentication');

        Router::get('/user', 'UserController')->middleware('Authentication');
        Router::get('/user/logout', 'UserController.logout');
        Router::get('/user/login', 'UserController.login');
        Router::post('/user/login', 'UserController.doLogin');
        Router::get('/user/signup', 'UserController.signup');
        Router::post('/user/signup', 'UserController.doSignup');
        Router::get('/user/resendemail', 'UserController.resendemail');
        Router::post('/user/resendemail', 'UserController.doResendemail');
        Router::get('/user/resetPassword/:id/:activationKey', 'UserController.resetPassword')->with(':id', '[0-9]+');
        Router::get('/user/resetPasswordEmail/:username', 'UserController.resetPasswordEmail');
        Router::get('/user/activate/:id/:activationKey', 'UserController.activate')->with(':id', '[0-9]+');

        Router::get('/about', 'AboutController')->middleware('Authentication');

        Router::run();
    }
?>