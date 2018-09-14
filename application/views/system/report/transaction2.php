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
                            Laporan Transaksi Detail
                        </h3>
                    </div>
                    
                    <div class="box-body">
                        <ol class="noPrint breadcrumb">
                            <li class="active"><i class="fa fa-angle-double-right ">&nbsp;</i><a href="" onclick="javascript:self.close();"> Laporan</a></li>
                            <li class="active"> Laporan Transaksi Detail</li>
                        </ol>
						
						<form action="/system/report/transactiondetail/<?= $type; ?>/<?= $transaction_date; ?>" id="form2" method="POST" class="noPrint">
                        <p class="noPrint">
                            <!--button type="button" value="print" onclick="javascript:window.print();" class="btn btn-primary" target="_blank" ><i class="fa fa-print"></i> &nbsp Print</button-->
                            <input class="form-control" type="hidden" name="csv" id="csv" value="0" >
                            <button type="button" value="print" name="csvBut" id="csvBut" class="btn btn-primary" ><i class="fa fa-file"></i> &nbsp; Export to CSV</button>
                        </p>
                        </form>
						
                        <section class="content">
                            <div class="container-form">
                                <div class="row">
				<hr>
                <!-- ROW 2-->
                <div class="row">
					<div class="box" style="border-top: none;">
						<div class="box-header">
							<h3 class="text-center">Laporan Transaksi <?= $filter; ?></h3>
						</div>
						<div class="box-body">
							<span class="show_err_msg"></span>
							<table id="TEST" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>No.</th>
										<th>No. Transaksi</th>
                                        <th>Tanggal Periksa</th>
                                        <th>Status Pembayaran</th>
										<th>Total (Rp)</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$i = 1;
										$total_idr = 0;
										foreach($transaction_detail as $sd) : ?>
									<tr>
										<td><?= $i++; ?></td>
										<td><?= $sd["transaction_no"]; ?></td>
										<td><?= $sd["transaction_date"]; ?></td>
										<td><?= $sd["disp_status"]; ?></td>
										<td><?= number_format($sd["total_biaya"]); ?></td>
									</tr>
									<?php 
										$total_idr += $sd["total_biaya"];
										endforeach; ?>
								</tbody>
									<tr>
										<th colspan=4> Total : </th>
										<th><?= $total_idr ? number_format($total_idr) : '-'?></th>
									</tr>
							</table>
						</div>
					</div>
				</div>
                                    <div class="noPrint modal-footer">
                                        <p class="text-center">
                                            <a href="#" onclick="javascript:window.history.back();" class="btn btn-danger"><i class="fa fa-caret-square-o-left">&nbsp;</i> Back</a>
                                            <a href="#" onclick="javascript:self.close();" class="btn btn-danger"><i class="fa fa-remove">&nbsp;</i> Close</a>
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
    
    $("#csvBut").on("click", function(e){
        e.preventDefault();
        $('#csv').val(1);
        $('#form2').submit();
    });
</script>