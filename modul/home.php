<?php
//session_start();

if (empty($_SESSION[UserName]) AND empty($_SESSION[PassWord])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {
?>
  <div class="alert alert-block alert-success">
  									<button type="button" class="close" data-dismiss="alert">
  										<i class="ace-icon fa fa-times"></i>
  									</button>

  									<i class="ace-icon fa fa-check green"></i>

  									Selamat Datang
  									<strong class="green">
  										<?php echo $_SESSION['nm_Lengkap'] ?>

  									</strong>,
  	                 Sistem Realisasi Fisik dan Keuangan Kabupaten Luwu Utara
  								</div>

                  <div class="row">
                  									<div class="col-sm-4">
                  										<div class="widget-box transparent" id="recent-box">
                  											<div class="widget-header">
                  												<h4 class="widget-title lighter smaller">
                                                         <i class="ace-icon fa fa-rss orange"></i>
                                                         Capaian
                                                      </h4>
                  											</div>
                                                   <?php
                                                      $bulan = "1";
                                                      $q1 = mysql_query("SELECT SUM(a.b$bulan) AS relkeu, SUM(d.tk$bulan) AS trgkeu 
                                                                          FROM realisasi a,subkegiatan b,datakegiatan c,target d 
                                                                          WHERE a.id_SubKegiatan = b.id_SubKegiatan 
                                                                          AND b.id_DataKegiatan = c.id_DataKegiatan 
                                                                          AND b.id_SubKegiatan = d.id_SubKegiatan
                                                                          AND c.TahunAnggaran = '$_SESSION[thn_Login]' 
                                                                          AND c.id_Skpd = '$_SESSION[id_Skpd]'");
                                                      $r1 = mysql_fetch_array($q1);
                                                      ?>   
                  											<div class="widget-body">
                  												<div class="widget-main padding-4">
                                                            <table class="table table-bordered">
                                                               <thead>
                                                                  <tr>
                                                                     <th class="info">% Realisasi</th>
                                                                     <th class="info">Target Juni</th>
                                                                     <th class="info">Realisasi Jun</th>
                                                                     <th class="info">Deviasi</th>
                                                                  </tr>
                                                               </thead>
                                                               <tbody>
                                                                  <tr>
                                                                     <td>Keuangan</td>
                                                                     <td><?php echo $r1[trgkeu] ?></td>
                                                                     <td><?php echo $r1[relkeu] ?></td>
                                                                     <td></td>
                                                                  </tr>
                                                                  <tr>
                                                                     <td>Fisik</td>
                                                                     <td></td>
                                                                     <td></td>
                                                                     <td></td>
                                                                  </tr>
                                                               </tbody>                                                   
                                                            </table>
                                                            <hr>
                  												</div><!-- /.widget-main -->
                  											</div><!-- /.widget-body -->
                  										</div><!-- /.widget-box -->
                  									</div><!-- /.col -->

                  									<div class="col-sm-8">
                  										<div class="widget-box">
                  											<div class="widget-header">
                  												<h4 class="widget-title lighter smaller">
                  													<i class="ace-icon fa fa-comment blue"></i>
                  													Target dan Realisasi
                  												</h4>
                  											</div>

                  											<div class="widget-body">
                  												<div class="widget-main no-padding">
                  													<?php
                                            if($_SESSION[UserLevel]<> 1) {
                                                  include "report/chartrekapskpd.php";
                                            } else {
                                              echo "";
                                            }

                                            ?>

                  													
                  												</div><!-- /.widget-main -->
                  											</div><!-- /.widget-body -->
                  										</div><!-- /.widget-box -->
                  									</div><!-- /.col -->
                  								</div>

<?php
}
?>
