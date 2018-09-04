<?php
    $sessionadmin = $this->session->userdata("login_admin");
    if ($sessionadmin){
        $modulesmenu = $sessionadmin["login_modules_menu"];
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/jquery.dataTables.css">
	
	<script type="text/javascript" language="javascript" src="<?php echo base_url() ?>js/jquery.js"></script>
	
	
	
        <meta charset="UTF-8">
        <title>88Avenue | Apartment Surabaya</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <link href="<?php echo base_url() ?>css/jquery-ui.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
       
        <link href="<?php echo base_url() ?>css/datatables/dataTables.responsive.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url() ?>css/admin.css" rel="stylesheet" type="text/css" media="screen, print" />
        <link href="<?php echo base_url() ?>css/morris/morris.css" rel="stylesheet" type="text/css" />

        <script src="<?php echo base_url() ?>js/respond.js"></script>
        <script src="<?php echo base_url() ?>js/html5shiv.js"></script>
		<script src="<?php echo base_url() ?>js/jquery.min.js"></script>
        <script src="<?php echo base_url() ?>js/jquery-ui.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>js/plugins/datatables/dataTables.responsive.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>js/admin/app.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>js/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
        <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
        <!-- page script -->
        <script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": true,
                    "bFilter": true,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
        </script>
    </head>
    <body class="skin-gold fixed">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?php echo base_url() ?>admin/dashboard" class="logo logo_88">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button" title="Hide Menu">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
				<?php
                if (isset($login_admin))
				$email = $login_admin['email'];
                else
                $email ="";
				?>
                  <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <li class="dropdown notifications-menu">
                            <!--a href="#" class="dropdown-toggle" data-toggle="dropdown" id="totalmodule">
                                 Module
                                <span class="label label-warning" id="countmodule"><?php //echo count($modulesmenu); ?></span>
                            </a-->
                            <script type="text/javascript">
                                /*$("#totalmodule").click(function(){
                                    $("#countmodule").hide();
                                });*/
                                $("#totalmodule").click(function(){
                                $("#countmodule").remove();
                                });
                            </script>
                        </li>
                        <!--<li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                FAQ
                            </a>
                        </li>-->
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span> <?= $email ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-gold">
                                    <p>
                                        Admin | 88avenue.id
                                    </p>
                                </li>

                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="/logout" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </nav>
        </header>
<?php

    if ($sessionadmin){
        $usertype = $sessionadmin["login_admin_type"];
        $userdir = "admin/";
        /*$userdir = $sessionadmin["login_user_directory"];
        if ($usertype == 1) require_once 'menu.php';
        elseif ($usertype == 2) require_once 'menu_sales.php';
        elseif ($usertype == 3) require_once 'menu_finance.php';
        elseif ($usertype == 4) require_once 'menu_cashier.php';
        elseif ($usertype == 5) require_once 'menu_inventory.php';
        elseif ($usertype == 6) require_once 'menu_pricing.php';
        elseif ($usertype == 7) require_once 'menu_legal.php';*/
        require_once 'menu.php';
    }
    $sessionmarketing = $this->session->userdata("login_marketing");
    if ($sessionmarketing){
        require_once 'menu_agency.php';
    }
?>