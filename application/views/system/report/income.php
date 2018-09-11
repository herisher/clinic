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
    <link href="<?php echo base_url() ?>css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>css/jquery-ui/jquery-ui.css" rel="stylesheet" type="text/css" />

    <script src="<?php echo base_url() ?>js/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo base_url() ?>js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>js/app.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>js/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>js/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>js/jquery-ui/jquery-ui.js" type="text/javascript"></script>

<style>
@media screen
{
    .noPrint{}
    .noScreen{display:none;}
}

@media print
{
    .noPrint{display:none;}
    .noScreen{}
}
</style>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-solid box-gold">
                    <div class="noPrint box-header fixed">
                        <h3 class="box-title">
                            Laporan Pendapatan Dokter
                        </h3>
                    </div>
                    
                    <div class="box-body">
                        <ol class="noPrint breadcrumb">
                            <li class="active"><i class="fa fa-angle-double-right ">&nbsp;</i><a href="" onclick="javascript:self.close();"> Laporan</a></li>
                            <li class="active"> Laporan Pendapatan Dokter</li>
                        </ol>
						<form action="/system/report/income" id="form2" method="POST" class="noPrint">
                        <div id="advance-search">
                            <div class="well">
                                <!--ROW 1-->
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label" >Tanggal Periksa (Awal)</label>
                                            <input class="form-control" onchange="this.form.submit()" type="text" name="transaction_date_from" placeholder="Tanggal Periksa Awal" id="transaction_date_from" value="<?php echo set_value('transaction_date_from', ''); ?>" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label" >Tanggal Periksa (Akhir)</label>
                                            <input class="form-control" onchange="this.form.submit()" type="text" name="transaction_date_to" placeholder="Tanggal Periksa Akhir " id="transaction_date_to" value="<?php echo set_value('transaction_date_to', ''); ?>" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label" >Dokter</label>
											<select id="doctor_id" onchange="this.form.submit()" class="form-control" type="text" name="doctor_id" value="<?php echo set_value("doctor_id",''); ?>">
												<option value="" <?php echo set_select("doctor_id",''); ?>>-Choose-</option>
												<?php foreach( $doctor_option as $key => $val ) : ?>
												<option value="<?= $key ?>" <?php echo set_select("doctor_id",$key); ?>><?= $val ?></option>
												<?php endforeach;?>
											</select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group pull-right" style="margin-top: 15px;">
                                                <input class="form-control" type="hidden" name="reset" id="reset" value="0" >
                                                <button type="button" name="resetBut" id="resetBut" class="btn btn-default "><i class="fa fa-angle-double-left"></i> Reset All Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p>
                            <button type="button" value="print" onclick="javascript:window.print();" class="btn btn-primary" target="_blank" ><i class="fa fa-print"></i> &nbsp; Print</button>
                        </p>
						</form>
                        <br>
                        <?php if ($this->session->flashdata('success_messageinsert') != ''): ?>
                            <div class="alert alert-success" role="alert">
                                <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                                <?php echo $this->session->flashdata('success_messageinsert'); ?>
                                <button class="close" data-dismiss="alert" type="button">×</button>
                            </div>
                        <?php endif; ?>
                        <?php if ($this->session->flashdata('success_messageedit') != ''): ?>
                            <div class="alert alert-success" role="alert">
                                <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
                                <?php echo $this->session->flashdata('success_messageedit'); ?>
                                <button class="close" data-dismiss="alert" type="button">×</button>
                            </div>
                        <?php endif; ?>
                        <?php if ($this->session->flashdata('success_messagedelete') != ''): ?>
                            <div class="alert alert-success" role="alert">
                                <span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span>
                                <?php echo $this->session->flashdata('success_messagedelete'); ?>
                                <button class="close" data-dismiss="alert" type="button">×</button>
                            </div>
                        <?php endif; ?>
						<div class="box-header">
							<h3 class="text-center">Laporan Pendapatan Dokter</h3>
						</div>
                            <table id="TEST" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal Periksa</th>
                                    <th>Dokter</th>
                                    <th>Total (Rp)</th>
                                </tr>
                                </thead>
                                <tbody>
									<?php 
										$i = 1;
										$total = 0;
										foreach($datas as $data) : ?>
									<tr>
										<td><?= $i++; ?></td>
										<td><?= $data["transaction_date"]; ?></td>
										<td><?= $data["doctor_name"]; ?></td>
										<td style='text-align:right'><?= number_format($data["biaya_medis"]); ?></td>
									</tr>
									<?php 
										$total += $data["biaya_medis"];
										endforeach; ?>
                                </tbody>
									<tr>
										<th colspan=3>Total (Rp)</th>
										<th style='text-align:right'><?= number_format($total); ?></th>
									</tr>
                            </table>
                    </div>
					
                                    <div class="noPrint modal-footer">
                                        <p class="text-center">
                                            <a href="#" onclick="javascript:self.close();" class="btn btn-danger"><i class="fa fa-remove">&nbsp;</i> Close</a>
                                        </p>
                                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<script>
    var dTable;
    $.fn.dataTable.ext.errMode = 'throw';
    $(document).ready(function() {
		dTable = $('#TEST').DataTable( {
			"scrollX":true,
			"destroy": true,
			"bJQueryUI": false,
			"responsive": true,
            "paginate":   false,
            "filter": false,
            "info":     false
		});
    });
    
    $("#resetBut").on("click", function(e){
        e.preventDefault();
        $('#reset').val(1);
        $('#form2').submit();
    });
</script>
<script>
    $('#transaction_date_from').datepicker({dateFormat: "yy-mm-dd",});
    $('#transaction_date_to').datepicker({dateFormat: "yy-mm-dd",});
</script>
