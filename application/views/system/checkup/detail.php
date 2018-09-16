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
                            Detail Pemeriksaan
                        </h3>
                    </div>
                    
                    <div class="box-body">
                        <ol class="breadcrumb">
                            <li class="active"><i class="fa fa-angle-double-right ">&nbsp;</i><a href="" onclick="javascript:self.close();"> Pemeriksaan</a></li>
                            <li class="active"> Detail Pemeriksaan</li>
                        </ol>
                        <section class="content">
                            <div class="container-form">
                                <div class="row">
                                    <hr>
                                    <!--ROW 1-->
                                    <h4 style="margin-bottom: 10px;"><strong>Data Pasien</strong></h4>
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
                                                        <h5><?= $patient['patient_dob'] ? $patient['patient_dob'] . " (". $patient["ages"].")" : '-'?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-horizontal">
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
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">Alamat</label>
                                                    <div class="col-sm-6">
                                                        <h5> <?= $patient['address'] ? $patient['address'] : '-'?> </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <!--ROW 1-->
                                    <h4 style="margin-bottom: 10px;"><strong>Data Pemeriksaan</strong></h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">Keluhan</label>
                                                    <div class="col-sm-6">
                                                        <h5><?= $checkup['keluhan'] ? $checkup['keluhan'] : '-'?></h5>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">Diagnosa</label>
                                                    <div class="col-sm-6">
                                                        <h5><?= $checkup['diagnosa'] ? $checkup['diagnosa'] : '-'?></h5>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">Tindakan / Pengobatan</label>
                                                    <div class="col-sm-6">
                                                        <h5><?= $checkup['tindakan'] ? $checkup['tindakan'] : '-'?></h5>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">Layanan Tambahan</label>
                                                    <div class="col-sm-6">
                                                        <h5><?= $checkup['layanan_tambahan'] ? $checkup['layanan_tambahan'] : '-'?></h5>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">Keterangan Tambahan</label>
                                                    <div class="col-sm-6">
                                                        <h5> <?= $checkup['keterangan'] ? $checkup['keterangan'] : '-'?> </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">Alergi Obat</label>
                                                    <div class="col-sm-6">
                                                        <h5> <?= $checkup['alergi_obat'] ? $checkup['alergi_obat'] : '-'?> </h5>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">Resep Obat</label>
                                                    <div class="col-sm-6">
                                                        <h5> <?= $checkup['resep'] ? $checkup['resep'] : '-'?> </h5>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">Tanggal Periksa</label>
                                                    <div class="col-sm-6">
                                                        <h5> <?= $checkup['transaction_date'] ? $checkup['transaction_date'] : '-'?> </h5>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">Dokter Pemeriksa</label>
                                                    <div class="col-sm-6">
                                                        <h5> <?= $doctor['doctor_name'] ? $doctor['doctor_name'] : '-'?> </h5>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">Biaya Periksa (Rp)</label>
                                                    <div class="col-sm-6">
                                                        <h5> <?= $checkup['biaya_medis'] ? number_format($checkup['biaya_medis']) : '-'?> </h5>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">Dokumen Penunjang</label>
                                                    <div class="col-sm-6">
                                                        <?php 
                                                            $mime = array("jpg","jpeg","png","gif","bmp");
                                                        if( strpos(strtolower($checkup['document_fileid']), "jpg") ||
                                                            strpos(strtolower($checkup['document_fileid']), "jpeg") || 
                                                            strpos(strtolower($checkup['document_fileid']), "png") ||
                                                            strpos(strtolower($checkup['document_fileid']), "gif") ||
                                                            strpos(strtolower($checkup['document_fileid']), "bmp")) : ?>
                                                        <?php if($checkup['document_fileid']): ?>

                                                    <div id="view" class="collapse">
                                                        <img src="<?php echo base_url();?>upload/docs/<?= $checkup['document_fileid']?>" alt="Dokumen Penunjang" height="100%" width="100%">
                                                    </div>
                                                    <a class="btn btn-primary" data-toggle="collapse" data-target="#view" aria-expanded="false" ><i class="fa fa-search-plus"></i>View</a>
                                                    <?php else: ?><?php endif; ?>
                                                        <?php else : ?>
                                                        <a href="<?= base_url(); ?>upload/docs/<?= $checkup['document_fileid']?>" target="_blank"><h5><?= $checkup['document_fileid']?></h5></a>
                                                        <?php endif;?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <p class="text-center">
                                            <a href="#" onclick="javascript:self.close();" class="btn btn-danger"><i class="fa fa-remove">&nbsp;</i> Close</a>
                                            <!--a href="<?php echo base_url();?>system/patient/edit/<?php echo $patient['patient_id']?>" class="btn btn-primary" onclick="window.open('<?php echo base_url();?>system/patient/edit/<?php echo $patient['patient_id']?>', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;" id="<?= $patient['patient_id']?>"><i class="fa fa-pencil">&nbsp;</i> Edit</a-->
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