<?php
    mysql_connect("localhost","root","");
    mysql_select_db("dbspk");
?>
<!doctype html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="bs/bootstrap.min.css">
    <title>Metode Profile Matching</title>
  </head>
  <body>
  <div class="container">
  <?php
        //---------------------Menyimpan tabel bobot dalam array---------------------
            $bobot=array();
            $sql="SELECT * FROM tbl_bobot";
            $hasil=mysql_query($sql);
            while($row=mysql_fetch_assoc($hasil))
                {
                    $bobot[$row['selisih']]=$row['bobot'];
                }
        //---------------------Menyimpan tabel sample dalam array---------------------
            $sql="SELECT * FROM tbl_sample";
            $hasil=mysql_query($sql);
            while($row=mysql_fetch_assoc($hasil))
                {
                    $nilai_sample[$row['karyawan']][$row['faktor']]=$row['nilai'];
                }
        //---------------------Menyimpan tabel karyawan dalam array---------------------        
            $nama_karyawan=array();
            $nilai_akhir=array();
            $sql="SELECT * FROM tbl_karyawan ORDER BY id_karyawan";
            $hasil=mysql_query($sql);
            while($row=mysql_fetch_assoc($hasil))
                {
                    $nama_karyawan[$row['id_karyawan']]=$row['nama_karyawan'];
                    $nilai_akhir[$row['id_karyawan']]=0;
                }
        //---------------------Menyimpan tabel aspek dalam array---------------------       
            $nama_aspek=array(); 
            $nama_singkat=array(); 
            $jumlah_kolom=array();
            $ba_all=array();
            $ba_cf=array();
            $ba_sf=array();
            $sql="SELECT *,(SELECT COUNT(id_faktor) FROM tbl_faktor WHERE aspek=id_aspek) AS jum_kolom 
                 FROM tbl_aspek";
            $hasil=mysql_query($sql);
            while($row=mysql_fetch_assoc($hasil))
                {
                    $aspek=$row['id_aspek'];
                    $nama_aspek[$row['id_aspek']]=$row['nama_aspek'];
                    $nama_singkat[$row['id_aspek']]=$row['nama_singkat'];
                    $jumlah_kolom[$row['id_aspek']]=$row['jum_kolom'];
                    $ba_all[$row['id_aspek']]=$row['bobot'];
                    $ba_cf[$row['id_aspek']]=$row['bobot_core'];
                    $ba_sf[$row['id_aspek']]=$row['bobot_secondary'];
                    //------------cari index berdasarkan nomor 
                    $sql2="SELECT * FROM tbl_faktor WHERE aspek='$aspek' ORDER BY id_faktor";
                    $hasil2=mysql_query($sql2);
                    $kolom=1;
                    while($row2=mysql_fetch_assoc($hasil2))
                        {
                            $r_index[$aspek][$kolom]=$row2['id_faktor'];
                            $kolom++;
                        }
                }
    ?>
    <h1>Contoh SPK GAP MP</h1>
        <table class="table">
            <tr>
                <th>No</th>
                <th>Aspek</th>
                <th>Faktor</th>
                <th>Nilai Target</th>
                <th>Type</th>
            </tr>
            <?php
                $no=1;
                //---------------------Menyimpan tabel faktor dalam array dan menampilkan---------------------
                $sql="SELECT tbl_faktor.*,nama_aspek,IF(jenis='1','c','s') AS nama_jenis
                    FROM tbl_faktor LEFT JOIN tbl_aspek ON aspek=id_aspek ORDER BY aspek,id_faktor";
                $hasil=mysql_query($sql);
                $target=array();
                $nama_jenis=array();
                while($row=mysql_fetch_assoc($hasil))
                {       
                    $target[$row['id_faktor']]=$row['target'];
                    $nama_jenis[$row['id_faktor']]=$row['nama_jenis'];
            ?>
            <tr>
              <td><?php echo $no++;?></td>
              <td><?php echo $row['nama_aspek'];?></td>
              <td><?php echo $row['nama_faktor'];?></td>
              <td><?php echo $row['target'];?></td>
              <td><?php echo $row['nama_jenis'];?></td>
          </tr>
          <?php
                }
          ?>
        </table>
        <?php
             
             
            while (list($key, $value) = each($nama_aspek)) 
                {       
                    echo "<h2>".$nama_aspek[$key]."</h2>";
                     
        ?>
                 
                <table class="table">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <?php for($kol=1;$kol<=$jumlah_kolom[$key];$kol++) {?>
                        <th><?php echo $nama_singkat[$key]; ?><sub><?php echo $kol;?></sub></th>
                        <?php } ?>
                    </tr>
                    <?php
                        reset($nama_karyawan);
                        $nomor=1;   
                        while (list($k, $v) = each($nama_karyawan)) 
                            {
                                 
                    ?>
                    <tr>
                        <td><?php echo $nomor++;?></td>
                        <td><?php echo $nama_karyawan[$k];?></td>
                        <?php for($kol=1;$kol<=$jumlah_kolom[$key];$kol++) {
                                    $pos=$r_index[$key][$kol];
                            ?>
                        <td><?php echo $nilai_sample[$k][$pos]; ?></td>
                        <?php } ?>
                    </tr>
                    <?php
                            }
                    ?>
                </table>
        <?php            
                }
        ?>
        <hr />
        <h2>PERHITUNGAN GAP</h2>
        <?php
        reset($nama_aspek);
        while (list($key, $value) = each($nama_aspek)) 
                {       
                    echo "<h3>Aspek ".$nama_aspek[$key]."</h3>";
                     
        ?>
                 
                <table class="table">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <?php for($kol=1;$kol<=$jumlah_kolom[$key];$kol++) {?>
                        <th><?php echo $nama_singkat[$key]; ?><sub><?php echo $kol;?></sub></th>
                        <?php } ?>
                    </tr>
                    <?php
                        //---------------------Proses menghitung nilai GAP---------------------     
                        reset($nama_karyawan);
                        $nomor=1;   
                        while (list($k, $v) = each($nama_karyawan)) 
                            {
                                 
                    ?>
                    <tr>
                        <td><?php echo $nomor++;?></td>
                        <td><?php echo $nama_karyawan[$k];?></td>
                        <?php for($kol=1;$kol<=$jumlah_kolom[$key];$kol++) {
                                    $pos=$r_index[$key][$kol];
                                    $nilai_gap[$k][$pos]=$nilai_sample[$k][$pos]-$target[$pos]
                            ?>
                        <td>(<?php echo $nilai_sample[$k][$pos]; ?>-<?php echo $target[$pos]; ?>)=<strong><?php echo $nilai_gap[$k][$pos];?></strong></td>
                        <?php } ?>
                    </tr>
                    <?php
                            }
                    ?>
                </table>
        <?php            
                }
        ?>
         
         
        <hr />
        <h2>PEMBOBOTAN</h2>
        <?php
        reset($nama_aspek);
        while (list($key, $value) = each($nama_aspek)) 
                {       
                    echo "<h3>Aspek ".$nama_aspek[$key]." (".$ba_all[$key]."%)</h3>";
                     
        ?>
                 
                <table class="table">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <?php for($kol=1;$kol<=$jumlah_kolom[$key];$kol++) {
                                $pos=$r_index[$key][$kol];
                            ?>
                        <th><?php echo $nama_singkat[$key]; ?><sub><?php echo $kol;?></sub>[<?php echo $nama_jenis[$pos];?>]</th>
                        <?php } ?>
                        <th>rCF (<?php echo $ba_cf[$key];?>%)</th>
                        <th>rSF (<?php echo $ba_sf[$key];?>%)</th>
                        <th>Nilai</th>
                    </tr>
                    <?php
                        reset($nama_karyawan);
                        $nomor=1;   
                        while (list($k, $v) = each($nama_karyawan)) 
                            {
                                $jum_cf=$jum_sf=$ccf=$csf=0;
                                 
                    ?>
                    <tr>
                        <td><?php echo $nomor++;?></td>
                        <td><?php echo $nama_karyawan[$k];?></td>
                        <?php for($kol=1;$kol<=$jumlah_kolom[$key];$kol++) {
                                    $pos=$r_index[$key][$kol];
                                    $nilai_bobot[$k][$pos]=$bobot[$nilai_sample[$k][$pos]-$target[$pos]];
                                    if($nama_jenis[$pos]=="c")
                                        {
                                            $jum_cf+=$nilai_bobot[$k][$pos];
                                            $ccf++; 
                                        }
                                    else
                                        {
                                            $jum_sf+=$nilai_bobot[$k][$pos];
                                            $csf++; 
                                        }   
                                         
                            ?>
                        <td><?php echo $nilai_bobot[$k][$pos];?></td>
                        <?php }
                         
                            $ncf=$jum_cf/$ccf;
                            $nsf=$jum_sf/$csf;
                            $nilai_bobot[$k][$key]=$ba_cf[$key]*($ncf/100)+$ba_sf[$key]*($nsf/100);
                            $nilai_akhir[$k]+=$nilai_bobot[$k][$key]*($ba_all[$key]/100);
                         ?>
                        <td><?php echo $jum_cf."/".$ccf;?>=<?php echo number_format($ncf,2,",","."); ?></td>
                        <td><?php echo $jum_sf."/".$csf;?>=<?php echo number_format($nsf,2,",","."); ?></td>
                        <td><?php echo  number_format($nilai_bobot[$k][$key],2,",","."); ?></td>
                    </tr>
                    <?php
                            }
                    ?>
                </table>
        <?php            
                }
                //print_r($nilai_akhir);
                reset($nilai_akhir);
                //krsort($nilai_akhir);
                //print_r($nilai_akhir);
        ?>
                        <h3>Nilai Akhir Total</h3>
                        <table class="table">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Nilai</th>
                            </tr>
        <?php
                         
                        $nomor=1;   
                        while (list($k, $v) = each($nilai_akhir))   
                            {
            ?>
                        <tr>
                                <td><?php echo $nomor++; ?></td>
                                <td><?php echo $nama_karyawan[$k]; ?></td>
                                <td><?php echo number_format($nilai_akhir[$k],2,",","."); ?></td>
                            </tr>
            <?php                    
                            }
        ?>
                        </table>
             <?php
                //print_r($nilai_akhir);
                reset($nilai_akhir);
                arsort($nilai_akhir);
                //print_r($nilai_akhir);
             ?>
                         
                        <h3>Nilai Akhir Total Sorting</h3>
                        <table class="table">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Nilai</th>
                            </tr>
        <?php
                         
                        $nomor=1;   
                        while (list($k, $v) = each($nilai_akhir))   
                            {
            ?>
                        <tr>
                                <td><?php echo $nomor++; ?></td>
                                <td><?php echo $nama_karyawan[$k]; ?></td>
                                <td><?php echo number_format($nilai_akhir[$k],2,",","."); ?></td>
                          </tr>
            <?php                    
                            }
        ?>
                        </table>
 
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="bs/jquery-3.2.1.slim.min.js"></script>
    <script src="bs/bootstrap.min.js"></script>
  </body>
</html>