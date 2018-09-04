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
            window.opener.document.location.reload();
            self.close();
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
                                        <h3 class="text-center"><strong>Edit User</strong></h3>
                                        <hr>
                                    </div>
                                    <div class="box-body">
									<form name="adminform" id="adminform" action="<?php echo base_url();?>system/manage/detail/<?= $id ?>" method="post" autocomplete="on">
									<!-- Dummy for Forms in Google Chrome -->
									<input style="display:none;" type="text" name="username_dummy" />
									<input style="display:none;" type="password" name="password_dummy" />
                                        <div class="form-horizontal">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label  class="col-xs-5 control-label" >Username</label>
                                                    <div class="col-xs-7">
                                                        <input id="username" class="form-control" type="text" placeholder="Username" value="<?= set_value('username', $adm['username']) ?>" name="username"/>
														<?php echo form_error('username', '<br><font color="#FF0000">', '</font>'); ?>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label  class="col-xs-5 control-label" >Password</label>
                                                    <div class="col-xs-7">
                                                        <input id="password" class="form-control" type="password" placeholder="Password" value="" name="password" autocomplete="off"/>
														<?php echo form_error('password', '<br><font color="#FF0000">', '</font>'); ?>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label  class="col-xs-5 control-label" >Confirm Password</label>
                                                    <div class="col-xs-7">
                                                        <input id="conf_password" class="form-control" type="password" placeholder="Conf Password" value="" name="conf_password" autocomplete="off"/>
														<?php echo form_error('conf_password', '<br><font color="#FF0000">', '</font>'); ?>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label  class="col-xs-5 control-label" >User Type</label>
                                                    <div class="col-xs-7">
                                                        <select id="user_type" class="form-control" type="text" name="user_type" value="<?php echo set_value("user_type",''); ?>">
                                                            <option value="" <?php echo set_select("user_type",''); ?>>-Choose-</option>
                                                            <?php foreach( $type_option as $key => $val ) : ?>
                                                            <option value="<?= $key ?>" <?php echo set_select("user_type",$key, ($adm['user_type'] == $key)); ?>><?= $val ?></option>
                                                            <?php endforeach;?>
                                                        </select>
														<?php echo form_error('user_type', '<br><font color="#FF0000">', '</font>'); ?>
                                                    </div>
                                                </div>
												<div class="form-group">
                                                    <label  class="col-xs-5 control-label" >Doctor</label>
                                                    <div class="col-xs-7">
                                                        <select id="doctor_id" class="form-control" type="text" name="doctor_id" value="<?php echo set_value("doctor_id",''); ?>">
                                                            <option value="" <?php echo set_select("doctor_id",''); ?>>-Choose-</option>
                                                            <?php foreach( $doctor_option as $key => $val ) : ?>
                                                            <option value="<?= $key ?>" <?php echo set_select("doctor_id",$key, ($adm['doctor_id'] == $key)); ?>><?= $val ?></option>
                                                            <?php endforeach;?>
                                                        </select>
														<?php echo form_error('doctor_id', '<br><font color="#FF0000">', '</font>'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                            <h5 style="font-style: italic;"><i class="fa fa-check-square-o"></i> Pages</h5>
											<?php echo form_error('type', '<br><font color="#FF0000">', '</font>'); ?>
											<?php foreach($_categories as $c => $category): ?>
											<div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="heading<?=$c?>">
                                                    <h4 class="panel-title">
                                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$c?>" aria-expanded="true" aria-controls="collapse<?=$c?>">
                                                            <?= $category['name'] ?>
                                                        </a><i class="indicator glyphicon glyphicon-chevron-up  pull-right"></i>
                                                    </h4>
                                                </div>
                                                <div id="collapse<?=$c?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$c?>">
                                                    <div class="panel-body">
													<?php foreach($_pages[$c] as $p => $page): ?>
													<span class="button-checkbox">
                                                            <button type="button" class="btn btn-role types" data-color="success"><?= $page['name'] ?></button>
                                                            <input type="checkbox" id="showall" class="hidden types" name="type<?=$c?>[]" value="<?=$p?>" <?= set_checkbox('type'.$c.'[]',$p,(array_key_exists($c, $typ) && ($typ[$c] & $p) ? TRUE : FALSE)) ?> />
                                                        </span>
													<?php endforeach; ?>
                                                    </div>
                                                </div>
                                            </div>
											<?php endforeach; ?>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="text-center">
												<button type="submit" class="btn btn-danger" name="submit" value="delete" onclick="return confirm('Are you sure you want to delete account?')">Delete Account</button>
												<button type="submit" class="btn btn-primary" name="submit" value="edit">Edit Account</button>
                                                <br/><br/>
                                                <a href="#" onclick="javascript:self.close();" class="btn btn-danger"><i class="fa fa-remove">&nbsp;</i> Close</a>
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
<?php //require_once APPPATH.'views/system/footer.php'; ?>
<script src="<?php echo base_url() ?>js/intlTelInput.js"></script>
<script>
    function toggleChevron(e) {
        $(e.target)
            .prev('.panel-heading')
            .find("i.indicator")
            .toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
    }
    $('#accordion').on('hidden.bs.collapse', toggleChevron);
    $('#accordion').on('shown.bs.collapse', toggleChevron);
    $(function () {
        $('.button-checkbox').each(function () {

            // Settings
            var $widget = $(this),
                $button = $widget.find('button'),
                $checkbox = $widget.find('input:checkbox'),
                color = $button.data('color'),
                settings = {
                    on: {
                        icon: 'glyphicon glyphicon-check'
                    },
                    off: {
                        icon: 'glyphicon glyphicon-unchecked'
                    }
                };

            // Event Handlers
            $button.on('click', function () {
                $checkbox.prop('checked', !$checkbox.is(':checked'));
                $checkbox.triggerHandler('change');
                updateDisplay();
            });
            $checkbox.on('change', function () {
                updateDisplay();
            });

            // Actions
            function updateDisplay() {
                var isChecked = $checkbox.is(':checked');

                // Set the button's state
                $button.data('state', (isChecked) ? "on" : "off");

                // Set the button's icon
                $button.find('.state-icon')
                    .removeClass()
                    .addClass('state-icon ' + settings[$button.data('state')].icon);

                // Update the button's color
                if (isChecked) {
                    $button
                        .removeClass('btn-default')
                        .addClass('btn-' + color + ' active');
                }
                else {
                    $button
                        .removeClass('btn-' + color + ' active')
                        .addClass('btn-default');
                }
            }

            // Initialization
            function init() {

                updateDisplay();

                // Inject the icon if applicable
                if ($button.find('.state-icon').length == 0) {
                    $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i> ');
                }
            }
            init();
        });
    });
    $(function () {
        var val = $( "#user_type" ).val();
        if( val == 1 ) {//super admin
            $('#doctor_id').attr('disabled','disabled');
            $('.types').attr('disabled','disabled');
        } else {
            $('.types').removeAttr('disabled');
            if( val == 2 ) {//doctor
                $('#doctor_id').removeAttr('disabled');
            } else {
                $('#doctor_id').attr('disabled','disabled');
            }
        }
        $( "#user_type" ).change(function() {
            var val = $( "#user_type" ).val();
            $('#doctor_id').val('');
            if( val == 1 ) {//super admin
                $('#doctor_id').attr('disabled','disabled');
                $('.types').attr('disabled','disabled');
            } else {
                $('.types').removeAttr('disabled');
                if( val == 2 ) {//doctor
                    $('#doctor_id').removeAttr('disabled');
                } else {
                    $('#doctor_id').attr('disabled','disabled');
                }
            }
        });
    });
</script>