<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Clinic | System</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" href="<?php echo base_url() ?>img/favicon.jpg" type="text/css" />
    <link href="<?php echo base_url() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>css/admin.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>css/skin-gold.css" rel="stylesheet" type="text/css" />

    <script src="<?php echo base_url() ?>js/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo base_url() ?>js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>js/app.js" type="text/javascript"></script>

    <?php if( isset($next) && $next == 1 ) : ?>
        <script type="text/javascript">
            window.opener.document.location.reload();
            self.close();
        </script>
    <?php endif; ?>
    
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-solid box-gold">
                    <div class="box-header fixed">
                        <h3 class="box-title">
                            Delete Pasien
                        </h3>
                    </div>
                    <form name="form2" id="edit" action="<?php echo base_url();?>system/patient/delete/<?php echo $patient_id; ?>" method="post" enctype="multipart/form-data">
                        <section class="content">
                            <div class="container-form">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="alert alert-danger">
                                            <h4><span class="glyphicon glyphicon-warning-sign"></span> &nbsp; Are you sure you would like to remove Pasien <?= $datas['patient_name']?> ?</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <p class="text-center">
                                        <a href="#" onclick="javascript:self.close();" class="btn btn-danger"><i class="fa fa-minus-circle">&nbsp;</i> No</a>
                                        <button type="submit" name="submit" value="YES" class="btn btn-primary"><i class="fa fa-check">&nbsp;</i> Yes</button>
                                    </p>
                                </div>
                            </div>
                        </section>
                    </form>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </section>
