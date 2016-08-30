<?php

    $file = 'gpsdata.txt';

    if(file_exists($file)){

        $fileStream = @fopen($file, "r" );
        $pos = -1;
        $tmp = '';
        $chr = '';

        while ($chr != "\n" || empty(trim($tmp))) {

            if($chr == "\n" && empty(trim($tmp)))
                $tmp = '';

            if (!fseek($fileStream, $pos, SEEK_END)) {
                $chr = fgetc($fileStream);
                if($chr != "\n")
                    $tmp = $chr . $tmp;
                $pos = $pos - 1;
            }
            else
            {
                rewind($fileStream);
                break;
            }
        }

        $tmp = fgets($fileStream);
        fclose($fileStream);

        if(!empty(trim($tmp)) && trim($tmp) != '[NaN, NaN]')
            echo $tmp;
    }
?>