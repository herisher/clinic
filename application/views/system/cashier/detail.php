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

    <script src="<?php echo base_url() ?>js/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo base_url() ?>js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>js/app.js" type="text/javascript"></script>
    <script type= "text/javascript" src = "<?php echo base_url() ?>js/countries.js"></script>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-solid box-gold">
                    <div class="box-header fixed">
                        <h3 class="box-title">
                            Detail Pasien
                        </h3>
                    </div>
                    
                    <div class="box-body">
                        <ol class="breadcrumb">
                            <li class="active"><i class="fa fa-angle-double-right ">&nbsp;</i><a href="" onclick="javascript:self.close();"> Pasien</a></li>
                            <li class="active"> Detail Pasien</li>
                        </ol>
                        <section class="content">
                            <div class="container-form">
                                <div class="row">
                                    <hr>
                                    <!--ROW 1-->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">No. Rekam Medis</label>
                                                    <div class="col-sm-6">
                                                        <h5><?= $patient['anamnesis'] ? $patient['anamnesis'] : '-'?></h5>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">Nama Pasien</label>
                                                    <div class="col-sm-6">
                                                        <h5><?= $patient['patient_name'] ? $patient['patient_name'] : '-'?></h5>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">Jenis Kelamin</label>
                                                    <div class="col-sm-6">
                                                        <h5><?= $patient['disp_sex'] ? $patient['disp_sex'] : '-'?></h5>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">Tanggal Lahir</label>
                                                    <div class="col-sm-6">
                                                        <h5><?= $patient['patient_dob'] ? $patient['patient_dob'] . " (". $patient["ages"] ." Tahun)" : '-'?></h5>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">Alamat</label>
                                                    <div class="col-sm-6">
                                                        <h5> <?= $patient['address'] ? $patient['address'] : '-'?> </h5>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">No. Telepon</label>
                                                    <div class="col-sm-6">
                                                        <h5> <?= $patient['phone_number'] ? $patient['phone_number'] : '-'?> </h5>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">No. Telepon HP</label>
                                                    <div class="col-sm-6">
                                                        <h5> <?= $patient['mobile_number'] ? $patient['mobile_number'] : '-'?> </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <p class="text-center">
                                            <a href="#" onclick="javascript:self.close();" class="btn btn-danger"><i class="fa fa-remove">&nbsp;</i> Close</a>
                                            <a href="<?php echo base_url();?>system/patient/edit/<?php echo $patient['patient_id']?>" class="btn btn-primary" onclick="window.open('<?php echo base_url();?>system/patient/edit/<?php echo $patient['patient_id']?>', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;" id="<?= $patient['patient_id']?>"><i class="fa fa-pencil">&nbsp;</i> Edit</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>