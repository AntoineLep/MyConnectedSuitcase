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
    function isValidDateString($date){
        return (preg_match('#^([0-9]{2})[\/]([0-9]{2})[\/]([0-9]{4})$#', $date, $matches) == 1 && checkdate($matches[1], $matches[2], $matches[3]));
    }

        /**
    * Tells if a date string has a good format
    * @param (datetime) date : date to be checked
    * @return (bool) True is the format is good, false otherwise
    */
    function isValidDateTime($date){
        return !is_null($date) && !empty($date) && substr($date, 0, 4) != '0000';
    }

    /**
    * Return the full url of an uri
    * @param (string) uri : The uri to be converted to a full url
    * @return (string) The full url from the uri
    */
    function url($uri){
        return substr($uri, 0, 1) == '/' ? '"' . BASE_URL . $uri . '"' : '"' . BASE_URL . '/' . $uri . '"';
    }

    /**
    * Return the full url of an uri without "" around it
    * @param (string) uri : The uri to be converted to a full url
    * @return (string) The full url from the uri
    */
    function cleanUrl($uri){
        return substr($uri, 0, 1) == '/' ? BASE_URL . $uri : BASE_URL . '/' . $uri;
    }

    /**
    * Tells if the user is connected or not
    * @return (bool) True if the user is connected, false otherwise
    */
    function user_is_connected(){
        return isset($_SESSION['idUser']);
    }

    /**
    * Try to autolog the user if a cookie exists
    */
    function autologin(){
        if(isset($_COOKIE['rememberMe'])){
            $expl = explode('____', $_COOKIE['rememberMe']);
            if(count($expl) == 2){
                $email = $expl[0];
                $cryptedKey = $expl[1];
                var_dump($email);
                var_dump($cryptedKey);
                $userModel = new UserModel();
                $dbUser = $userModel->getUserWithEmail($email);

                if($dbUser != null)
                    if($dbUser['activation_key'] == $cryptedKey)
                        $_SESSION['idUser'] = $dbUser['id'];
            }
        }
    }

    function resizeImg($Wmax, $Hmax, $rep_Dst, $img_Dst, $rep_Src, $img_Src){
        $condition = 0;
        if ($rep_Dst == ''){ $rep_Dst = $rep_Src; }
        if ($img_Dst == ''){ $img_Dst = $img_Src; }
        if ($Wmax == ''){ $Wmax = 0; }
        if ($Hmax == ''){ $Hmax = 0; }

        if (file_exists($rep_Src.$img_Src) && ($Wmax!=0 || $Hmax!=0)){
            $imageExtensions = ['jpg', 'jpeg', 'png'];
            $tabimage = explode('.', $img_Src);
            $extension = $tabimage[sizeof($tabimage) - 1];
            $extension = strtolower($extension);

            if (in_array($extension, $imageExtensions)){
                $size = getimagesize($rep_Src.$img_Src);
                $W_Src = $size[0];
                $H_Src = $size[1];

                if ($Wmax != 0 && $Hmax != 0){
                    $ratiox = $W_Src / $Wmax;
                    $ratioy = $H_Src / $Hmax;
                    $ratio = max($ratiox,$ratioy);
                    $W = $W_Src / $ratio;
                    $H = $H_Src / $ratio;
                    $condition = ($W_Src > $W) || ($W_Src > $H);
                }

                    if ($Hmax != 0 && $Wmax == 0){
                    $H = $Hmax;
                    $W = $H * ($W_Src / $H_Src);
                    $condition = $H_Src > $Hmax;
                }

                if ($Wmax != 0 && $Hmax == 0){
                    $W = $Wmax;
                    $H = $W * ($H_Src / $W_Src);
                    $condition = $W_Src > $Wmax;
                }

                if ($condition == 1){
                    switch($extension){
                        case 'jpg':
                        case 'jpeg':
                            $Ress_Src = imagecreatefromjpeg($rep_Src.$img_Src);
                            $Ress_Dst = ImageCreateTrueColor($W,$H);
                            break;
                        case 'png':
                            $Ress_Src = imagecreatefrompng($rep_Src.$img_Src);
                            $Ress_Dst = ImageCreateTrueColor($W,$H);
                            imagesavealpha($Ress_Dst, true);
                            $trans_color = imagecolorallocatealpha($Ress_Dst, 0, 0, 0, 127);
                            imagefill($Ress_Dst, 0, 0, $trans_color);
                            break;
                    }

                    ImageCopyResampled($Ress_Dst, $Ress_Src, 0, 0, 0, 0, $W, $H, $W_Src, $H_Src);
                    switch ($extension){
                        case 'jpg':
                        case 'jpeg':
                            ImageJpeg ($Ress_Dst, $rep_Dst.$img_Dst);
                            break;
                        case 'png':
                            imagepng ($Ress_Dst, $rep_Dst.$img_Dst);
                            break;
                    }

                    imagedestroy ($Ress_Src);
                    imagedestroy ($Ress_Dst);
                }
            }
        }
        if ($condition == 1 && file_exists($rep_Dst.$img_Dst)) 
            return true;
        return false;
    }
?>