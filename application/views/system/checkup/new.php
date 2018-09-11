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
    <link href="<?php echo base_url() ?>css/select2.min.css" media="all" rel="stylesheet" type="text/css" />
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
    <script src="<?php echo base_url() ?>js/select2.min.js" type="text/javascript"></script>
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
                        New Pemeriksaan
                    </h3>
                </div>
                <div class="box-body">
                    <ol class="breadcrumb">
                        <li class="active"><i class="fa fa-angle-double-right ">&nbsp;</i><a href="" onclick="javascript:self.close();"> Pemeriksaan</a></li>
                        <li class="active"> New Pemeriksaan</li>
                    </ol>
            <form name="form2" action="<?php echo base_url();?>system/checkup/new" method="post" enctype="multipart/form-data">
            
            <section class="content">
                <div class="container-form">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h3 class="" style="margin-bottom: 20px;"><strong>Pemeriksaan Pasien</strong></h3>
                        </div>
                    </div>
                    <div class="row">
                    <hr>
                <!-- ROW 1-->
                <h4 style="margin-bottom: 10px;"><strong>Data Pasien</strong></h4>
                <div class="row" style="margin-bottom: 25px;">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-10">
                        <div class="form-inline">
                            <div class="form-group">
                                <label class="col-sm-6 control-label">Cari Pasien</label>
                                <div class="col-sm-6">
                                    <select class="form-control" type="text" name="patient_id" id="patient_id" >
                                        <option value="" <?php echo set_select("patient_id",''); ?>>-Pilih-</option>
                                        <?php foreach( $patient_option as $key => $val ) : ?>
                                        <option value="<?= $key ?>" <?php echo set_select("patient_id",$key); ?>><?= $val ?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <button type="button" class="btn btn-default btnAdd">Pilih</button>&nbsp;&nbsp;&nbsp;atau&nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-default btnNew">Buat Baru</button>
                        </div>
                    </div>
                </div>
                <!-- ROW 2-->
                <div class="row" id="data_pasien">
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
                                    <input class="form-control" type="text" name="patient_name" placeholder="Nama Pemeriksaan" id="patient_name" value="<?php echo set_value('patient_name', ''); ?>" >
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
                            <div class="form-group clsDob">
                                    <label class="col-sm-5 control-label">Tanggal Lahir*</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="patient_dob" placeholder="Tanggal Lahir" id="patient_dob" value="<?php echo set_value('patient_dob', ''); ?>">
                                    <?php echo form_error('patient_dob', '<br><font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                            <div class="form-group clsAges">
                                    <label class="col-sm-5 control-label">Usia</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="patient_ages" placeholder="Tanggal Lahir" id="patient_ages" value="<?php echo set_value('patient_ages', ''); ?>">
                                    <?php echo form_error('patient_ages', '<br><font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-5 control-label">No. Telepon</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="phone_number" placeholder="No. Telepon" id="phone_number" value="<?php echo set_value('phone_number', ''); ?>" >
                                    <?php echo form_error('phone_number', '<font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-5 control-label">No. Telepon HP</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="mobile_number" placeholder="No. Telepon HP" id="mobile_number" value="<?php echo set_value('mobile_number', ''); ?>" >
                                    <?php echo form_error('mobile_number', '<font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Alamat</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" type="text" name="address" placeholder="Alamat" id="address"><?php echo set_value('address', ''); ?></textarea>
                                    <?php echo form_error('address', '<font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <!-- ROW 3-->
                <h4 style="margin-bottom: 10px;"><strong>Data Pemeriksaan</strong></h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Keluhan*</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" type="text" name="keluhan" placeholder="Keluhan" id="keluhan"><?php echo set_value('keluhan', ''); ?></textarea>
                                    <?php echo form_error('keluhan', '<font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-5 control-label">Diagnosa*</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" type="text" name="diagnosa" placeholder="Diagnosa" id="diagnosa"><?php echo set_value('diagnosa', ''); ?></textarea>
                                    <?php echo form_error('diagnosa', '<font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-5 control-label">Tindakan / Pengobatan*</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" type="text" name="tindakan" placeholder="Tindakan / Pengobatan" id="tindakan"><?php echo set_value('tindakan', ''); ?></textarea>
                                    <?php echo form_error('tindakan', '<font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-5 control-label">Layanan Tambahan</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" type="text" name="layanan_tambahan" placeholder="Layanan Tambahan" id="layanan_tambahan"><?php echo set_value('layanan_tambahan', ''); ?></textarea>
                                    <?php echo form_error('layanan_tambahan', '<br><font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-5 control-label">Keterangan Tambahan</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" type="text" name="keterangan" placeholder="Keterangan Tambahan" id="keterangan"><?php echo set_value('keterangan', ''); ?></textarea>
                                    <?php echo form_error('keterangan', '<br><font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-horizontal">
                            <div class="form-group">
                                    <label class="col-sm-5 control-label">Alergi Obat</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" type="text" name="alergi_obat" placeholder="Alergi Obat" id="alergi_obat"><?php echo set_value('alergi_obat', ''); ?></textarea>
                                    <?php echo form_error('alergi_obat', '<br><font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-5 control-label">Tanggal Periksa</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text" name="transaction_date" placeholder="Tanggal Periksa" id="transaction_date" value="<?php echo set_value('transaction_date', ''); ?>">
                                    <?php echo form_error('transaction_date', '<br><font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-5 control-label">Dokter Pemeriksa*</label>
                                <div class="col-sm-6">
                                    <select class="form-control" type="text" name="doctor_id" id="doctor_id" <?php if($doctor_id) echo 'readonly="readonly"'; ?>>
                                        <option value="" <?php echo set_select("doctor_id",''); ?>>-Pilih-</option>
                                        <?php foreach( $doctor_option as $key => $val ) : ?>
                                        <option value="<?= $key ?>" <?php echo set_select("doctor_id",$key, ($doctor_id == $key)); ?>><?= $val ?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <?php echo form_error('doctor_id', '<font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-5 control-label">Biaya Periksa*</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="number" name="biaya_medis" placeholder="Biaya Periksa" id="biaya_medis" value="<?php echo set_value('biaya_medis', ''); ?>">
                                    <?php echo form_error('biaya_medis', '<font color="#FF0000">', '</font>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-5 control-label">Dokumen Penunjang</label>
                                <div class="col-sm-6">
                                    <input id="document_fileid" name="document_fileid" type="file" multiple=false>
                                    <?php if(isset($data['document_fileid'])): ?>
                                    <div id="view" class="collapse">
                                        <img src="<?php echo base_url();?>upload/doc/<?= $data['document_fileid']?>" alt="Smiley face" height="100%" width="100%">
                                        <h5><?= $data['document_fileid']?></h5>
                                    </div>
                                    <a class="btn btn-primary" data-toggle="collapse" data-target="#view" aria-expanded="false" ><i class="fa fa-search-plus"></i>View</a>
                                    <?php endif; ?>
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
<script>
    $("#document_fileid").fileinput();
</script>
<script>
    $("#patient_id").select2({
        width: 'resolve', // need to override the changed default
    });
</script>
<script>
    $(function () {
        $("#data_pasien").hide();
        var patient_id = $("#patient_id").val();
        if( patient_id ) {
            $("#data_pasien").show();
        }
        
        $(".btnAdd").click(function(){
            console.log("btnAdd clicked");
            var patient_id = $("#patient_id").val();
            $.ajax({ url: "/system/checkup/ajax-get-patient",
                data: {"patient_id":patient_id},
                dataType: 'json',
                type: 'post',
                success: function(output) {
                    console.log(output);
                    $("#data_pasien").show();
                    $(".clsDob").hide();
                    $(".clsAges").show();
                    $("#anamnesis").attr('readonly', 'readonly').val(output.anamnesis);
                    $("#patient_name").attr('readonly', 'readonly').val(output.patient_name);
                    $("#patient_sex").attr('readonly', 'readonly').val(output.patient_sex);
                    $("#patient_dob").val(output.patient_dob);
                    $("#patient_ages").attr('readonly', 'readonly').val(output.patient_ages);
                    $("#phone_number").attr('readonly', 'readonly').val(output.phone_number);
                    $("#mobile_number").attr('readonly', 'readonly').val(output.mobile_number);
                    $("#address").attr('readonly', 'readonly').val(output.address);
                }
            });
        });
        $(".btnNew").click(function(){
            $("#data_pasien").show();
            $(".clsDob").show();
            $(".clsAges").hide();
            $("#patient_id").removeAttr("readonly").val('');
            $("#anamnesis").removeAttr("readonly").val('');
            $("#patient_name").removeAttr("readonly").val('');
            $("#patient_sex").removeAttr("readonly").val('');
            $("#patient_dob").removeAttr("readonly").val('');
            $("#phone_number").removeAttr("readonly").val('');
            $("#mobile_number").removeAttr("readonly").val('');
            $("#address").removeAttr("readonly").val('');
        });
    });
</script>
<script>
var d = new Date();
   var currDay = d.getDate();
   var currMonth = d.getMonth();
   var currYear = d.getFullYear();
   var startDate = new Date(currYear, currMonth, currDay);

    $('#transaction_date').datepicker({dateFormat: "yy-mm-dd",});
    $('#transaction_date').datepicker("setDate", startDate);
</script>
