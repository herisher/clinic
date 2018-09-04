<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Clinic | System</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" href="<?php echo base_url() ?>img/favicon.jpg" type="text/css" />
    <link href="<?php echo base_url() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>css/admin.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>css/skin-gold.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>css/intlTelInput.css">

    <script src="<?php echo base_url() ?>js/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo base_url() ?>js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>js/app.js" type="text/javascript"></script>
    
	<script src="<?php echo base_url() ?>js/datatables/jquery.dataTables.js" type="text/javascript"></script>
	<script src="<?php echo base_url() ?>js/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
	<link href="<?php echo base_url() ?>css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />


<link href="<?php echo base_url() ?>css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url() ?>js/fileinput.js" type="text/javascript"></script>


<style>
    .panel-admin .panel-body {
        overflow: auto;
        max-height: 500px;
    }
    .panel-admin .user-admin {
        display: block;
        float: left;
        width: 140px;
        margin: 0 5px 5px 0;
        font-size: 0.85em;
        overflow: hidden;
        -o-text-overflow: ellipsis;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .panel-admin .user-admin img {
        float: left;
        height: 28px;
        margin-right: 5px;
    }
    .panel-admin .user-admin .username {
        font-size: 0.9em;
        color: #999;
        overflow: hidden;
        -o-text-overflow: ellipsis;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .btn-role {
        border-radius: 3px;
        position: relative;
        padding: 15px 5px;
        margin: 0px 0px 10px 10px;
        min-width: 80px;
        height: 50px;
        text-align: center;
        color: rgba(0, 0, 0, 0.53);
        border: 1px solid rgba(89, 87, 255, 0.13);
        font-size: 13px;
    }
</style>
<script type="text/javascript">
        <?php if( isset($next) && $next == 1 ) : ?>
            alert("Password successfully changed.");
        <?php endif; ?>
    </script>
</head>
<aside class="right-side">
    <section class="content-header">
        <h1>
           <i class="fa fa-users fa-1x">&nbsp;</i>  User
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="box box-gold">
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="well">
                                <div class="box panel-admin ssss">
                                    <div class="box-header">
                                        <h3 class="text-center"><strong>Change Password</strong></h3>
                                        <hr>
                                    </div>
                                    <div class="box-body">
									<form name="adminform" id="adminform" action="<?php echo base_url();?>system/manage/password" method="post" autocomplete="on">
									<!-- Dummy for Forms in Google Chrome -->
									<input style="display:none;" type="text" name="username_dummy" />
									<input style="display:none;" type="password" name="password_dummy" />
                                        <div class="form-horizontal">
                                            <div class="col-md-6">
												<div class="form-group">
                                                    <label  class="col-sm-5 control-label" >Old Password</label>
                                                    <div class="col-sm-7">
                                                        <input id="old_password" class="form-control" type="password" placeholder="Old Password" value="" name="old_password" autocomplete="off"/>
														<?php echo form_error('old_password', '<br><font color="#FF0000">', '</font>'); ?>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label  class="col-sm-5 control-label" >New Password</label>
                                                    <div class="col-sm-7">
                                                        <input id="password" class="form-control" type="password" placeholder="New Password" value="" name="password" autocomplete="off"/>
														<?php echo form_error('password', '<br><font color="#FF0000">', '</font>'); ?>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label  class="col-sm-5 control-label" >Confirm New Password</label>
                                                    <div class="col-sm-7">
                                                        <input id="conf_password" class="form-control" type="password" placeholder="Conf New Password" value="" name="conf_password" autocomplete="off"/>
														<?php echo form_error('conf_password', '<br><font color="#FF0000">', '</font>'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="text-center">
                                                <a href="#" onclick="javascript:self.close();" class="btn btn-danger"><i class="fa fa-remove">&nbsp;</i> Close</a>
												<button type="submit" class="btn btn-primary" name="submit" value="change">Change</button>
                                            </div>
                                        </div>
									</form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                    </div>
                </div>
            </div>
            <div class="col-md-6">

            </div>
        </div>
        <!-- Data table end here-->
    </section>
</aside>