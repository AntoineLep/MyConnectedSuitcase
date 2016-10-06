<?php 
    if(isset($_GET['url'])){

        Router::init($_GET['url']);

        Router::get('/', 'HomeController');
        Router::get('/404', 'HomeController.notfound');
        Router::get('/gcu', 'HomeController.gcu');        

        //Trips
        Router::get('/trip', 'TripController')->middleware('Authentication');

        Router::get('/trip/:id', 'TripController.edit')->with(':id', '[0-9]+')->middleware('Authentication');
        Router::post('/trip/:id', 'TripController.save')->with(':id', '[0-9]+')->middleware('Authentication');

        Router::get('/trip/delete/:id', 'TripController.delete')->with(':id', '[0-9]+')->middleware('Authentication');

        //Destinations
        Router::get('/destination/-1/:idTrip', 'DestinationController.create')->with(':idTrip', '[0-9]+')->middleware('Authentication');

        Router::get('/destination/:id', 'DestinationController.edit')->with(':id', '[0-9]+')->middleware('Authentication');
        Router::post('/destination/:id', 'DestinationController.save')->with(':id', '[0-9]+')->middleware('Authentication');

        Router::get('/destination/delete/:id', 'DestinationController.delete')->with(':id', '[0-9]+')->middleware('Authentication');

        //Images
        Router::get('/image/-1/:idDestination', 'ImageController.create')->with(':idDestination', '[0-9]+')->middleware('Authentication');

        Router::get('/image/:id', 'ImageController.edit')->with(':id', '[0-9]+')->middleware('Authentication');
        Router::post('/image/:id', 'ImageController.save')->with(':id', '[0-9]+')->middleware('Authentication');

        Router::get('/image/delete/:id', 'ImageController.delete')->with(':id', '[0-9]+')->middleware('Authentication');

        //Trip map
        Router::get('/tripmap/:username/:tripId', 'TripMapController.showTripMap')->with(':tripId', '[0-9]+');
        Router::get('/tripmap/:username/:tripId/destinations', 'TripMapController.getDestinations')->with(':tripId', '[0-9]+');

        //User
        Router::get('/user', 'UserController')->middleware('Authentication');
        Router::post('/user/form/:action', 'UserController.doChangeUserInfo')->middleware('Authentication');
        
        Router::get('/user/logout', 'UserController.logout');

        Router::get('/user/login', 'UserController.login');
        Router::post('/user/login', 'UserController.doLogin');

        Router::get('/user/signup', 'UserController.signup');
        Router::post('/user/signup', 'UserController.doSignup');

        Router::get('/user/resendemail', 'UserController.resendemail');
        Router::post('/user/resendemail', 'UserController.doResendemail');

        Router::get('/user/resetpassword/:id/:activationKey', 'UserController.resetPassword')->with(':id', '[0-9]+');
        Router::post('/user/resetpassword', 'UserController.doResetPassword');

        Router::get('/user/forgotpassword', 'UserController.forgotPassword');
        Router::post('/user/forgotpassword', 'UserController.doForgotPassword');

        Router::get('/user/activate/:id/:activationKey', 'UserController.activate')->with(':id', '[0-9]+');

        Router::get('/help', 'HelpController')->middleware('Authentication');

        try {
            Router::run();
        } catch (RouterException $re) {
            header('location:' . cleanUrl('/404'));
        }
    }
?>