    <!-- Content Header (Page header) -->

    <section class="content-header">
      <h1>
        <?= $title ?> <small>Control panel</small>
      </h1>

      <?= $breadcrumbs ?>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?= $barang->barang; ?></h3>

              <p>Data Produk</p>
            </div>
            <div class="icon" style="top:-1px;right: 63px;">
              <i class="glyphicon glyphicon-briefcase"></i>
            </div>
            <?php $user_data =  $this->session->userdata("user_id");
            if ($user_data == 1) { ?>
              <a href="<?= BASE_URL; ?>produk" class="small-box-footer">More info <i class="glyphicon glyphicon-hand-right"></i></a>
            <?php } else { ?>
              <a href="<?= BASE_URL; ?>home" class="small-box-footer">More info <i class="glyphicon glyphicon-hand-right"></i></a>
            <?php } ?>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?= $penjualan->penjualan; ?></h3>

              <p>Data Transaksi Barang</p>
            </div>
            <div class="icon" style="top:-1px;right: 63px;">
              <i class="glyphicon glyphicon-folder-open"></i>
            </div>
            <a href="<?= BASE_URL; ?>penjualan" class="small-box-footer">More info <i class="glyphicon glyphicon-hand-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?= $barang->barang; ?></h3>

              <p>Laporan Transaksi Barang</p>
            </div>
            <div class="icon" style="top:-1px;right: 63px;">
              <i class="glyphicon glyphicon-shopping-cart"></i>
            </div>
            <?php $user_data =  $this->session->userdata("user_id");
            if ($user_data == 1) { ?>
              <a href="<?= BASE_URL; ?>laporan/penjualan" class="small-box-footer">More info <i class="glyphicon glyphicon-hand-right"></i></a>
            <?php } else { ?>
              <a href="<?= BASE_URL; ?>home" class="small-box-footer">More info <i class="glyphicon glyphicon-hand-right"></i></a>
            <?php } ?>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?= $pengguna->user; ?></h3>

              <p>Pengguna</p>
            </div>
            <div class="icon" style="top:-1px;right: 63px;">
              <i class="glyphicon glyphicon-user"></i>
            </div>
            <?php $user_data =  $this->session->userdata("user_id");
            if ($user_data == 1) { ?>
              <a href="<?= BASE_URL; ?>pengguna" class="small-box-footer">More info <i class="glyphicon glyphicon-hand-right"></i></a>
            <?php } else { ?>
              <a href="<?= BASE_URL; ?>home" class="small-box-footer">More info <i class="glyphicon glyphicon-hand-right"></i></a>
            <?php } ?>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
          <!--<img src="<?= BASE_URL; ?>Barcode/" alt="User Image">-->
        </section><!-- /.content -->
      </div>
      <!-- alert -->
      <?php
      $alert = $this->session->flashdata("alert_home");
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