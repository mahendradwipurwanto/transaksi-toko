
<!--<div style="padding: 20px;">-->
    <form action="<?= base_url('produk/');?>save" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $data['id'];?>"/>
       <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kode Barang :</label>
                                    <input type="text" class="form-control pull-right" name="kode_produk" value="<?= $data['kode_barang'] ? $data['kode_barang'] : $kode_barang ;?>" id="kode_produk" readonly="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Barang :</label>
                                    <input type="text" class="form-control" name="nama_produk" placeholder="Nama Barang" id="nama_produk" value="<?= $data['nama_barang'] ? $data['nama_barang'] : '' ;?>" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Index :</label>
                                    <input type="text" class="form-control" name="indexs" value="<?= $data['indexs'] ? $data['indexs'] : 0 ;?>" id="index" required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Produksi :</label>
                                    <input type="text" class="form-control" name="produksi" value="<?= $data['produksi'] ? $data['produksi'] : 0 ;?>" id="produksi" required="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Berat Satuan :</label>
                                    <input type="text" class="form-control" name="satuan" value="<?= $data['satuan'] ? $data['satuan'] : 0 ;?>" id="berat_Satuan" required="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tonasi Per Palet(kg) :</label>
                                    <input type="text" class="form-control money-input" name="harga_tonasi"  value="<?= $data['harga_tonasi'] ? $data['harga_tonasi'] : 0 ;?>" value="0" id="harga" required="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Harga Per Kg :</label>
                                    <input type="text" class="form-control money-input" name="harga" value="<?= $data['harga'] ? $data['harga'] : 0 ;?>" id="harga" required="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Keterangan Barang:</label>
                                    <textarea class="form-control" rows="3" placeholder="Keterangan ..." name="keterangan" id="keterangan"><?= $data['keterangan'] ? $data['keterangan'] : "" ;?></textarea>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="modal-footer ">
                                <button class="btn btn-info btn-flat btn-sm" target="_blank" type="submit"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                                <button type="button" class="btn btn-warning btn-flat btn-sm" data-dismiss="modal"> Batal</button>
                            </div>
    </form>
<!--</div>-->
