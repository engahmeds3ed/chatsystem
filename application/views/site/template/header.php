<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php if(!empty($title)){echo $title;}else{echo $config->cfg_sitename;} ?></title>
        
        <!-- for IE6-8 support of HTML elements -->
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <!-- styles -->
        <link href="<?php echo $this->assets; ?>css/font-awesome.css" rel="stylesheet" />
        <link href="<?php echo $this->assets; ?>css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo $this->assets; ?>css/bootstrap-theme.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo $this->assets; ?>css/style.css" type="text/css" />
    </head>
    <body>
        <div class="topbar">
            <?php if($loggedin){ ?>
            <a href="<?php echo base_url("login/logout"); ?>" class="btn btn-success">LogOut</a>
            <?php } ?>
        </div>
        <div class="container" id="fullcontainer">