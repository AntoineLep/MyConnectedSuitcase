<?php

    /**
    * Get the path of a css file
    * @param (string) filename : Name of the file (with its extension)
    * @return (string) url to the file
    */
    function css_path($filename){
        return _path($filename, 'css');
    }

    /**
    * Get the path of a js file
    * @param (string) filename : Name of the file (with its extension)
    * @return (string) url to the file
    */
    function js_path($filename){
        return _path($filename, 'js');
    }

    /**
    * Get the path of an image
    * @param (string) filename : Name of the file (with its extension)
    * @return (string) url to the file
    */
    function img_path($filename){
        return _path($filename, 'img');
    }


    /**
    * Get the path of an asset file
    * @param (string) filename : Name of the file (with its extension)
    * @param (string) subpath : the subfolder of the concerned asset
    * @return (string) url to the file
    */
    function _path($filename, $subpath){
        $uri = str_replace(ROOT, '', ASSETS_FOLDER);
        $uri = str_replace('\\', '/', $uri);
        return '"' . BASE_URL . $uri . '/' . $subpath . '/' . $filename . '"';
    }

    /**
    * Format a datetime to a string (m/d/Y)
    * @param (DateTime) datetime : Datetime to be formated
    * @return (string) String format of the datetime
    */
    function dateFormat($datetime){
        $date = new DateTime($datetime);
        return $date->format('m/d/Y');
    }

    /**
    * Tells if a date string has a good format
    * @param (string) date : String date to be checked
    * @return (bool) True is the format is good, false otherwise
    */
    function isValidDate($date){
        return (preg_match('#^([0-9]{2})[\/]([0-9]{2})[\/]([0-9]{4})$#', $date, $matches) == 1 && checkdate($matches[1], $matches[2], $matches[3]));
    }

    /**
    * Return the full url of an uri
    * @param (string) uri : The uri to be converted to a full url
    * @return (string) The full url from the uri
    */
    function url($uri){
        return substr($uri, 0, 1) == '/' ? '"' . BASE_URL . $uri . '"' : '"' . BASE_URL . '/' . $uri . '"';
    }
?>