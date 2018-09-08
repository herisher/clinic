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

    <script src="<?php echo base_url() ?>js/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo base_url() ?>js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>js/app.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>js/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>js/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

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
                            Laporan Transaksi
                        </h3>
                    </div>
                    
                    <div class="box-body">
                        <ol class="noPrint breadcrumb">
                            <li class="active"><i class="fa fa-angle-double-right ">&nbsp;</i><a href="" onclick="javascript:self.close();"> Laporan</a></li>
                            <li class="active"> Laporan Transaksi</li>
                        </ol>
						<form action="/system/report/transaction" method="GET" class="noPrint">
                        <div id="advance-search">
                            <div class="well">
                                <!--ROW 1-->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" >Filter</label>
											<select id="filter_by" onchange="this.form.submit()" class="form-control" type="text" name="filter_by" value="<?php echo set_value("filter_by",''); ?>">
												<option value="" <?php echo set_select("filter_by",''); ?>>-Choose-</option>
												<option value="daily" <?php echo set_select("filter_by", "daily"); ?>>Daily</option>
												<option value="weekly" <?php echo set_select("filter_by", "weekly"); ?>>Weekly</option>
												<option value="monthly" <?php echo set_select("filter_by", "monthly"); ?>>Monthly</option>
												<option value="yearly" <?php echo set_select("filter_by", "yearly"); ?>>Yearly</option>
											</select>
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
							<h3 class="text-center">Laporan Transaksi <?= $filter; ?></h3>
						</div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jumlah Pasien</th>
                                    <th>Total (Rp)</th>
                                    <th class="noPrint">Detail</th>
                                </tr>
                                </thead>
                                <tbody>
									<?php 
										$qty_total = 0;
										$idr_total = 0;
										foreach($datas as $data) : ?>
									<tr>
										<td><?= $data["transaction_date"]; ?></td>
										<td style='text-align:right'><?= number_format($data["qty"]); ?></td>
										<td style='text-align:right'><?= number_format($data["total_idr"]); ?></td>
										<td class="noPrint"><button type="button" onclick="location.href = '/system/report/transactiondetail/<?= $filter . "/" . $data["transaction_date"];?>';" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-zoom-in"></span></button></td>
									</tr>
									<?php 
										$qty_total += $data["qty"];
										$idr_total += $data["total_idr"];
										endforeach; ?>
                                </tbody>
									<tr>
										<th>Total</th>
										<th style='text-align:right'><?= number_format($qty_total,2); ?></th>
										<th style='text-align:right'><?= number_format($idr_total); ?></th>
										<th class="noPrint"></th>
									</tr>
                            </table>
                        </div>
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