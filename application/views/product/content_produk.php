    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?=$title?>
      </h1>
      <?=$breadcrumbs?>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header">
                  <h3 class="box-title">List Data Produk</h3>
                        </div>
                
                <div class="box-body">
                        <form action="<?php echo $base_url; ?>" method="post" id="formBarang">
                            <input type="hidden" class="form-control" name="IDprovinsi" id="IDprovinsi">                        
                        </form>
                     <table class="table table-hover table-striped" id="datatable">
                        <thead>
                            <tr>
                                <th>Kode Produk</th>
                                <th>Nama Produk</th>
                                <th>Index</th>
                                <th>Produksi</th>
                                <th>Berat Satuan</th>
                                <th>Tonasi per palet (kg)</th>
                                <th>Harga per Kg</th>
                                <th>Keterangan</th>
                                <th>Barcode</th>
                                <th>
                                    <a href="#"><button type="button" class="btn bg-blue-active btn-flat" data-toggle="modal" data-target="#print-data"><span class="glyphicon glyphicon-plus"></span> Tambah Data</button>
                                    <!--<a href="#"><button type="button" class="btn bg-red-active btn-flat" data-toggle="modal" data-target="#impor-data"><span class="glyphicon glyphicon-download"></span> Impor Data Excel</button></a>-->
                                </th>                                
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        
                        </table>
                        </div>
                </div>
            </div>
        </div>
          <div id="delete-data" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header"  style="background-color: #00a65a;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style="color:white;"><b>Konfirmasi</b></h4>
                    </div>
                    <div class="modal-body">
                        <h4><b> Apakah Anda yakin ingin menghapus data Produk ini ? </b></h4>
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:;" class="btn btn-danger" id="hapus-true-data">Hapus</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                    </div>

                </div>
            </div>
        </div>
        <div id="edit-data" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header"  style="background-color: #00a65a;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style="color:white;"><b>Edit Data</b></h4>
                    </div>
                    <div class="modal-body">
                         <div class="fetched-data"></div>
                    </div>

                </div>
            </div>
        </div>
        <div id="print-data" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header"  style="background-color: #00a65a;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style="color:white;"><b>Tambah Data</b></h4>
                    </div>
                    <div class="modal-body">
                        <form action="<?= $base_url;?>save" method="post" id="id" accept-charset="" enctype="multipart/form-data">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kode Barang :</label>
                                    <input type="text" class="form-control pull-right" name="kode_produk" placeholder="Kode Barang"  id="kode_produk" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Barang :</label>
                                    <input type="text" class="form-control" name="nama_produk" placeholder="Nama Barang" id="nama_produk" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Index :</label>
                                    <input type="text" class="form-control" name="indexs" placeholder="Indexs Barang" id="index" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Produksi :</label>
                                    <input type="text" class="form-control" name="produksi" placeholder="Produksi" id="produksi" required="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Berat Satuan :</label>
                                    <input type="text" class="form-control" name="satuan" placeholder="Berat Satuan" id="berat_Satuan" required="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tonasi Per Palet(kg) :</label>
                                    <input type="text" class="form-control money-input" name="harga_tonasi" placeholder="Tonasi Per Palet(kg)" value="0" id="harga" required="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Harga Per Kg :</label>
                                    <input type="text" class="form-control money-input" name="harga" placeholder="Harga Per K" value="0" id="harga" required="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Keterangan Barang:</label>
                                    <textarea class="form-control" rows="3" placeholder="Keterangan ..." name="keterangan" id="keterangan"></textarea>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="modal-footer ">
                                <button class="btn btn-info btn-flat btn-sm" target="_blank" type="submit"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                                <button type="button" class="btn btn-warning btn-flat btn-sm" data-dismiss="modal"> Batal</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
        <div id="impor-data" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header"  style="background-color: #00a65a;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style="color:white;"><b>Import Data Barang</b></h4>
                    </div>
                    <div class="modal-body">
                        <form action="<?= $base_url;?>save" method="post" id="id" accept-charset="" enctype="multipart/form-data">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Impor Barang (.xlsx):</label>
                                    <input type="file" class="form-control pull-right" name="kode_produk" placeholder="Kode Barang"  id="kode_produk" required="">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="modal-footer ">
                                <button class="btn btn-info btn-flat btn-sm" target="_blank" type="submit"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                                <button type="button" class="btn btn-warning btn-flat btn-sm" data-dismiss="modal"> Batal</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">

                    </div>

                </div>
            </div>
        </div>
        <div id="qrcode-data" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header"  style="background-color: #00a65a;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="color:white;"><b>Preview QRcode</b></h4>
                </div>
                <div class="modal-body">
                    <div class="fetched_qr-data">

                    </div>

                </div>
            </div>
        </div>
    </div>
      </div>
    </section><!-- /.content -->
    
    <!-- alert -->
    <?php
      $alert = $this->session->flashdata("alert_pengguna");
      if(isset($alert) && !empty($alert)):
        $message = $alert['message'];
        $status = ucwords($alert['status']);
        $class_status = ($alert['status'] == "success") ? 'success' : 'danger';
        $icon = ($alert['status'] == "success") ? 'check' : 'ban';
    ?>
    <div class="modal modal-<?php echo $class_status ?> fade" id="myModal" >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
            <h4 class="modal-title"><span class="icon fa fa-<?php echo $icon ?>"></span> <?php echo $status?></h4>
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
