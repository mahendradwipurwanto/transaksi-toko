<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= $title ?>
    </h1>
    <?php echo $breadcrumbs; ?>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <form action="<?php echo $base_url; ?>" method="post" id="formTransaksi" class="form-horizontal">
            <!-- Agen -->
            <div class="col-md-12">
                <div class="row">

                    <div class="col-md-12">
                        <div class="box box-success">
                            <div class="box-header">
                                <h3 class="box-title" id="form-head">Filter</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="control-label form-label col-sm-2">Tanggal</label>
                                            <div class="col-sm-4">
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="glyphicon glyphicon-calendar"></i>
                                                    </div>
                                                    <input id="date1" class="form-control pull-right" value="dd-mm-yyyy" name="date1" id="date1" type="text">
                                                </div>
                                            </div>
                                            <div class="col-sm-2 text-center">
                                                <label class="control-label form-label">s.d.</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="glyphicon glyphicon-calendar"></i>
                                                    </div>
                                                    <input id="date2" class="form-control pull-left" value="dd-mm-yyyy" name="date2" id="date2" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="control-label form-label col-sm-2">Shift</label>
                                            <div class="col-sm-10   ">
                                                <select id="shift" name="shift" class="form-control">
                                                    <option value="0">Shift Pagi</option>>
                                                    <option value="1">Shift Sore</option>>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" id="btnFilter" class="btn btn-primary btn-flat"><span class="glyphicon glyphicon-search"></span> Cari</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- Barang -->
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">Laporan Data Penjualan </h3>
                    <!--                    <form action="<?php echo BASE_URL; ?>laporan" method="post">
                        <button type="submit" style="display: none;"  id="pdf" class="btn btn-default btn-flat pull-right"><img src="<?= BASE_URL; ?>assets/img/pdf.png" > Export Ke PDF </button>
                        <input type="hidden" name="date1" value="<?= $post ?>" />
                        <input type="hidden" name="date2" value="<?= $post ?>" />
                    </form>-->
                    <form action="<?php echo $base_url; ?>export" method="post">
                        <!-- <button type="submit" style="display: none;" id="excel" class="btn btn-default btn-flat pull-right"><img src="<?= BASE_URL; ?>assets/img/xls.png"> Export Ke Excel </button> -->
                        <input type="hidden" name="date1" value="<?= $post_start ?>" />
                        <input type="hidden" name="date2" value="<?= $post_end ?>" />
                        <input type="hidden" name="shift" value="<?= $post_shift ?>" />
                    </form>
                </div>
                <div class="box-body table-responsive ">
                    <table class="table table-hover table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th>Shift</th>
                                <th>Tanggal</th>
                                <th>Invoice</th>
                                <th>Total</th>
                                <th>Created By</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="detail-data" class="modal fade">
            <div class="modal-dialog" style="width:850px;">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #00a65a;">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                        <h4 class="modal-title" style="color:white;"><b>Preview Data Penjualan</b></h4>
                    </div>
                    <div class="modal-body">
                        <div class="fetched_preview-data">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- /.content -->

<!-- alert -->
<?php
$alert = $this->session->flashdata("alert_transaksi");
if (isset($alert) && !empty($alert)) :
    $message = $alert['message'];
    $status = ucwords($alert['status']);
    $class_status = ($alert['status'] == "success") ? 'success' : 'danger';
    $icon = ($alert['status'] == "success") ? 'check' : 'ban';
?>
    <div class="modal modal-<?php echo $class_status ?> fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                    <h4 class="modal-title"><span class="icon fa fa-<?php echo $icon ?>"></span> <?php echo $status ?></h4>
                </div>
                <div class="modal-body">
                    <p><?php echo $message ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-dismiss="modal">OK</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<?php endif; ?>