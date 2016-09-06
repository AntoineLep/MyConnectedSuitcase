<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title><?php echo PROGRAM_TITLE; ?></title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
        <link type="text/css" rel="stylesheet" href=<?php echo css_path('bootstrap.min.css'); ?> />
        <link type="text/css" rel="stylesheet" href=<?php echo css_path('metisMenu.min.css'); ?> />
        <link type="text/css" rel="stylesheet" href=<?php echo css_path('font-awesome.min.css'); ?> />
        <link type="text/css" rel="stylesheet" href=<?php echo css_path('style.css'); ?> />
    </head>
    <body>
        <div id="wrapper">
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href=<?php echo url('trips'); ?>><?php echo PROGRAM_TITLE; ?></a>
                </div>
                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li> <a href=<?php echo url('trip'); ?>><i class="fa fa-globe fa-fw"></i> Trips</a></li>
                            <li> <a href=<?php echo url('/'); ?>><i class="fa fa-map fa-fw"></i> Trip map</a></li>
                            <li> <a href=<?php echo url('user'); ?>><i class="fa fa-user fa-fw"></i> User profile</a></li>
                            <li> <a href=<?php echo url('user/logout'); ?>><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                            <li> <a href=<?php echo url('about'); ?>><i class="fa fa-question fa-fw"></i> About</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div id="page-wrapper">
                <?php if(isset($pageTitle)) { ?>
                    <h1 class="page-header"><?php echo $pageTitle; ?></h1>
                <?php } ?>

                <?php echo $_viewContent; ?>
                
            </div>
        </div>

        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
        <script type="text/javascript" src=<?php echo js_path('bootstrap.min.js'); ?>></script>
        <script type="text/javascript" src=<?php echo js_path('metisMenu.min.js'); ?>></script>
        <script type="text/javascript" src=<?php echo js_path('sb-admin-2.js'); ?>></script>
        <?php if(isset($enableLocation) && $enableLocation) { ?>
            <script type="text/javascript" src="http://maps.google.com/maps/api/js?libraries=places&key=AIzaSyCgmGyxiflhQfpMH9GFgxHbKhPVTPuPYHA"></script>
            <script type="text/javascript" src=<?php echo js_path('locationpicker.jquery.js'); ?>></script>
            <script type="text/javascript" src=<?php echo js_path('destinationEdit.js'); ?>></script>
        <?php } ?>
    </body>
</html>