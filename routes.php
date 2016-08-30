<?php 
    if(isset($_GET['url'])){

        Router::init($_GET['url']);

        Router::get('/', 'HomeController');

        Router::get('/location', 'LocationController');
        Router::get('/location/:id', 'LocationController.edit');
        Router::post('/location/:id', 'LocationController.save');
        Router::get('/location/delete/:id', 'LocationController.delete');

        Router::run();
    }
?>