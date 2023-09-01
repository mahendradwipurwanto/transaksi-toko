<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= $title ?>
    </h1>
    <?php echo $breadcrumbs; ?>
    <?= $breadcrumbs ?>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <form action="<?php echo $base_url; ?>save" method="post" id="formTransaksi" class="form-horizontal">
            <!-- Barang -->
            <input type="hidden" id="index_row" name="index_row" value="1"/>
            <div class="col-md-8">
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">Data Barang</h3>
                    </div>
                    <div class="box-body table-responsive ">
                        <table class="table table-hover table-striped" id="tabel_barang">
                            <tr>
                                <th style="width:15%">Kode Barang</th>
                                <th style="width:30%">Nama Barang</th>
                                <th style="width:15%">Jumlah</th>
                                <th>Tonasi Per palet(Kg)</th>
                                <th>Harga Per Kg</th>
                                <th>Harga Per Palet</th>
                                <th>Sub Total</th>
                                <th>Delete</th>
                            </tr>
                            <tr id="barang_0" style="display: none;" data-id="0">
                                <td>
                                    <input type="text" class="form-control pilih_barang" placeholder="Kode Barang "
                                           name="kode_barang_0" id="kode_barang_0" onchange="getHarga('kode_barang_0')">
                                </td>
                                <td>
                                    <input type="text" class="form-control" placeholder="Nama Barang"
                                           name="nama_barang_0" id="nama_barang_0" readonly="readonly">
                                </td>
                                <td>
                                    <input type="text" class="form-control" placeholder="Jumlah Barang" name="jumlah_0"
                                           id="jumlah_0" value="1" onchange="getTotalHargaItem('kode_barang_0')">
                                </td>
                                <td>
                                    <input type="text" value="" class="form-control" placeholder="Tonasi"
                                           name="satuan_0" id="satuan_0" readonly="readonly">
                                </td>
                                <td>
                                    <input type="text" value="0" class="form-control money-input" placeholder="Harga"
                                           name="harga_0" id="harga_0" readonly="readonly">
                                    <input type="hidden" value="0" class="form-control" name="stok_0" id="stok_0"
                                           readonly="readonly">
                                </td>
                                <td>
                                    <input type="text" value="0" class="form-control money-input" placeholder="Total"
                                           name="total_0" id="total_0" readonly="readonly">
                                </td>
                                <td>
                                    <input type="text" value="0" class="form-control money-input"
                                           placeholder="Sub Total" name="sub_total_0" id="sub_total_0"
                                           readonly="readonly">
                                </td>
                                <td>
                                    <a href="javascript:void(0)" onclick="removeBarang('barang_0')"
                                       class="btn btn-danger" style="display: none;" name="delete_0" id="delete_0"><span
                                                class="glyphicon glyphicon-trash"></span></a>
                                </td>
                                </td>
                            </tr>
                            <tr id="barang_1" data-id="1">
                                <td>
                                    <input type="text" class="form-control pilih_barang" placeholder="Kode Barang"
                                           name="kode_barang_1" id="kode_barang_1" onchange="getHarga('kode_barang_1')"
                                           required="required_1">
                                </td>
                                <td>
                                    <input type="text" class="form-control" placeholder="Nama Barang"
                                           name="nama_barang_1" id="nama_barang_1" readonly="readonly">
                                </td>
                                <td>
                                    <input type="text" class="form-control" placeholder="Jumlah Barang" name="jumlah_1"
                                           id="jumlah_1" value="1" onchange="getTotalHargaItem('kode_barang_1')">
                                </td>
                                <td>
                                    <input type="text" value="" class="form-control" placeholder="Tonasi"
                                           name="satuan_1" id="satuan_1" readonly="readonly">
                                </td>
                                <td>
                                    <input type="text" value="0" class="form-control money-input" placeholder="Harga"
                                           name="harga_1" id="harga_1" readonly="readonly">
                                    <input type="hidden" value="0" class="form-control" name="stok_1" id="stok_1"
                                           readonly="readonly">
                                </td>
                                <td>
                                    <input type="text" value="0" class="form-control money-input" placeholder="Total"
                                           name="total_1" id="total_1" readonly="readonly">
                                </td>
                                <td>
                                    <input type="text" value="0" class="form-control money-input"
                                           placeholder="Sub Total" name="sub_total_1" id="sub_total_1"
                                           readonly="readonly">
                                </td>
                                <td>

                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="box-footer clearfix">
                        <a href="javascript:void(0)" id="add_barang" style="display: inline;" onclick="addBarang()"
                           class="btn btn-success pull-right"><span class="glyphicon glyphicon-plus"></span> Tambah
                            Barang (F7)</a>
                        <!--<div class="box-footer clearfix">-->
                        <button type="submit" class='btn btn-primary' id='Simpann'>
                            <i class='glyphicon glyphicon-save-file'></i> Simpan
                        </button>
                    </div>
                </div>

            </div>
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Shortcut Keyboard :</h3>
                    </div>
                    <div class="box-body table-responsive ">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-sm-6">SHIFT</div>
                                <div class="col-sm-6 text-right"><b>SHIFT <?= $shift_txt; ?></b></div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-6">Kasir</div>
                                <div class="col-sm-6 text-right"><b><?= $this->session->userdata('user_name') ?></b>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <div class="col-sm-6"><i>F7 = Tambah Barang</i></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>

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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">x</span></button>
                    <h4 class="modal-title"><span class="icon fa fa-<?php echo $icon ?>"></span> <?php echo $status ?>
                    </h4>
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