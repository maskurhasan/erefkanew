<?php
include "../config/koneksi.php";
include "../config/fungsi.php";
include "../config/fungsi_indotgl.php";
include "../config/errormode.php";


$postur = $_POST['id_SubKegiatan'];
$postur1 = $_POST['id_LampPermasalahan'];
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
  //data ditampilkan dari table
  $q = mysql_query('SELECT * FROM subkegiatan WHERE id_SubKegiatan = "'.$postur.'"');
  $r = mysql_fetch_array($q);
  $nmtombol = "masalah";
}


                  echo '<div class="widget-box">
                          <div class="widget-header">
                            <h5 class="widget-title">Permasalahan</h5>

                            <div class="widget-toolbar">
                              <div class="widget-menu">
                                <a href="#" data-action="settings" data-toggle="dropdown">
                                  <i class="ace-icon fa fa-bars"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right dropdown-light-blue dropdown-caret dropdown-closer">
                                  <li>
                                    <a data-toggle="tab" href="#dropdown1">Option#1</a>
                                  </li>

                                  <li>
                                    <a data-toggle="tab" href="#dropdown2">Option#2</a>
                                  </li>
                                </ul>
                              </div>

                              <a href="#" data-action="fullscreen" class="orange2">
                                <i class="ace-icon fa fa-expand"></i>
                              </a>

                              <a href="#" data-action="reload">
                                <i class="ace-icon fa fa-refresh"></i>
                              </a>

                              <a href="#" data-action="collapse">
                                <i class="ace-icon fa fa-chevron-up"></i>
                              </a>

                              <a href="#" data-action="close">
                                <i class="ace-icon fa fa-times"></i>
                              </a>
                            </div>
                          </div>

                          <div class="widget-body">
                            <div class="widget-main">';
                            //isi mulai

/*                            echo "<table>
                                    <tr>
                                      <th>Permasalahan</th>
                                      <th>Solusi</th>
                                      <th>Tanggal</th>
                                    </tr>
                                    <tr>

                                    </tr>
                                  </table>"
*/


echo '<div class="card">
              <div class="content">';
              echo "<form method=post action='modul/act_modrealisasi.php?module=realisasi&act=masalah'>";
                  echo '<div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Tanggal</label>
                        <input class="date-picker" data-date-format="yyyy-mm-dd"  type="text" name="Tanggal" class="form-control" value="'.$ri['Tanggal'].'" placeholder="Tanggal">
                      </div>        
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Permasalahan</label>
                        <textarea class="form-control" name="nm_Permasalahan">'.$ri['nm_Permasalahan'].'</textarea>
                      </div>        
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Solusi</label><br />
                        <textarea class="form-control" name="nm_Solusi">'.$ri['nm_Solusi'].'</textarea>
                        <p>
                          <button type="submit" class="btn btn-info btn-fill btn-sm form-control pull-right" name="'.$nmtombol.'" value="simpan"><i class="fa fa-save"></i> Simpan</button>
                          <input type="hidden" name="id_SubKegiatan" value="'.$r['id_SubKegiatan'].'">
                          <input type="hidden" name="id_DataKegiatan" value="'.$r['id_DataKegiatan'].'">
                          <input type="hidden" name="id_LampPermasalahan" value="'.$ri['id_LampPermasalahan'].'">
                          </p>
                      </div>        
                    </div>
                  </div>
                  </form>
                  <form method=post action="modul/act_modrealisasi.php?module=realisasi&act=masalah">
                   <input type="hidden" name="id_DataKegiatan" value="'.$r['id_DataKegiatan'].'">
                  <div class="row">
                    <div class="col-md-4">
                      
                    </div>
                  </div>';


                $qc = mysql_query("SELECT * FROM lamppermasalahan a, subkegiatan b 
                                WHERE b.id_SubKegiatan = '$r[id_SubKegiatan]' 
                                AND a.id_SubKegiatan = b.id_SubKegiatan 
                                ORDER BY a.Tanggal DESC");
                $no=1;
                echo "<hr>";
                while($rt=mysql_fetch_array($qc)) {
                $id_sub = $rt['id_SubKegiatan'];
                echo '
                <div class="row">
                  <div class="col-md-12">
                    
                    <div class="typo-line">      
                        <blockquote> 
                          <p class="category"><strong>Permasalahan</strong> : '.$rt['nm_Permasalahan'].'<hr>';
                                              echo "<strong>Solusi </strong>: ".$rt['nm_Solusi'].'<br>';
                          echo "<button class='btn btn-xs btn-info btn-fill btn-minier' type='button' name='edit' value=$rt[id_LampPermasalahan] id=id_lamppermasalahan onClick='ax_edit_permasalahan(this.value)'><i class='fa fa-pencil'></i> Edit</button> "; 
                          echo '<button class="btn btn-xs btn-danger btn-fill btn-minier" type="submit" name="delete" value="'.$rt['id_LampPermasalahan'].'" onclick="return confirm(\'yakin akan Hapus data\');"><i class="fa fa-trash"></i> Hapus</button></p>
                          <small>'.tgl_indo($rt['Tanggal']).'</small>
                        </blockquote>
                    </div>
                    
                  </div>
                </div>';
                }
                echo '<div class="footer">
                  
                </div>
              </form>
              </div>
              </div>';



                            //isi akhir
                            echo '</div>
                          </div>
                        </div>';



?>
<script type="text/javascript">
function ax_edit_permasalahan(id_LampPermasalahan)
{
  $.ajax({
    url: 'library/ax_permasalahan.php',
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