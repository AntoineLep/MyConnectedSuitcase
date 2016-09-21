<?php 
    session_start();
    set_include_path($_SERVER['DOCUMENT_ROOT']);
    require('./constants.php');
    require('./common.php');
    if(!user_is_connected())
    	autologin();
 ?>