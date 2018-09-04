<?php
$sessionadmin = $this->session->userdata("login_admin");
if ($sessionadmin){
    //$modulesmenu = $sessionadmin["login_modules_menu"];
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Clinic | System</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" href="<?php echo base_url() ?>img/favicon.jpg" type="text/css" />
    <link href="<?php echo base_url() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>css/admin.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>css/skin-gold.css" rel="stylesheet" type="text/css" />

    <script src="<?php echo base_url() ?>js/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo base_url() ?>js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>js/app.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>js/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>js/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

    </head>

    <body class="skin-gold sidebar-mini hold-transition fixed  sidebar-collapse">

        <header class="main-header">
            <!-- Logo -->
            <a href="<?php echo base_url() ?>system/dashboard" class="logo">
               <IMG class="logo-mini" SRC="<?php echo base_url() ?>img/logo.png" height="50" width="50">
               <span class="logo-lg"><b>CLINIC</b></span>
            </a>
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <?php
                if (isset($login_admin))
                    $username = $login_admin['username'];
                else
                    $username ="";
                ?>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav" id="mnav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle fa fa-gear" data-toggle="dropdown">
                                <span class="hidden-xs">Hello, <?= $username ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <p>
                                        <?= $username ?>
                                    </p>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?php echo base_url();?>system/manage/password" class="btn btn-default btn-flat" onclick="window.open('<?php echo base_url();?>system/manage/password', 'newwindow', 'width=600,height=450,left=400,top=250 ,scrollbars=yes'); return false;">Change Password</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="/system/logout" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
