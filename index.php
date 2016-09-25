<?php 
	//uncomment to enable online debug
	//error_reporting(-1);
	//ini_set('display_errors', 'On');
    session_start();
    set_include_path($_SERVER['DOCUMENT_ROOT']);
    require('./constants.php');
    require('./common.php');
    if(!userIsConnected())
        autologin();
 ?>