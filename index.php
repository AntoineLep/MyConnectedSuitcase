<?php 
    session_start();
    $_SESSION['idUser'] = 1;
    set_include_path($_SERVER['DOCUMENT_ROOT']);
    require('./constants.php');
    require('./common.php');
 ?>