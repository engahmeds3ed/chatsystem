<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php if(!empty($title)){echo $title;}else{echo $config['sitename'];} ?></title>
        
        <!-- for IE6-8 support of HTML elements -->
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <!-- styles -->
        <link href="<?php echo $this->assets; ?>css/font-awesome.css" rel="stylesheet" />
        <link href="<?php echo $this->assets; ?>css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo $this->assets; ?>css/bootstrap-theme.min.css" rel="stylesheet" />
        <?php if($loggedin){ ?>
            <link href="<?php echo $this->assets; ?>css/simple-sidebar.css" rel="stylesheet" />
        <?php } ?>
        <link rel="stylesheet" href="<?php echo $this->assets; ?>css/style.css" type="text/css" />
    </head>
    <body>
        

        <?php if($loggedin){ ?>
        <div id="topbar">
            <div class="container text-right">
                Hi <?php echo $cur_userdata->user_fullname; ?>,
                <a href="<?php echo base_url("chat"); ?>">Chat</a> | 
                <a href="<?php echo base_url("login/logout"); ?>">LogOut</a>
            </div>
        </div>
        <?php } ?>
        
        <div class="container<?php if($fullwidth){ ?>-fluid<?php } ?>" id="fullcontainer">
            <h1 class="text-center"><?php echo $config['sitename']; ?></h1>