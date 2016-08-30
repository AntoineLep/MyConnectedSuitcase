<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title><?php echo PROGRAM_NAME; ?></title>
        <link type="text/css" rel="stylesheet" href=<?php echo css_path('bootstrap.min.css'); ?> />
        <link type="text/css" rel="stylesheet" href=<?php echo css_path('bootstrap-theme.min.css'); ?> />
        <link type="text/css" rel="stylesheet" href=<?php echo css_path('style.css'); ?> />
    </head>
    <body>
    
        <div id="location-container">
            <?php echo $_viewContent; ?>
        </div>

        <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyCgmGyxiflhQfpMH9GFgxHbKhPVTPuPYHA"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src=<?php echo js_path('bootstrap.min.js'); ?>></script>
        <script type="text/javascript" src=<?php echo js_path('locationpicker.jquery.js'); ?>></script>
        <script type="text/javascript" src=<?php echo js_path('location.js'); ?>></script>
    </body>
</html>