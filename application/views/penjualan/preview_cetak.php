
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>INVENTORY | Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?=ASSETS_URL?>/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=ASSETS_URL?>/dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <i class="fa fa-globe"></i> APPPENJUALAN.
          <small class="pull-right">Date: <?= date('d-m-Y h:i:s');?></small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Invoice <?= $data_p['invoice'];?></b><br>
        <br>
        <b>Tanggal:</b> <?= date('d-m-Y h:i:s',  strtotime($data_p['tanggal']));?><br>
        <b>Kasir:</b> <?= $createdby->nama;?><br>
        <p></p>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>#</th>
              <th>Kode Barang</th>
              <th>Nama Barang</th>
              <th>Harga Satuan</th>
              <th>Jumlah</th>
              <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
                <?php $no=0;$total=0;$tot=0;foreach($data as $r){$no++;
                 $hasil_rupiah = "Rp " . number_format($r['harga'], 0, '', '.');
                 $sub = "Rp " . number_format($r['total'], 0, '', '.');
                 $tot += $r['total'];
                 $total = "Rp " . number_format($tot, 0, '', '.');
                 ?>
                
            <tr>
              <td><?=$no;?></td>
              <td><?= $r['kode_barang'];?></td>
              <td><?= $r['produk'];?></td>
              <td><?= $hasil_rupiah;?></td>
              <td><?= $r['jumlah'];?></td>
              <td><?= $sub;?></td>
            </tr>
                <?php } ?>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-6">
      </div>
      <!-- /.col -->
      <div class="col-xs-6">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%">Grand Total:</th>
              <td><?= $total;?></td>
            </tr>
            <tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
