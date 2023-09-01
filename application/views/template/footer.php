<footer class="main-footer no-print">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.0.3
    </div>
    <strong>Copyright &copy; <?= date('Y') - 1  ;?> - <?= date('Y');?> <a href="http://hafidzsolution.com">APPINVENTORY</a>.</strong> All rights reserved.
    <strong>
        <!--<a class="sidebar-toggle" >-->
            Hari : <?php
            $day = date('D', strtotime(date('Y-m-d')));
            $dayList = array(
                'Sun' => 'Minggu',
                'Mon' => 'Senin',
                'Tue' => 'Selasa',
                'Wed' => 'Rabu',
                'Thu' => 'Kamis',
                'Fri' => 'Jumat',
                'Sat' => 'Sabtu'
            );
            ?>
<?= $dayList[$day]; ?>, <script type='text/javascript'>
            <!--
    var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            var date = new Date();
            var day = date.getDate();
            var month = date.getMonth();
            var yy = date.getYear();
            var year = (yy < 1000) ? yy + 1900 : yy;
            document.write(day + " " + months[month] + " " + year);
//-->
            </script>   
            <span id="clock"></span>
<!--</a>-->
    </strong>
</footer>