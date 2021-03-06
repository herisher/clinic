<?php require_once APPPATH.'views/system/header.php'; ?>
<?php require_once APPPATH.'views/system/sidebar.php'; ?>

<aside class="right-side">
    <section class="content-header">
        <h1>
            <i class="fa fa-stethoscope">&nbsp;</i>  Dokter
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-gold">
                    <div class="box-body">
                        <ol class="breadcrumb ">
                            <li> <i class="fa fa-stethoscope">&nbsp;</i> Dokter</a></li>
                        </ol>
						<form action="/system/doctor/csv" method="POST">
                        <div id="advance-search" class="collapse">
                            <div class="well">
                                <!--ROW 1-->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group" id="filter_col1" data-column="1">
                                            <label class="control-label" >Nama Dokter</label>
                                            <input id="doctor_name" class="form-control" type="text" placeholder="Nama Dokter" value="" name="doctor_name" data-column="1"/>
                                        </div>
                                    </div>
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
                            <button type="button" href="<?php echo base_url();?>system/doctor/new" class="btn btn-primary pull-right" onclick="window.open('<?php echo base_url();?>system/doctor/new', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;"><i class="fa fa-file"></i> &nbsp; New Dokter</button>
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
                                    <th>Nama Dokter</th>
                                    <th>No. Telepon HP</th>
                                    <th class="col-sm-1">Edit</th>
                                    <th class="col-sm-1">Delete</th>
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
    var dTable;
    $.fn.dataTable.ext.errMode = 'throw';
    $(document).ready(function() {
		
    dTable = $('#index_table').DataTable( {
        "scrollX":true,
        "scrollY": "300",
		"destroy": true,
        "bProcessing": true,
        "bServerSide": true,
        "bJQueryUI": false,
        "responsive": true,
        "sAjaxSource": "<?php echo base_url() . "system/doctor/ajax_get_doctor_list/"; ?>", // Load Data
        "sServerMethod": "POST",
        "columnDefs": [
            { "orderable": true, "targets": 0, "searchable": true }, //No
            { "orderable": true, "targets": 1, "searchable": true }, //Name
            { "orderable": true, "targets": 2, "searchable": true }, //No. Telepon HP
			{ "orderable": false, "targets": 3, "searchable": false }, //Edit
			{ "orderable": false, "targets": 4, "searchable": false } //Delete
        ],
			"order": [[ 0, "desc" ]]
    });
	
	//Search form
	$('#doctor_name').on( 'keyup', function () {
    dTable
        .columns( 1 )
        .search( this.value )
        .draw();
	} );
	$('#reset').on( 'click', function () {
    dTable
        .search( '' )
        .columns().search( '' )
        .draw();
    } );
    
    <?php //disabling edit n delete button for admin
        if( !$login_admin["type"] ) : ?>
        for ( var i=-2 ; i<=-1 ; i++ ) {
            dTable.column( i ).visible( false, false );
        }
        dTable.columns.adjust().draw(false); // adjust column sizing and redraw
    <?php endif; ?>
    });
</script>

<?php require_once APPPATH.'views/system/footer.php'; ?>
