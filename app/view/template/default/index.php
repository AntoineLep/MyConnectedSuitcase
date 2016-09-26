<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title><?php echo PROGRAM_TITLE; ?></title>
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