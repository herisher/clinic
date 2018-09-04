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
    <script src="<?php echo base_url() ?>js/jquery.maskedinput.js" type="text/javascript"></script>

    <script src="<?php echo base_url() ?>jquery-ui.min.js"></script>
    <script src="<?php echo base_url() ?>jquery.select-to-autocomplete.js"></script>


    <script src="<?php echo base_url() ?>dist/jquery.validate.js"></script>

    
    <script src="<?php echo base_url() ?>js/fileinput.js" type="text/javascript"></script>
<script>
      (function($){
        $(function(){
          $('form').submit(function(){
            alert( $(this).serialize() );
            return false;
          });
        });
      })(jQuery);
    </script>
 <script type="text/javascript">
        <?php if( isset($next) && $next ) : ?>
        window.opener.document.location.reload();
        self.close();
        <?php endif; ?>
    </script>
</head>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-solid box-gold">
                <div class="box-header fixed">
                    <h3 class="box-title">
                        New Pasien
                    </h3>
                </div>
                <div class="box-body">
                    <ol class="breadcrumb">
                        <li class="active"><i class="fa fa-angle-double-right ">&nbsp;</i><a href="" onclick="javascript:self.close();"> Pasien</a></li>
                        <li class="active"> New Pasien</li>
                    </ol>
            <form name="form2" action="<?php echo base_url();?>system/patient/new" method="post" enctype="multipart/form-data">
            
            <section class="content">
                <div class="container-form">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3 class="" style="margin-bottom: 20px;"><strong>New Pasien </strong></h3>
                        </div>
                    </div>
                    <div class="row">
                    <hr>
                <!-- ROW 1-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-5 control-label">No. Rekam Medis*</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="anamnesis" placeholder="No. Rekam Medis" id="anamnesis" value="<?php echo set_value('anamnesis', ''); ?>" >
                                    <?php echo form_error('anamnesis', '<font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Nama Pasien*</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="patient_name" placeholder="Nama Pasien" id="patient_name" value="<?php echo set_value('patient_name', ''); ?>" >
                                    <?php echo form_error('patient_name', '<font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-5 control-label">Jenis Kelamin*</label>
                                <div class="col-sm-6">
                                    <select class="form-control" type="text" name="patient_sex" id="patient_sex">
                                        <option value="" <?php echo set_select("patient_sex",''); ?>>-Pilih-</option>
                                        <?php foreach( $sex_option as $key => $val ) : ?>
                                        <option value="<?= $key ?>" <?php echo set_select("patient_sex",$key); ?>><?= $val ?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <?php echo form_error('patient_sex', '<font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-5 control-label">Tanggal Lahir</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="patient_dob" placeholder="Tanggal Lahir" id="patient_dob" value="<?php echo set_value('patient_dob', ''); ?>">
                                    <?php echo form_error('patient_dob', '<br><font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-5 control-label">Alamat*</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" type="text" name="address" placeholder="Alamat" id="address"><?php echo set_value('address', ''); ?></textarea>
                                    <?php echo form_error('address', '<br><font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-5 control-label">No. Telepon</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="phone_number" placeholder="No. Telepon" id="phone_number" value="<?php echo set_value('phone_number', ''); ?>">
                                    <?php echo form_error('phone_number', '<br><font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-5 control-label">No. Telepon HP</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="mobile_number" placeholder="No. Telepon HP" id="mobile_number" value="<?php echo set_value('mobile_number', ''); ?>">
                                    <?php echo form_error('mobile_number', '<br><font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                                    <div class="modal-footer">
                                        <p class="text-center">
                                            <a href="#" onclick="javascript:self.close();" class="btn btn-danger"><i class="fa fa-remove">&nbsp;</i> Cancel</a>
                                            <a href="javascript:void(0);" onclick="javascript:document.form2.submit(); return false;" class="btn btn-primary"><i class="fa fa-check-circle-o">&nbsp;</i>Submit</a>
                                        </p>
                                    </div>

                                </div>
                        </div>
                    </section>
                </form>
                </div> 
            </div>
        </div>
    </div>
</section>

<script language="javascript" type="text/javascript"> 
function windowClose() { 
    window.open('','_parent',''); 
    window.close();
}
</script>

<script src="<?php echo base_url() ?>js/intlTelInput.js"></script>
<script>
  $("#phone_number").intlTelInput({
    defaultCountry: "id",
    nationalMode: false,
    numberType: "MOBILE",
    preferredCountries: ['id'],
    utilsScript: "<?php echo base_url() ?>lib/libphonenumber/build/utils.js"
  });
  $("#mobile_number").intlTelInput({
    defaultCountry: "id",
    nationalMode: false,
    numberType: "MOBILE",
    preferredCountries: ['id'],
    utilsScript: "<?php echo base_url() ?>lib/libphonenumber/build/utils.js"
  });
</script>
<script>
    $('#patient_dob').datepicker({dateFormat: "yy-mm-dd",});
</script>
