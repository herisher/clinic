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
                            Edit Pasien
                        </h3>
                    </div>
                    <div class="box-body">
                        <ol class="breadcrumb">
                            <li class="active"><i class="fa fa-angle-double-right ">&nbsp;</i><a href="" onclick="javascript:self.close();"> Pasien</a></li>
                            <li class="active"> Edit Pasien</li>
                        </ol>
                        <form name="form2" action="<?php echo base_url();?>system/patient/edit/<?php echo $patient_id; ?>" method="post" enctype="multipart/form-data">
                        
                        <section class="content">
                            <div class="container-form">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <h3 class="" style="margin-bottom: 20px;"><strong>Edit Pasien</strong></h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <hr>
                                    <!-- ROW 1-->
                    <div class="col-md-6">
                        <div class="form-horizontal">
                            <div class="form-group">
                                    <label class="col-sm-5 control-label">No. Rekam Medis*</label>
                                <div class="col-sm-6">
                                        <input class="form-control" type="text" name="anamnesis" placeholder="No. Rekam Medis" id="anamnesis" value="<?=set_value('anamnesis', $patient['anamnesis'])?> " >
                                        <?php echo form_error('anamnesis', '<font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-5 control-label">Nama Pasien*</label>
                                <div class="col-sm-6">
                                        <input class="form-control" type="text" name="patient_name" placeholder="Nama Pasien" id="patient_name" value="<?=set_value('patient_name', $patient['patient_name'])?> " >
                                        <?php echo form_error('patient_name', '<font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-5 control-label">Jenis Kelamin*</label>
                                <div class="col-sm-6">
                                    <select class="form-control" type="text" name="patient_sex" id="patient_sex">
                                        <option value="" <?php echo set_select("patient_sex",''); ?>>-Pilih-</option>
                                        <?php foreach( $sex_option as $key => $val ) : ?>
                                        <option value="<?= $key ?>" <?php echo set_select("patient_sex",$key, ($patient['patient_sex'] == $key)); ?>><?= $val ?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <?php echo form_error('patient_sex', '<font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-5 control-label">Tanggal Lahir</label>
                                <div class="col-sm-6">
                                        <input class="form-control" type="text" name="patient_dob" placeholder="Tanggal Lahir" id="patient_dob" value="<?=set_value('patient_dob', $patient['patient_dob'])?>" >
                                        <?php echo form_error('patient_dob', '<font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-5 control-label">Alamat</label>
                                <div class="col-sm-6">
                                        <textarea class="form-control" type="text" name="address" placeholder="Alamat" id="address"><?=set_value('address', $patient['address'])?></textarea>
                                        <?php echo form_error('address', '<font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-5 control-label">No. Telepon</label>
                                <div class="col-sm-6">
                                        <input class="form-control" type="text" name="phone_number" placeholder="No. Telepon" id="phone_number" value="<?=set_value('phone_number', $patient['phone_number'])?>" >
                                        <?php echo form_error('phone_number', '<font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-5 control-label">No. Telepon HP</label>
                                <div class="col-sm-6">
                                        <input class="form-control" type="text" name="mobile_number" placeholder="No. Telepon HP" id="mobile_number" value="<?=set_value('mobile_number', $patient['mobile_number'])?>" >
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