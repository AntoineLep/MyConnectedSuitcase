<?php
    //Software
    define('PROGRAM_NAME','MyConnectedSuitcase');
    define('PROGRAM_TITLE','My Connected Suitcase');
    define('VERSION','0.1 alpha');
    define('AUTHOR','Antoine Leprevost');
    define('PROTOCOL', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http');
    define('BASE_URL', PROTOCOL . '://' . $_SERVER['SERVER_NAME'] . '/' . 'MyConnectedSuitcase');

    //Folders
    define('DS', DIRECTORY_SEPARATOR);
    define('ROOT', dirname(__FILE__));

    define('APP_FOLDER', ROOT . DS . 'app');
    define('CORE_FOLDER', ROOT . DS . 'core');

    define('CLASS_FOLDER', APP_FOLDER . DS . 'class');
    define('CONTROLLER_FOLDER', APP_FOLDER . DS . 'controller');
    define('MODEL_FOLDER', APP_FOLDER . DS . 'model');
    define('VIEW_FOLDER', APP_FOLDER . DS. 'view');
    define('ASSETS_FOLDER', APP_FOLDER . DS . 'assets');

    define('TEMPLATE_FOLDER', VIEW_FOLDER . DS . 'template');

    define('USER_IMAGES_FOLDER_NAME', 'user_images');

    class Extension {
        /**
        * (array) Supported php file exetensions
        */
        static $supportedPhpExtensions = array('.class.php', '.php');
    }

    //Database constants
    class DBConstant {
        const DBHOST = 'localhost';
        const DBNAME = 'mcs';
        const DBUSER = 'root';
        const DBPASSWD = '';
    }
?>