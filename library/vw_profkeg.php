<?php
session_start();
include "../config/koneksi.php";
include "../config/fungsi.php";
include "../config/fungsi_indotgl.php";


$postur = $_POST['id_SubKegiatan'];
//$postur1 = $_POST['id_LampPermasalahan'];
/*
if(!empty($postur1)) {
  //mengambil data dari tombol edit isi permasalahan
  $qi = mysql_query('SELECT * FROM lamppermasalahan WHERE id_LampPermasalahan = "'.$postur1.'"');
  $ri = mysql_fetch_array($qi);
  //data id_subkegiatan dari table lamppermasalahan
  $q = mysql_query('SELECT * FROM subkegiatan WHERE id_SubKegiatan = "'.$ri['id_SubKegiatan'].'"');
  $r = mysql_fetch_array($q);
  //ganti tombol
  $nmtombol = "edit";
} else {
*/
//data ditampilkan dari table
  $q = mysql_query('SELECT * FROM subkegiatan WHERE id_SubKegiatan = "'.$postur.'"');
  $r = mysql_fetch_array($q);
  $nmtombol = "masalah";
//}
echo '<div class="row">';

echo '<div class="col-md-12">
        <div class="card">
          <div class="header">
              <h5 class="title">'.$r['nm_SubKegiatan'].'</h4>
              
              </div>
          <div class="content">';
          include "../report/chartmodel.php";
          echo '</div>
          
          <div class="text-center">
          </div>
        </div>
      </div>';
//row
echo '</div>';

echo '<div class="row">';

echo '<div class="col-md-12">
        <div class="card">
          <div class="content">
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-home"></i> Beranda</a></li>
              <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-map"></i> Lokasi</a></li>
              <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><i class="fa fa-tags"></i> Pelaksana</a></li>
              <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab"><i class="fa fa-cubes"></i> Rencana Anggaran</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="home"><br>
                <table class="table">
                  <tr><td style="width:20%" class="info">Anggaran</td><td>Rp. '.number_format($r['nl_Pagu']).'</td><td></td><td></td><td></td></tr>
                  <tr><td style="" class="info">Nilai Fisik</td><td>Rp. '.number_format($r['nl_Fisik']).'</td><td></td><td style="width:15%" class=""></td><td></td></tr>
                  <tr><td style="" class="info">Nilai Kontrak</td><td>Rp. '.number_format($r['nl_Kontrak']).'</td><td></td><td></td><td></td></tr>
                  <tr><td style="" class="info">Volume</td><td>'.$r['jml_Volume'].'</td><td></td><td></td><td></td></tr>
                </table></div>
              <div role="tabpanel" class="tab-pane" id="profile"><br>
                <table class="table">
                  <tr><td style="width:15%" class="info">Lokasi</td><td>'.$r['AlamatLokasi'].'</td><td></td><td></td><td></td></tr>
                  <tr><td style="width:15%" class="info">Desa</td><td>'.$r['id_Desa'].'</td><td></td><td style="width:15%" class=""></td><td></td></tr>
                  <tr><td style="width:15%" class="info">Kecamatan</td><td>'.$r['id_Desa'].'</td><td></td><td></td><td></td></tr>
                </table></div>
              <div role="tabpanel" class="tab-pane" id="messages"><br>
                <table class="table">
                  <tr><td style="width:15%" class="info">Pelaksana</td><td>'.$r[Pelaksana].'</td><td></td><td style="width:20%"></td><td></td></tr>
                  <tr><td style="width:15%" class="info">Perencana</td><td>'.$r[konsPerencana].'</td><td></td><td class=""></td><td></td></tr>
                  <tr><td style="width:15%" class="info">Pelaksana</td><td>'.$r[konsPengawas].'</td><td></td><td>Nomor Kontrak :</td><td>'.$r[no_Kontrak].'</td></tr>
                  <tr><td style="width:15%" class="info">Lat</td><td>'.$r[Latitude].'</td><td></td><td>Lon</td><td>'.$r[Longitude].'</td></tr>
                </table>
                </div>
              <div role="tabpanel" class="tab-pane" id="settings">
                <br>
                <table class="table">
                  <tr><td style="width:15%" class="info">Anggaran</td><td>'.$r[nl_Pagu].'</td><td></td><td></td><td></td></tr>
                  <tr><td style="width:15%" class="info">Triwulan I</td><td>'.$r[trg_Keu1].'</td><td></td><td style="width:15%" class="info">Triwulan II</td><td>'.$r[trg_Keu2].'</td></tr>
                  <tr><td style="width:15%" class="info">Triwulan III</td><td>'.$r[trg_Keu3].'</td><td></td><td style="width:15%" class="info">Triwulan IV</td><td>'.$r[trg_Keu4].'</td></tr>
                </table>
              </div>
            </div>           
          </div>
          <hr>
          <div class="text-center">
          </div>
        </div>
      </div>';

echo '</div>';

echo '<div class="row">
            <div class="col-md-12">
              <div class="card">
              <div class="header">
                <h4 class="title">Dokumentasi</h4>
                <p class="category"> </p>
              </div>
              <div class="content">';

          $qc = mysql_query("SELECT * FROM lamprealisasi a, subkegiatan b 
                                WHERE b.id_SubKegiatan = '$r[id_SubKegiatan]' 
                                AND a.id_SubKegiatan = b.id_SubKegiatan 
                                ORDER BY a.id_LampRealisasi");
                $no=1;
                while($rt=mysql_fetch_array($qc)) {
                $id_sub = $rt['id_SubKegiatan'];
                $no%2 == 1? $row = "<hr><div class=row>" : $row = "";
                $no%2 == 0  ? $end = "</div>" : $end = "";
                echo '
                '.$row.'
                  <div class="col-sm-6">
                    <div class="media">
                      <div class="media-left">
                        <a href="media/lampiran/'.$_SESSION[thn_Login].'/'.$rt['nm_LampRealisasi'].'" target="_blank">
                          <img class="media-object" src="media/lampiran/'.$_SESSION[thn_Login].'/'.$rt['nm_LampRealisasi'].'" alt="..." height="100" width="100">
                        </a>
                      </div>
                      <div class="media-body">
                        <h5 class="media-heading">Lampiran '.$no++.'</h5>
                        '.$rt['Caption'].'
                      </div>
                    </div>
                  </div>
                  
                '.$end.'';
                }
              
        echo '<hr>
        </div>
      </div>
      </div>';

                
  echo '<div class="footer">  
        </div>
      </form>
      </div>
    </div>';

echo '<div class="row">';

echo '<div class="col-md-12">
        <div class="card">
          <div class="header">
              <h4 class="title">Permasalahan - Solusi</h4>
              </div>
          <div class="content">
            <table class="table">
              <tr>
                <th>Tanggal</th><th>Permasalahan</th><th>Solusi</th>
              </tr>';
              $q=mysql_query("SELECT * FROM lamppermasalahan WHERE id_SubKegiatan='$r[id_SubKegiatan]' ORDER BY Tanggal DESC");
              $hit = mysql_num_rows($q);
              while($r=mysql_fetch_array($q)) {
                echo '<tr>
                  <td>'.$r['Tanggal'].'</td><td>'.$r['nm_Permasalahan'].'</td><td>'.$r['nm_Solusi'].'</td>
                </tr>';
              }
            echo '</table>
          </div>
          <hr>
          <div class="text-center">
          </div>
        </div>
      </div>';
//row
echo '</div>';

?>
<script type="text/javascript">
function ax_edit_permasalahan(id_LampPermasalahan)
{
  $.ajax({
    url: '../library/ax_permasalahan.php',
    data: 'id_LampPermasalahan='+id_LampPermasalahan,
    type: "post", 
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#subkegiatan').html(response);
        }
    });
}


</script>