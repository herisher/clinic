<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Clinic | System</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="stylesheet" href="<?php echo base_url() ?>css/intlTelInput.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>css/countrySelect.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>css/country.css">
    <link rel="shortcut icon" href="<?php echo base_url() ?>img/favicon.jpg" type="text/css" />
    <link href="<?php echo base_url() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>css/admin.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>css/skin-gold.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>css/jquery-ui.css" rel="stylesheet">
    <script src="<?php echo base_url() ?>js/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo base_url() ?>js/bootstrap.min.js" type="text/javascript"></script>

    <script src="<?php echo base_url() ?>js/jquery.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>js/jquery-ui.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>jquery.select-to-autocomplete.js"></script>

    <script src="<?php echo base_url() ?>dist/jquery.validate.js"></script>
    <script src="<?php echo base_url() ?>js/jquery.maskedinput.js" type="text/javascript"></script>

    
    <script src="<?php echo base_url() ?>js/fileinput.js" type="text/javascript"></script>
</head>
    <?php if( isset($next) && $next == 1 ) : ?>
        <script type="text/javascript">
            window.opener.document.location.reload();
            self.close();
        </script>
    <?php endif; ?>
    
    <section class="content">
        <div class="row" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
            <div class="col-xs-12">
                <div class="box box-solid box-gold">
                    <div class="box-header fixed">
                        <h3 class="box-title">
                            Edit Dokter
                        </h3>
                    </div>
                    <div class="box-body">
                        <ol class="breadcrumb">
                            <li class="active"><i class="fa fa-angle-double-right ">&nbsp;</i><a href="" onclick="javascript:self.close();"> Dokter</a></li>
                            <li class="active"> Edit Dokter</li>
                        </ol>
                        <form name="form2" action="<?php echo base_url();?>system/doctor/edit/<?php echo $doctor_id; ?>" method="post" enctype="multipart/form-data">
                        
                        <section class="content">
                            <div class="container-form">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <h3 class="" style="margin-bottom: 20px;"><strong>Edit Dokter</strong></h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <hr>
                                    <!-- ROW 1-->
                    <div class="col-md-6">
                        <div class="form-horizontal">
                            <div class="form-group">
                                    <label class="col-sm-5 control-label">Nama Dokter*</label>
                                <div class="col-sm-6">
                                        <input class="form-control" type="text" name="doctor_name" placeholder="Nama Dokter" id="doctor_name" value="<?=set_value('doctor_name', $doctor['doctor_name'])?> " >
                                        <?php echo form_error('doctor_name', '<font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-5 control-label">No. Telepon HP</label>
                                <div class="col-sm-6">
                                        <input class="form-control" type="text" name="mobile_number" placeholder="No. Telepon HP" id="mobile_number" value="<?=set_value('mobile_number', $doctor['mobile_number'])?>" >
                                        <?php echo form_error('mobile_number', '<font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                                </form>
                               
                            <div class="modal-footer">
                                <p class="text-center">
                                    <a href="#" onclick="javascript:self.close();" class="btn btn-danger"><i class="fa fa-remove">&nbsp;</i> Cancel</a>
                                    <a href="javascript:void(0);" onclick="javascript:document.form2.submit(); return false;" class="btn btn-primary"><i class="fa fa-save">&nbsp;</i> Save</a>
                                </p>
                            </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
</section>
<script src="<?php echo base_url() ?>js/intlTelInput.js"></script>
<script>
    $("#mobile_number").intlTelInput({
        defaultCountry: "id",
        nationalMode: false,
        numberType: "MOBILE",
        preferredCountries: ['id'],
        utilsScript: "<?php echo base_url() ?>lib/libphonenumber/build/utils.js"
    });
</script>