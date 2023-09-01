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
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header">
                  <h3 class="box-title" id="form-head">Tambah Pengguna Baru</h3>
                </div>
                <div class="box-body">
                  <form action="<?php echo $base_url; ?>save" method="post" id="formPengguna">
                    <input type="hidden" id="id" name="id" value="" />
                   <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" class="form-control" placeholder="Nama Lengkap" name="nama" id="nama" required="required">
                        <p class="help-block">Nama Lengkap Pengguna</p>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" placeholder="Username" name="username" id="username" required="required">
                        <p class="help-block">Username untuk login</p>
                    </div>
                    <div class="form-group">
                        <label id="pass_label">Password</label>
                        <input type="password" class="form-control" placeholder="Password" name="password" id="password" >
                        <p class="help-block pass_notif">Password untuk login</p>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" placeholder="Password" name="confirm_password" id="confirm_password" >
                        <p class="help-block pass_notif">Masukkan ulang password</p>
                    </div>
                    <div class="form-group">
                        <label>Level</label>
                        <select id="id_level" name="id_level" class="form-control select2">
                            <?php $lv = array(); ?>
                            <?php foreach($level as $l):?>
                            <option value="<?=$l->id?>">
                                <?=$l->nama?>
                                <?php $lv[$l->id] = $l->nama?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="help-block">Level pengguna</p>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </form>
                </div><!-- /.box-body -->
              </div>
        </div>
        <div class="col-md-8">
            <div class="box box-warning">
                <div class="box-header">
                  <h3 class="box-title">Daftar User</h3>
                </div>
                
                <div class="box-body table-responsive ">
                    <table class="table table-hover table-striped">
                        <tr>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                        <?php foreach($data as $d):?>
                        <tr>
                            <td><a href="#" onclick="loadData('<?php echo $base_url; ?>edit/<?=$d->id?>')"><?=$d->nama?></a></td>
                            <td><?=$d->username?></td>
                            <td><?=$d->level?></td>
                            <td><a href="javascript:void(0)" onclick="deleteData('<?=$d->id?>')" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></a></td>
                        </tr>
                        <?php endforeach ?>
                    </table>
                </div>
                <div class="box-footer clearfix">
                    <?=$pagination?>
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
