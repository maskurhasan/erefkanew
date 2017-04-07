<?php
session_start();
include "../config/koneksi.php";
include "../config/fungsi.php";
//include "../config/errormode.php";

//mengambil data desa
$postur = $_POST['id_Cetak'];


echo '<div class="card">
        <div class="header">
          <h4 class="title">Pilih Detail Laporan</h4>
          <p class="category"></p>
        </div>
        <div class="content">';
switch ($postur) {
    case 'rfkall':
      echo "<form class='form-horizontal' method=get target='_blank' action='report/rfkadmin.php'>";
                        echo '<div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Urusan</label>
                            <div class="col-sm-4">';
                            echo "<select class='form-control' name=id_Urusan placeholder=pilih Urusan id=id_Urusan onchange='pilih_Urusan(this.value);'>
                                  <option selected>Pilih Urusan</option>";
                                  $q=mysql_query("SELECT * FROM urusan");
                                  while ($r=mysql_fetch_array($q)) {
                                    echo "<option value=$r[id_Urusan]>$r[id_Urusan] $r[nm_Urusan]</option>";
                                  }
                            echo '</select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Bidang</label>
                            <div class="col-sm-4">';
                              echo "<select class='form-control' name=id_BidUrusan  placeholder=pilih Urusan id=id_BidUrusan onchange='pilih_BidUrusan(this.value);'>
                                <option value=#>Pilih Bid.Urusan</option></select>";
                              echo '</select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">SKPD</label>
                            <div class="col-sm-4">';
                              echo "<select class='form-control' name=id_Skpd id=id_Skpd onchange=''>
                                <option value=#>Pilih SKPD</option></select>";
                              echo '</select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Bulan</label>
                            <div class="col-sm-4">';
                              echo "<select class='form-control' name=bulan id=nm_Bulan onchange='pilih_Kegiatan(this.value);'>
                                <option value=''>Pilih Bulan</option>";
                                for ($i=1; $i <= 12 ; $i++) { 
                                  echo "<option value='$i'>$arrbln[$i]</option>";
                                }
                              echo '</select>
                            </div>
                          </div>
                <hr>
                <div class="clearfix form-actions">
                  <input class="btn btn-primary btn-fill" type="submit" name="cetak" value=Cetak />
                  <button type="submit" class="btn btn-success btn-fill" name="excel" value="excel"><i class="fa fa-file-text"></i> Excel</button>
                  <input class="btn btn-primary btn-fill" type="button" name="view" id="id_Cetak" value=view  onClick="ax_form_view(this.value)"/>
                  <input class="btn btn-success btn-fill" type="reset" value=Reset />
                </div>
              </form>';
    break;
    case 'rekapskpd':
      echo "<form class='form-horizontal' method=get target='_blank' action='report/rpt_rekapskpd.php'>";
                        echo '<div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Urusan</label>
                            <div class="col-sm-4">';
                            echo "<select class='form-control' name=id_Urusan placeholder=pilih Urusan id=id_Urusan onchange='pilih_Urusan(this.value);'>
                                  <option selected>Pilih Urusan</option>";
                                  $q=mysql_query("SELECT * FROM urusan");
                                  while ($r=mysql_fetch_array($q)) {
                                    echo "<option value=$r[id_Urusan]>$r[id_Urusan] $r[nm_Urusan]</option>";
                                  }
                            echo '</select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Bidang</label>
                            <div class="col-sm-4">';
                              echo "<select class='form-control' name=id_BidUrusan  placeholder=pilih Urusan id=id_BidUrusan onchange='pilih_BidUrusan(this.value);'>
                                <option value=#>Pilih Bid.Urusan</option></select>";
                              echo '</select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">SKPD</label>
                            <div class="col-sm-4">';
                              echo "<select class='form-control' name=id_Skpd id=id_Skpd onchange=''>
                                <option value=#>Pilih SKPD</option></select>";
                              echo '</select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Bulan</label>
                            <div class="col-sm-4">';
                              echo "<select class='form-control' name=bulan id=nm_Bulan onchange='pilih_Kegiatan(this.value);'>
                                <option value=''>Pilih Bulan</option>";
                                for ($i=1; $i <= 12 ; $i++) { 
                                  echo "<option value='$i'>$arrbln[$i]</option>";
                                }
                              echo '</select>
                            </div>
                          </div>
                <hr>
                <div class="clearfix form-actions">
                  <input class="btn btn-primary btn-fill" type="submit" name="cetak" value=Cetak />
                  <button type="submit" class="btn btn-success btn-fill" name="excel" value="excel"><i class="fa fa-file-text"></i> Excel</button>
                  <input class="btn btn-primary btn-fill" type="button" name="view" id="id_Cetak" value=view  onClick="ax_form_view(this.value)"/>
                  <input class="btn btn-success btn-fill" type="reset" value=Reset />
                </div>
              </form>';
  break;
	case 'rfkmodel2':
      echo "<form method=get class='form-horizontal' action='report/rfkmodel2.php' target='_blank'>
              <div class=form-group>
                <label class='col-sm-2 control-label'>Kecamatan</label>
                <div class='col-sm-4'>
                  <select class='form-control' name=id_Kecamatan placeholder=Kecamatan id=id_Kecamatan onchange='pilih_kecamatan(this.value);'>
                    <option value='' selected>Kecamatan</option>";
                    $qx=mysql_query("SELECT * FROM kecamatan");
                    while ($rx=mysql_fetch_array($qx)) {
                      echo "<option value=$rx[id_Kecamatan]>$rx[nm_Kecamatan]</option>";
                    }
                  echo "</select>
                </div>
                <label class='col-sm-2 control-label'>Desa</label>
                <div class='col-sm-4'>
                  <select class='form-control'  name=id_Desa placeholder=Desa id=id_Desa onchange=''></select>
                </div>
              </div>";


              echo '<div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Bulan</label>
                <div class="col-sm-4">';
                  echo "<select class=form-control name=bulan>
                    <option value='0'>Pilih Bulan</option>";
                    foreach ($arrbln as $key => $value) {
                      echo "<option value=$key>$key $value</option>";
                    }
                  echo '</select>
                </div>
                <label for="inputPassword3" class="col-sm-2 control-label">PPK</label>
                <div class="col-sm-4">';
                  echo "<select class=form-control name=id_Ppk>
                    <option value='0'>Pilih PPK</option>";
                    if($_SESSION['UserLevel']==3) {
						$q=mysql_query("SELECT id_User,nm_Lengkap
                                      FROM user
                                      WHERE UserLevel = '$_SESSION[UserLevel]'
                                      AND id_Skpd = '$_SESSION[id_Skpd]'
                                      AND statusppk = 1
                                      AND Aktiv = 1");
					} else {
						$q=mysql_query("SELECT id_User,nm_Lengkap
                                      FROM user
                                      WHERE id_Skpd = '$_SESSION[id_Skpd]'
                                      AND statusppk = 1
                                      AND Aktiv = 1");
					}
                    while ($r=mysql_fetch_array($q)) {
                      echo "<option value=$r[id_User]>$r[nm_Lengkap]</option>";
                    }
                  echo '</select>
                </div>
              </div><hr>
              <div class="clearfix form-actions">
                  <input class="btn btn-primary btn-fill" type="submit" name="cetak" value=Cetak />
                  <button type="submit" class="btn btn-success btn-fill" name="excel" value="excel"><i class="fa fa-file-text"></i> Excel</button>
                  <input class="btn btn-primary btn-fill" type="button" name="view" id="id_Cetak" value=view  onClick="ax_form_view(this.value)"/>
                  <input class="btn btn-success btn-fill" type="reset" value=Reset />
                </div>
            </form>';
    break;
    case 'rfkviareaslisasi2':
        echo "<form method=get class='form-horizontal' action='report/rfkviarealisasi2.php' target='_blank'>
              <div class=form-group>
                <label class='col-sm-2 control-label'>Kecamatan</label>
                <div class='col-sm-4'>
                  <select class='form-control' name=id_Kecamatan placeholder=Kecamatan id=id_Kecamatan onchange='pilih_kecamatan(this.value);' required>
                    <option selected>Kecamatan</option>";
                    $qx=mysql_query("SELECT * FROM kecamatan");
                    while ($rx=mysql_fetch_array($qx)) {
                      echo "<option value=$rx[id_Kecamatan]>$rx[nm_Kecamatan]</option>";
                    }
                  echo "</select>
                </div>
                <label class='col-sm-2 control-label'>Desa</label>
                <div class='col-sm-4'>
                  <select class='form-control'  name=id_Desa placeholder=Desa id=id_Desa onchange=''></select>
                </div>
              </div>";
              echo '<div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Bulan</label>
                <div class="col-sm-4">';
                  echo "<select class=form-control name=bulan>
                    <option value=0>Pilih Bulan</option>";
                    foreach ($arrbln as $key => $value) {
                      echo "<option value=$key>$key $value</option>";
                    }
                  echo '</select>
                </div>
                <label for="inputPassword3" class="col-sm-2 control-label">PPK</label>
                <div class="col-sm-4">';
                  echo "<select class=form-control name=id_Ppk>
                    <option value=0>Pilih PPK</option>";
                    $q=mysql_query("SELECT id_User,nm_Lengkap
                                      FROM user
                                      WHERE UserLevel = '$_SESSION[UserLevel]'
                                      AND id_Skpd = '$_SESSION[id_Skpd]'
                                      AND statusppk = 1
                                      AND Aktiv = 1");
                    while ($r=mysql_fetch_array($q)) {
                      echo "<option value=$r[id_User]>$r[nm_Lengkap]</option>";
                    }
                  echo '</select>
                </div>
              </div>
              <div class="clearfix form-actions">
                  <input class="btn btn-primary btn-fill" type="submit" name="cetak" value=Cetak />
                  <input class="btn btn-primary btn-fill" type="submit" name="view" value=view />
                  <input class="btn btn-success btn-fill" type="reset" value=Reset />
                </div>
            </form>';
    break;
    case 'perkeg':
        echo "<form method=get class='form-horizontal' action='report/rpt_perkeg.php' target='_blank'>
              <div class=form-group>
                <label class='col-sm-2 control-label'>Kecamatan</label>
                <div class='col-sm-4'>
                  <select class='form-control' name=id_Kecamatan placeholder=Kecamatan id=id_Kecamatan onchange='pilih_kecamatan(this.value);' required>
                    <option selected>Kecamatan</option>";
                    $qx=mysql_query("SELECT * FROM kecamatan");
                    while ($rx=mysql_fetch_array($qx)) {
                      echo "<option value=$rx[id_Kecamatan]>$rx[nm_Kecamatan]</option>";
                    }
                  echo "</select>
                </div>
                <label class='col-sm-2 control-label'>Desa</label>
                <div class='col-sm-4'>
                  <select class='form-control'  name=id_Desa placeholder=Desa id=id_Desa onchange=''></select>
                </div>
              </div>";
              echo '<div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Bulan</label>
                <div class="col-sm-4">';
                  echo "<select class=form-control name=bulan>
                    <option value=0>Pilih Bulan</option>";
                    foreach ($arrbln as $key => $value) {
                      echo "<option value=$key>$key $value</option>";
                    }
                  echo '</select>
                </div>
                <label for="inputPassword3" class="col-sm-2 control-label">PPK</label>
                <div class="col-sm-4">';
                  echo "<select class=form-control name=id_Ppk>
                    <option value=0>Pilih PPK</option>";
                    $q=mysql_query("SELECT id_User,nm_Lengkap
                                      FROM user
                                      WHERE UserLevel = '$_SESSION[UserLevel]'
                                      AND id_Skpd = '$_SESSION[id_Skpd]'
                                      AND statusppk = 1
                                      AND Aktiv = 1");
                    while ($r=mysql_fetch_array($q)) {
                      echo "<option value=$r[id_User]>$r[nm_Lengkap]</option>";
                    }
                  echo '</select>
                </div>
              </div>
              <div class="clearfix form-actions">
                  <input class="btn btn-primary btn-fill" type="submit" name="cetak" value=Cetak />
                  <input class="btn btn-primary btn-fill" type="submit" name="view" value=view />
                  <input class="btn btn-success btn-fill" type="reset" value=Reset />
                </div>
            </form>';
    break;
    case 'rekapkec':
        echo "<form method=get class='form-horizontal' action='report/rpt_realisasibylokasi.php' target='_blank'>
              <div class=form-group>
                <label class='col-sm-2 control-label'>Kecamatan</label>
                <div class='col-sm-4'>
                  <select class='form-control' name=id_Kecamatan placeholder=Kecamatan id=id_Kecamatan onchange='pilih_kecamatan(this.value);' required>
                    <option selected>Kecamatan</option>";
                    $qx=mysql_query("SELECT * FROM kecamatan");
                    while ($rx=mysql_fetch_array($qx)) {
                      echo "<option value=$rx[id_Kecamatan]>$rx[nm_Kecamatan]</option>";
                    }
                  echo "</select>
                </div>
                <label class='col-sm-2 control-label'>Desa</label>
                <div class='col-sm-4'>
                  <select class='form-control'  name=id_Desa placeholder=Desa id=id_Desa onchange=''></select>
                </div>
              </div>";
              echo '<div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">Bulan</label>
                <div class="col-sm-4">';
                  echo "<select class=form-control name=bulan>
                    <option value=0>Pilih Bulan</option>";
                    foreach ($arrbln as $key => $value) {
                      echo "<option value=$key>$key $value</option>";
                    }
                  echo '</select>
                </div>
                <label for="inputPassword3" class="col-sm-2 control-label">PPK</label>
                <div class="col-sm-4">';
                  echo "<select class=form-control name=id_Ppk>
                    <option value=0>Pilih PPK</option>";
                    $q=mysql_query("SELECT id_User,nm_Lengkap
                                      FROM user
                                      WHERE UserLevel = '$_SESSION[UserLevel]'
                                      AND id_Skpd = '$_SESSION[id_Skpd]'
                                      AND statusppk = 1
                                      AND Aktiv = 1");
                    while ($r=mysql_fetch_array($q)) {
                      echo "<option value=$r[id_User]>$r[nm_Lengkap]</option>";
                    }
                  echo '</select>
                </div>
              </div>
              <div class="clearfix form-actions">
                  <input class="btn btn-primary btn-fill" type="submit" name="cetak" value=Cetak />
                  <input class="btn btn-primary btn-fill" type="submit" name="view" value=view />
                  <input class="btn btn-success btn-fill" type="reset" value=Reset />
                </div>
            </form>';
    break;
    case 'profilkeg':
              echo "<form class='form-horizontal' method=get action='modul/report/coba.php'>";
                        echo '<div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Kegiatan</label>
                            <div class="col-sm-4">';
                            echo '<select class="form-control" name="id_DataKegiatan" id="id_DataKegiatan" onchange="pilih_Subkeg(this.value);">
                                  <option value="">Pilih Kegiatan</option>';
                                  $q=mysql_query("SELECT a.nm_Kegiatan,id_DataKegiatan  
                                                  FROM kegiatan a, datakegiatan b   
                                                  WHERE a.id_Kegiatan = b.id_Kegiatan 
                                                  AND b.id_Skpd = '$_SESSION[id_Skpd]' 
                                                  AND b.TahunAnggaran = '$_SESSION[thn_Login]'");
                                  while ($r=mysql_fetch_array($q)) {
                                    echo "<option value='$r[id_DataKegiatan]'>$r[nm_Kegiatan]</option>";
                                  }
                            echo '</select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Sub. Kegiatan</label>
                            <div class="col-sm-4">';
                            echo "<select class='form-control' name=id_SubKegiatan id='id_SubKegiatan' onchange='pilih_Profkeg(this.value)'>
                                    <option value=''>Pilih Sub Kegiatan</option>";
                            echo '</select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Bulan</label>
                            <div class="col-sm-4">';
                              echo "<select class=form-control name=bulan>
                              <option value=0>Semua Bulan</option>";
                              foreach ($arrbln as $key => $value) {
                                echo "<option value=$key>$key $value</option>";
                              }
                            echo '</select>
                            </div>
                          </div>
                      </form><hr>';
            echo "<div id=charts>";
            echo "</div>";
            echo '<div class="clearfix form-actions">
                  <input class="btn btn-primary btn-fill" type="submit" name="cetak" value=Cetak />
                  <input class="btn btn-primary btn-fill" type="submit" name="view" value=view />
                  <input class="btn btn-success btn-fill" type="reset" value=Reset />
                </div>
              </form>';
     break;
    case 'peta':
        //untuk tampilkan peta
        echo '<iframe src="https://www.google.com/maps/d/embed?mid=zxNMsvBDrM3w.kIxx4ejWeDRU" width="640" height="480"></iframe>';
     break;
     case 'chart':
        //untuk tampilkan chart
        include "../report/chartmodel.php";

     break;
     case 'ringkasan':
        $qc = mysql_query("SELECT a.apbd,a.apbn,a.dak,SUM(b.AnggKeg) AS Anggaran
                    FROM skpd a, datakegiatan b
                    WHERE a.id_Skpd = '$_SESSION[id_Skpd]'
                    AND b.TahunAnggaran = '$_SESSION[thn_Login]'
                    AND a.id_Skpd = b.id_Skpd");
        $rc = mysql_fetch_array($qc);

        $qd = mysql_query("SELECT SUM(c.nl_Pagu) AS AnggaranSub
                    FROM skpd a,datakegiatan b,subkegiatan c
                    WHERE a.id_Skpd = '$_SESSION[id_Skpd]'
                    AND b.TahunAnggaran = '$_SESSION[thn_Login]'
                    AND a.id_Skpd = b.id_Skpd
                    AND b.id_DataKegiatan = c.id_DataKegiatan");
        $rd = mysql_fetch_array($qd);
        echo "<h3>Dinas Pekerjaan Umum</h3>";
        echo "<table class='table table-bordered' width=700px>
                <thead><tr><th rowspan=2></th><th rowspan=2>Anggaran</th><th colspan=2>Target</th><th colspan=2>Realisasi</th></tr>
                <tr>
                  <th>Fisik</th><th>Keuangan</th>
                  <th>Fisik</th><th>Keuangan</th></tr></thead>
                <tbody>
                <tr><td>APBD</td><td>".number_format($rc[apbd])."</td><td>".number_format($rc[Anggaran])."</td><td>".number_format($rd[AnggaranSub])."</td><td>xxx</td><td>Selisih</td></tr>
                <tr><td>DAK</td><td>".number_format($rc[dak])."</td><td>xxx</td><td>xxx</td><td>xxx</td><td>Selisih</td></tr>
                <tr><td>APBN</td><td>".number_format($rc[apbn])."</td><td>xxx</td><td>xxx</td><td>xxx</td><td>Selisih</td></tr>
                </tbody>
                </table>";
        echo "<div class='row'>
          <div class='col-sm-6'>
            
          </div>
        </div>";
     break;

   default:
              echo "<form class='form-horizontal' method=get action='modul/report/coba.php'>";
                        echo '<div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Urusan</label>
                            <div class="col-sm-4">';
                            echo "<select class='form-control' name=id_Urusan placeholder=pilih Urusan id=id_Urusan onchange='pilih_Urusan(this.value);'>
                                  <option selected>Pilih Urusan</option>";
                                  $q=mysql_query("SELECT * FROM urusan");
                                  while ($r=mysql_fetch_array($q)) {
                                    echo "<option value=$r[id_Urusan]>$r[id_Urusan] $r[nm_Urusan]</option>";
                                  }
                            echo '</select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Bidang</label>
                            <div class="col-sm-4">';
                              echo "<select class='form-control' name=id_BidUrusan  placeholder=pilih Urusan id=id_BidUrusan onchange='pilih_BidUrusan(this.value);'>
                                <option value=#>Pilih Bid.Urusan</option></select>";
                              echo '</select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">SKPD</label>
                            <div class="col-sm-4">';
                              echo "<select class='form-control' name=id_Skpd id=id_Skpd onchange=''>
                                <option value=#>Pilih SKPD</option></select>";
                              echo '</select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Bulan</label>
                            <div class="col-sm-4">';
                              echo "<select class=form-control name=bulan>
                              <option value=0>Semua Bulan</option>";
                              foreach ($arrbln as $key => $value) {
                                echo "<option value=$key>$key $value</option>";
                              }
                            echo '</select>
                            </div>
                          </div>
                      </form>
                <div class="clearfix form-actions">
                  <input class="btn btn-primary btn-fill pull-right" type="submit" name="cetak" value=Cetak />
                  <input class="btn btn-success btn-fill" type="reset" value=Reset />
                </div>
              </form>';
     break;
}
echo '</div>
      </div>
      <div class="row">
        <div class="col-md-10" id="view">
        </div>
      </div>';

?>
<script type="text/javascript">
function ax_form_view(id_View)
{
  $.ajax({
    url: '../library/ax_formcetak.php',
    data: 'id_Cetak='+id_Cetak,
    type: "post",
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#view').html(response);
        }
    });
}

function pilih_Urusan(id_Urusan)
{
  $.ajax({
        url: 'library/bidangurusan.php',
        data : 'id_Urusan='+id_Urusan,
    type: "post",
        dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#id_BidUrusan').html(response);
        }
    });
}

function pilih_BidUrusan(id_BidUrusan)
{
  $.ajax({
        url: 'library/skpd.php',
        data : 'id_BidUrusan='+id_BidUrusan,
    type: "post",
        dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#id_Skpd').html(response);
        }
    });
}

function pilih_Program(id_Program)
{
  $.ajax({
        url: 'library/kegiatan.php',
        data : 'id_Program='+id_Program,
    type: "post",
        dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#id_Kegiatan').html(response);
        }
    });
}



function pilih_Kegiatan(id_Kegiatan)
{
  $.ajax({
        url: 'library/nm_kegiatan.php',
        data : 'id_Kegiatan='+id_Kegiatan,
    type: "post",
        dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#nm_Kegiatan').html(response);
        }
    });
}

function pilih_Subkeg(id_DataKegiatan)
{
  $.ajax({
        url: 'library/vw_subkegiatan.php',
        data : 'id_DataKegiatan='+id_DataKegiatan,
        type: "post",
        dataType: "html",
        timeout: 10000,
        success: function(response){
          $('#id_SubKegiatan').html(response);
        }
    });
}

function pilih_Profkeg(id_SubKegiatan)
{
  $.ajax({
        url: 'library/vw_profkeg.php',
        data : 'id_SubKegiatan='+id_SubKegiatan,
    type: "post",
        dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#charts').html(response);
        }
    });
}




</script>
