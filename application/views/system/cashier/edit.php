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
                            Edit Status Pembayaran
                        </h3>
                    </div>
                    <div class="box-body">
                        <ol class="breadcrumb">
                            <li class="active"><i class="fa fa-angle-double-right ">&nbsp;</i><a href="" onclick="javascript:self.close();"> Cashier</a></li>
                            <li class="active"> Edit Status Pembayaran</li>
                        </ol>
                        <form name="form2" action="<?php echo base_url();?>system/cashier/edit/<?php echo $transaction_id; ?>" method="post" enctype="multipart/form-data">
                        
                        <section class="content">
                            <div class="container-form">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <h3 class="" style="margin-bottom: 20px;"><strong>Edit Status Pembayaran</strong></h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <hr>
                                    <!-- ROW 1-->
                <h4 style="margin-bottom: 10px;"><strong>Data Pasien</strong></h4>
                <div class="row" style="margin-bottom: 25px;">
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
                                    <h4 style="margin-bottom: 10px;"><strong>Data Transaksi</strong></h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">Biaya Admin (Rp)</label>
                                                    <div class="col-sm-6">
                                                        <h5> <?= $cashier['biaya_admin'] ? number_format($cashier['biaya_admin']) : '-'?> </h5>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">Biaya Periksa (Rp)</label>
                                                    <div class="col-sm-6">
                                                        <h5> <?= $cashier['biaya_medis'] ? number_format($cashier['biaya_medis']) : '-'?> </h5>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">Biaya Obat (Rp)</label>
                                                    <div class="col-sm-6">
                                                        <h5> <?= $cashier['biaya_obat'] ? number_format($cashier['biaya_obat']) : '-'?> </h5>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">Total Biaya (Rp)</label>
                                                    <div class="col-sm-6">
                                                        <h5> <?= $cashier['total_biaya'] ? number_format($cashier['total_biaya']) : '-'?> </h5>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                        <label class="col-sm-5 control-label">Jumlah Uang</label>
                                                    <div class="col-sm-6">
                                                        <input class="form-control" type="number" oninput="change_kembalian();" name="jumlah_uang" placeholder="Jumlah Uang" id="jumlah_uang" value="<?php echo set_value('jumlah_uang', $cashier['jumlah_uang']); ?>">
                                                        <?php echo form_error('jumlah_uang', '<font color="#FF0000">', '</font>'); ?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                        <label class="col-sm-5 control-label">Kembalian</label>
                                                    <div class="col-sm-6">
                                                        <input class="form-control" type="number" name="kembalian" readonly="readonly" placeholder="Kembalian" id="kembalian" value="<?php echo set_value('kembalian', $cashier['kembalian']); ?>">
                                                        <input class="form-control" type="hidden" name="total_biaya" readonly="readonly" id="total_biaya" value="<?php echo set_value('total_biaya', $cashier['total_biaya']); ?>">
                                                        <?php echo form_error('kembalian', '<font color="#FF0000">', '</font>'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">No. Transaksi</label>
                                                    <div class="col-sm-6">
                                    <input class="form-control" type="hidden" name="transaction_id" id="transaction_id" value="<?php echo set_value('transaction_id', $cashier['transaction_id']); ?>">
                                                        <h5><?= $cashier['transaction_no'] ? $cashier['transaction_no'] : '-'?></h5>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">Tanggal Periksa</label>
                                                    <div class="col-sm-6">
                                                        <h5><?= $cashier['transaction_date'] ? $cashier['transaction_date'] : '-'?></h5>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">Dokter Pemeriksa</label>
                                                    <div class="col-sm-6">
                                                        <h5><?= $doctor['doctor_name'] ? $doctor['doctor_name'] : '-'?></h5>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-5 control-label">Status Pembayaran</label>
                                                    <div class="col-sm-6">
                                                        <select class="form-control" type="text" name="payment_status" id="payment_status">
                                                            <option value="" <?php echo set_select("payment_status",''); ?>>-Pilih-</option>
                                                            <?php foreach( $status_option as $key => $val ) : ?>
                                                            <option value="<?= $key ?>" <?php echo set_select("payment_status",$key,($cashier['payment_status'] == $key)); ?>><?= $val ?></option>
                                                            <?php endforeach;?>
                                                        </select>
                                                        <?php echo form_error('payment_status', '<font color="#FF0000">', '</font>'); ?>
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
<script>
    function change_kembalian(){
        var jumlah_uang = parseInt($('#jumlah_uang').val());
        var total = parseInt($('#total_biaya').val());
        
        if(jumlah_uang){
            var kembalian = parseInt(jumlah_uang - total);
            $('#kembalian').val(kembalian);
        } else {
            $('#kembalian').val(0);
        }
    }
</script>