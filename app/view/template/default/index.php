<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <!-- for Google -->
        <meta name="description" content="Share your globe trotting experiences around you! Create trips and add illustrated destinations to show your friends how amazing was your trip." />
        <meta name="keywords" content="trips, hollydays, illustrated, my, connected, suitcase, travel, journey, journal" />
        <meta name="author" content="Antoine Leprevost" />
        <meta name="copyright" content=<?php echo '"Copyright 2016 ' . PROGRAM_NAME . '"'; ?> />
        <meta name="application-name" content=<?php echo '"' . PROGRAM_NAME . '"'; ?> />

        <!-- for Facebook -->          
        <meta property="og:title" content=<?php echo '"' . PROGRAM_NAME . '"'; ?> />
        <meta property="og:type" content="website" />
        <meta property="og:image" content=<?php echo img_path('favicons/android-chrome-192x192.png'); ?> />
        <meta property="og:url" content=<?php echo '"' . BASE_URL . '"'; ?> />
        <meta property="og:description" content="Share your globe trotting experiences around you! Create trips and add illustrated destinations to show your friends how amazing was your trip." />

        <!-- for Twitter -->          
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:title" content=<?php echo '"' . PROGRAM_NAME . '"'; ?> />
        <meta name="twitter:description" content="Share your globe trotting experiences around you! Create trips and add illustrated destinations to show your friends how amazing was your trip." />
        <meta name="twitter:image" content=<?php echo img_path('favicons/android-chrome-192x192.png'); ?> />

        <title><?php echo PROGRAM_TITLE; ?></title>
        
        <link rel="apple-touch-icon" sizes="180x180" href=<?php echo img_path('favicons/apple-touch-icon.png'); ?>>
        <link rel="icon" type="image/png" href=<?php echo img_path('favicons/favicon-32x32.png'); ?> sizes="32x32">
        <link rel="icon" type="image/png" href=<?php echo img_path('favicons/favicon-16x16.png'); ?> sizes="16x16">
        <link rel="manifest" href=<?php echo img_path('favicons/manifest.json'); ?>>
        <link rel="mask-icon" href=<?php echo img_path('favicons/safari-pinned-tab.svg'); ?> color="#5bbad5">
        <link rel="shortcut icon" href=<?php echo img_path('favicons/favicon.ico'); ?>>
        <meta name="msapplication-config" content=<?php echo img_path('favicons/browserconfig.xml'); ?>>
        <meta name="theme-color" content="#ffffff">

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
        <link type="text/css" rel="stylesheet" href=<?php echo css_path('bootstrap.min.css'); ?> />
        <link type="text/css" rel="stylesheet" href=<?php echo css_path('font-awesome.min.css'); ?> />
        <link type="text/css" rel="stylesheet" href=<?php echo css_path('style.css'); ?> />
    </head>
    <body>
        <div id="wrapper">
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-brand" href=<?php echo url('/'); ?>><?php echo PROGRAM_TITLE; ?></a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <?php if(!userIsConnected()) { ?>
                        <li>
                            <a href=<?php echo url('/user/login') ?>><i class="fa fa-sign-in fa-fw"></i><strong> Log in</strong></a>
                        </li>
                        <li>
                            <a href=<?php echo url('/user/signup') ?>><i class="fa fa-plus fa-fw"></i><strong> Sign up</strong></a>
                        </li>
                    <?php } else { ?>
                        <li>
                            <a href=<?php echo url('/trip') ?>><i class="fa fa-globe fa-fw"></i><strong> Administration</strong></a>
                        </li>
                        <li>
                            <a href=<?php echo url('/user/logout') ?>><i class="fa fa-sign-out fa-fw"></i><strong> Log out</strong></a>
                        </li>
                    <?php } ?>
                </ul>
            </nav>
            
            <div id="homepage-wrapper">
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
    </body>
</html>