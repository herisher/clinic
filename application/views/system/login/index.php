<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Clinic | System</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>css/admin.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url() ?>js/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>js/bootstrap.min.js" type="text/javascript"></script>
</head>

<body class="login-page">
<div class="login-box">
    <div class="login-logo">
        <a><b>Login User</b></a>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <form action="/system/login" method="post">
            <div class="form-group has-feedback">
                <input type="text" name="username" class="form-control" placeholder="Username"/>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                <?php echo form_error("username", "<p style='color:red;'>", "</p>"); ?>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="Password"/>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <?php echo form_error("password", "<p style='color:red;'>", "</p>"); ?>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary btn-block btn-flat ">Sign In</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</html>
