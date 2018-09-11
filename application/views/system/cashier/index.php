<?php require_once APPPATH.'views/system/header.php'; ?>
<?php require_once APPPATH.'views/system/sidebar.php'; ?>

<script src="<?php echo base_url() ?>js/jquery-ui/jquery-ui.js" type="text/javascript"></script>
<link href="<?php echo base_url() ?>css/jquery-ui/jquery-ui.css" rel="stylesheet" type="text/css" />

<aside class="right-side">
    <section class="content-header">
        <h1>
            <i class="fa fa-money">&nbsp;</i>  Kasir
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-gold">
                    <div class="box-body">
                        <ol class="breadcrumb ">
                            <li> <i class="fa fa-money">&nbsp;</i> Kasir</a></li>
                        </ol>
						<form action="/system/cashier/csv" method="POST">
                        <div id="advance-search" class="collapse">
                            <div class="well">
                                <!--ROW 1-->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Tanggal Periksa</label>
                                            <input id="transaction_date" class="form-control " type="text" placeholder="Tanggal Periksa" value="" name="transaction_date" data-column="1"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">No. Transaksi</label>
                                            <input id="transaction_no" class="form-control " type="text" placeholder="No. Transaksi" value="" name="transaction_no" data-column="2"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Status Pembayaran</label>
                                            <select class="form-control" type="text" data-column="7" name="payment_status" id="payment_status">
                                                <option value="">-Pilih-</option>
                                                <?php foreach( $status_option as $key => $val ) : ?>
                                                <option value="<?= $key ?>"><?= $val ?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--ROW 2-->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">No. Rekam Medis</label>
                                            <input id="anamnesis" class="form-control " type="text" placeholder="No. Rekam Medis" value="" name="anamnesis" data-column="3"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" >Nama Pasien</label>
                                            <input id="cashier_name" class="form-control" type="text" placeholder="Nama Pasien" value="" name="cashier_name" data-column="4"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" >Tanggal Lahir</label>
                                            <input id="patient_dob" class="form-control" type="text" placeholder="Tanggal Lahir" value="" name="patient_dob" data-column="5"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="input-group pull-right" style="margin-top: 15px;">
                                                <button type="reset" id="reset" class="btn btn-default "><i class="fa fa-angle-double-left"></i> Reset All Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p>
                            <a class="btn btn-primary" id="btn-advsearch" data-toggle="collapse" data-target="#advance-search" aria-expanded="false" ><i class="fa fa-search-plus"></i> &nbsp; Advance Search </a>
                            <!--button type="submit" value="submit" class="btn btn-primary" target="_blank" ><i class="fa fa-download"></i> &nbsp; Download CSV</button-->
                            <button type="button" href="<?php echo base_url();?>system/cashier/new" class="btn btn-primary pull-right" onclick="window.open('<?php echo base_url();?>system/cashier/new', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;"><i class="fa fa-file"></i> &nbsp; New Transaksi</button>
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
                            <table id="index_table"  class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="col-sm-1">No</th>
                                    <th>Tanggal Periksa</th>
                                    <th>No. Transaksi</th>
                                    <th>No. Rekam Medis</th>
                                    <th>Nama Pasien</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Total Biaya (Rp)</th>
                                    <th class="col-sm-1">Status Pembayaran</th>
                                    <th class="col-sm-1">Edit Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="control-sidebar-bg"></div>
</aside>

<script>
    $('#transaction_date').datepicker({dateFormat: "yy-mm-dd",});
    $('#patient_dob').datepicker({dateFormat: "yy-mm-dd",});
</script>

<script>
    var dTable;
    //$.fn.dataTable.ext.errMode = 'throw';
    $(document).ready(function() {
		
    dTable = $('#index_table').DataTable( {
        "scrollX":true,
        "scrollY": "300",
		"destroy": true,
        "bProcessing": true,
        "bServerSide": true,
        "bJQueryUI": false,
        "responsive": true,
        "sAjaxSource": "<?php echo base_url() . "system/cashier/ajax_get_cashier_list/"; ?>", // Load Data
        "sServerMethod": "POST",
        "columnDefs": [
            { "orderable": true, "targets": 0, "searchable": true }, //No
            { "orderable": true, "targets": 1, "searchable": true }, //Transaction Date
            { "orderable": true, "targets": 2, "searchable": true }, //Transaction No.
            { "orderable": true, "targets": 3, "searchable": true }, //Anamnesis
            { "orderable": true, "targets": 4, "searchable": true }, //Name
			{ "orderable": true, "targets": 5, "searchable": true }, //DOB
			{ "orderable": false, "targets": 6, "searchable": false }, //total
            { "orderable": true, "targets": 7, "searchable": true }, //payment status
			{ "orderable": false, "targets": 8, "searchable": false }, //edit
        ],
			"order": [[ 0, "desc" ]]
    });
	
	//Search form
	$('#transaction_date').on( 'keyup', function () {
    dTable
        .columns( 1 )
        .search( this.value )
        .draw();
	} );
	$('#transaction_no').on( 'keyup', function () {
    dTable
        .columns( 2 )
        .search( this.value )
        .draw();
	} );
	$('#payment_status').on( 'change', function () {
    dTable
        .columns( 7 )
        .search( this.value )
        .draw();
	} );
	$('#anamnesis').on( 'keyup', function () {
    dTable
        .columns( 3 )
        .search( this.value )
        .draw();
	} );
	$('#patient_name').on( 'keyup', function () {
    dTable
        .columns( 4 )
        .search( this.value )
        .draw();
	} );
	$('#patient_dob').on( 'keyup', function () {
    dTable
        .columns( 5 )
        .search( this.value )
        .draw();
	} );
	$('#reset').on( 'click', function () {
    dTable
        .search( '' )
        .columns().search( '' )
        .draw();
    } );
    
    });
</script>

<?php require_once APPPATH.'views/system/footer.php'; ?>
