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
    function userIsConnected(){
        return (isset($_SESSION['idUser']) && $_SESSION['idUser'] > 0);
    }

    /**
    * Tells if an email is a valid email or not
    * @param (string) email : The email to be validated
    * @return (bool) True if the email is valid, false otherwise
    */
    function validEmail($email){
        return (filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $email));
    }

    /**
    * Delete a repository and all its files
    * @param (string) dir : The dir path
    * @return (bool) True if the deletion success, false otherwise
    */
    function delTree($dir) {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) 
            (is_dir($dir . DS . $file)) ? delTree($dir . DS . $file) : unlink($dir . DS . $file);
        return rmdir($dir);
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
                $userModel = new UserModel();
                $dbUser = $userModel->getUserWithEmail($email);

                if($dbUser != null)
                    if($dbUser['activation_key'] == $cryptedKey)
                        $_SESSION['idUser'] = $dbUser['id'];
            }
        }
    }

    /**
    * Send a validation email to the user in order to validate his inscription
    * @param (array) user : User information
    * @return (bool) true if the mail is sent, false otherwise
    */
    function sendValidationEmail($user){
        $to = $user['email'];
        $subject = PROGRAM_TITLE . ' - Activate your account';
        $message = 'Hello,
                    Thank you for your interest to ' . PROGRAM_TITLE . '!
                    Before you can fully take advantage of your account, you need to activate it.
                    Please follow this link: ' . cleanUrl('user/activate/' . $user['id'] . '/' . $user['activation_key']) . '
                    Best regards,
                    ' . PROGRAM_TITLE . ' Team.';
        $headers = 'From: noreply' . EMAIL_BASE . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

        return mail($to, $subject, $message, $headers);
    }

    /**
    * Send a forgotten password to the user in order to reset his password
    * @param (array) user : User information
    * @return (bool) true if the mail is sent, false otherwise
    */
    function sendForgottenPasswordEmail($user){
        $to = $user['email'];
        $subject = PROGRAM_TITLE . ' - Forgot your password ?';
        $message = 'Hello,
                    It looks like your forgot your password!
                    If you are not at the origin of this request please ignore this E-mail.
                    If you asked for a password reset, please follow this link: ' . cleanUrl('user/resetpassword/' . $user['id'] . '/' . $user['activation_key']) . '
                    Best regards,
                    ' . PROGRAM_TITLE . ' Team.';
        $headers = 'From: noreply' . EMAIL_BASE . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

        return mail($to, $subject, $message, $headers);
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
                            $Ress_Src = imagecreatefromjpeg($rep_Src . $img_Src);
                            $Ress_Dst = ImageCreateTrueColor($W,$H);
                            break;
                        case 'png':
                            $Ress_Src = imagecreatefrompng($rep_Src . $img_Src);
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