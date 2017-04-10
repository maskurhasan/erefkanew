<?php
session_start();

if (empty($_SESSION[UserName]) AND empty($_SESSION[PassWord])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {
$cek=user_akses($_GET['module'],$_SESSION['id_User']);
if($cek==1 OR $_SESSION['UserLevel']=='1') {
//----------------------------------
//include "config/koneksi.php";
//include "config/fungsi.php";
include "config/pagination.php";

  switch ($_GET[act]) {
    default:

          echo '<div class="col-md-12">
              <div class="card">
                <div class="header">
                    <div class="row">
                      <div class="col-md-6"></div>
                      <div class="col-md-6">
                        <form class="" method=get action="'.$_SERVER['PHPSELF'].'">
                        <div class="input-group pull-right" style="width: 350px;">
                          <input type="hidden" name="module" value="'.$_GET[module].'">
                          <input type="hidden" name="t" value="nm">
                          <input type="text" name="q" class="form-control" placeholder="Search">
                          <div class="input-group-btn">
                            <button class="btn btn-sm btn-info btn-fill"><i class="fa fa-search"></i> Cari</button>';
                            //echo "<button class='btn btn-sm btn-warning btn-fill' name='tambahsubdak' onClick=\"window.location.href='?module=kegiatan&act=add'\"><i class='fa fa-plus'></i> Tambah Kegiatan</button>";
                          echo '</div>
                          </div>
                    </div>
                    </div>
                </div><!-- /.box-header -->
                <div class="content table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered table-hover">
                        <thead>
                          <tr>
                          <th>#</th>
                          <th>Kode</th><th style=width:30%>Nama Kegiatan</th><th>Anggaran</th><th>PPTK</th>
                          <th></th>
                          </tr>
                        </thead>
                        <tbody>';
                          $page = 1;
                          if (isset($_GET['page']) && !empty($_GET['page']))
                              $page = (int)$_GET['page'];
                          $q = $_GET['q'];
                          $t = $_GET['t'];
                          if($_GET['t'] == 'nm') {
                            $nmkeg = "AND b.nm_Kegiatan LIKE '%$q%' ";
                          } elseif($_GET['t']=='kode') {
                            $kode = "AND a.id_Kegiatan = '$q' ";
                          }

                          if($_SESSION['UserLevel']==3) {
                            $sql = "SELECT b.nm_Kegiatan,a.id_DataKegiatan,a.id_Kegiatan,a.AnggKeg,c.nm_Lengkap
                                                      FROM kegiatan b, datakegiatan a, user c
                                                      WHERE a.id_Skpd = '$_SESSION[id_Skpd]'
                                                      AND a.id_Kegiatan = b.id_Kegiatan
                                                      AND a.TahunAnggaran = '$_SESSION[thn_Login]'
                                                      AND a.id_Pptk = '$_SESSION[id_User]'
                                                      AND a.id_Pptk = c.id_User
                                                      $nmkeg $kode ORDER BY b.id_Program ASC";
                          } elseif($_SESSION['UserLevel']==2) {
                            $sql = "SELECT b.nm_Kegiatan,a.id_DataKegiatan,a.id_Kegiatan,a.AnggKeg,c.nm_Lengkap
                                                      FROM kegiatan b, datakegiatan a
                                                      LEFT JOIN user c
                                                      ON a.id_Pptk = c.id_User
                                                      WHERE a.id_Skpd = '$_SESSION[id_Skpd]'
                                                      AND a.id_Kegiatan = b.id_Kegiatan
                                                      AND a.TahunAnggaran = '$_SESSION[thn_Login]'
                                                      $nmkeg $kode ORDER BY b.id_Program ASC";
                          } else {
                            $sql = "SELECT b.nm_Kegiatan,a.id_DataKegiatan,a.id_Kegiatan,a.AnggKeg,c.nm_Lengkap
                                                      FROM kegiatan b, datakegiatan a
                                                      LEFT JOIN user c
                                                      ON a.id_Pptk = c.id_User
                                                      WHERE a.id_Skpd = '$_SESSION[id_Skpd]'
                                                      AND a.id_Kegiatan = b.id_Kegiatan
                                                      AND a.TahunAnggaran = '$_SESSION[thn_Login]'
                                                      $nmkeg $kode ORDER BY b.id_Program ASC";
                          }

                          $dataTable = getTableData($sql, $page);
                          //$query=mysql_query($sql);
                          //$no = 1;
                          //while($dt=mysql_fetch_array($query))
                          foreach ($dataTable as $i => $dt)
                          {
                          $no = ($i + 1) + (($page - 1) * 10);
                          $no % 2 === 0 ? $alt="alt" : $alt="";
                                echo "<tr class=$alt><td>".$no++."</td>
                                        <td>$dt[id_Kegiatan]</td>
                                        <td>$dt[nm_Kegiatan]</td>
                                        <td align=left>".number_format($dt[AnggKeg])."</td>
                                        <td>$dt[nm_Lengkap]</td>
                                        <td class=align-center>";
                                          echo "<a class='btn btn-minier btn-primary btn-fill' href='?module=subkegiatan&act=sub&id=$dt[id_DataKegiatan]'><i class='fa fa-list'></i>  Sub Kegiatan</a>
                                                <!--<a href='?module=subkegiatan&act=editx&id=$dt[id_DataKegiatan]'><i class='fa fa-edit fa-lg'></i> Edit</a> -->";
                                          echo '<!--<a href="modul/act_moddatakegiatan.php?module=subkegiatan&act=delete&id='.$dt[id_DataKegiatan].'" onclick="return confirm(\'Yakin untuk menghapus data ini?\')"><i class="fa fa-trash-o fa-lg"></i> Hapus</a>-->';
                                          echo "</td>
                                        </tr>";
                          }
                        echo '</tbody></table>
                   <div class="">';
                  showPagination2($sql);
                echo '</div>
                </div>
            </div>
            </div>';
    break;
    case "sub":
          $sql = mysql_query("SELECT c.nm_Program, b.nm_Kegiatan,a.*,d.nm_Lengkap
                              FROM kegiatan b, program c,datakegiatan a
                              LEFT JOIN user d
                              ON a.id_Pptk = d.id_User
                              WHERE a.id_DataKegiatan = '$_GET[id]'
                              AND a.id_Kegiatan = b.id_Kegiatan
                              AND b.id_Program = c.id_Program
                              AND a.id_Skpd = '$_SESSION[id_Skpd]'");
          $r=mysql_fetch_array($sql);
          function hitselisih($pagu,$id_Skpd,$id_DataKegiatan) {
            $q =  mysql_query("SELECT SUM(b.nl_Pagu) AS totalnlpagu
                                      FROM datakegiatan a,subkegiatan b
                                      WHERE a.id_DataKegiatan = b.id_DataKegiatan
                                      AND a.id_Skpd = '$id_Skpd' AND a.id_DataKegiatan = '$id_DataKegiatan'");
            $r = mysql_fetch_array($q);
            $jml = $pagu - $r[totalnlpagu];
            return $jml;
          }
          echo '<div class="col-md-12">
                <div class="profile-user-info profile-user-info-striped">
                  <div class="profile-info-row">
                    <div class="profile-info-name"> Program </div>
                    <div class="profile-info-value">
                      '.$r[nm_Program].'
                    </div>
                  </div>
                  <div class="profile-info-row">
                    <div class="profile-info-name"> Kegiatan</div>
                    <div class="profile-info-value">
                      '.$r[nm_Kegiatan].'
                    </div>
                  </div>
                  <div class="profile-info-row">
                    <div class="profile-info-name"> PPTK </div>
                    <div class="profile-info-value">
                      '.$r[nm_Lengkap].'
                    </div>
                  </div>
                  <div class="profile-info-row">
                    <div class="profile-info-name"> Anggaran </div>
                    <div class="profile-info-value"> Rp.
                      '.number_format($r[AnggKeg]).'
                    </div>
                  </div>
                </div>
                </div>';

                echo '<p>&nbsp;</p>';

                $sql = mysql_query("SELECT b.nm_SubKegiatan,b.nl_Pagu,b.id_SubKegiatan
                                      FROM datakegiatan a,subkegiatan b
                                      WHERE a.id_DataKegiatan = b.id_DataKegiatan AND a.id_Skpd = '$_SESSION[id_Skpd]' AND a.id_DataKegiatan = '$_GET[id]'");
                $hit = mysql_num_rows($sql);
                if($hit < 1) {
                  echo "<p>Tidak ada data, silahkan <a href=?module=subkegiatan&act=add&id=$_GET[id]>Entry Data Baru</a></p>";
                  //echo "Belum ada data";
                } else {


                  echo '<div class="col-md-12">
                      <div class="card">
                        <div class="header">
                            <div class="row">
                              <div class="col-md-6"></div>
                              <div class="col-md-6">
                                <form class="" method=get action="'.$_SERVER['PHPSELF'].'">
                                <div class="input-group pull-right" style="width: 350px;">
                                  <input type="text" name="table_search" class="form-control" placeholder="Search">
                                  <div class="input-group-btn">
                                    <button class="btn btn-sm btn-info btn-fill"><i class="fa fa-search"></i> Cari</button>';
                                    echo "<button class='btn btn-primary btn-sm btn-fill' type='button' name='tambahsubdak' id='tomboltambahsub' onClick=\"window.location.href='?module=subkegiatan&act=add&id=$_GET[id]'\"><i class='fa fa-plus'></i> Tambah</button>";
                                  echo '</div>
                                  </div>
                            </div>
                            </div>
                        </div><!-- /.box-header -->
                      <div class="content table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered table-hover">
                          <thead>
                          <tr>
                            <th style=width:5%>#</th>
                            <th>Nama Kegiatan</th><th>PAGU(Rp.)</th><th>Aksi</th>
                          </tr>
                          </thead>
                          <tbody>';
                            $no=1;
                            while($dt = mysql_fetch_array($sql)) {
                             //$no % 2 === 0 ? $alt="alt" : $alt="";
                              echo "<tr><td>".$no++."</td>
                                      <td>$dt[nm_SubKegiatan]</td>
                                      <td align=right>".number_format($dt['nl_Pagu'])."</td>
                                      <td class=align-center>
                                      <a class='btn btn-sm btn-fill btn-primary btn-minier' id=id_SubKegiatan href='?module=subkegiatan&act=edit&id=$dt[id_SubKegiatan]'><i class='fa fa-edit'></i> Edit</a>
                                      <a class='btn btn-sm btn-fill btn-success btn-minier' id=id_SubKegiatan href='?module=subkegiatan&act=trgfisik&id=$dt[id_SubKegiatan]'><i class='fa fa-edit'></i> Target</a>";
                                      echo '  <a id=id_SubKegiatanx class="btn btn-sm btn-fill btn-danger btn-minier" onClick="return confirm(\'Yakin Hapus data ini?\')" href="modul/act_modsubkegiatan.php?module=subkegiatan&act=deletexx&id='.$dt['id_SubKegiatan'].'&dk='.$_GET['id'].'"><i class="fa fa-trash-o"></i> Hapus</a>';
                                      echo "</td>
                                      </tr>";
                            }
                      echo "<tr class=alt>
                              <td>&nbsp;</td>
                              <td align=right>Selisih: </td>
                              <td align=right>".number_format(hitselisih($r['AnggKeg'],$_SESSION['id_Skpd'],$_GET['id']))."</td>
                              <td>&nbsp;</td>
                            </tr>
                            </tbody>";
                      echo "</table>";
                      }
                        echo '
                   <div class="">';
                  //showPagination2($sql);
                echo '</div>
                </div>
            </div>
            </div>';



  break;
	case "add":
      $sql = mysql_query("SELECT a.tr_Satu,a.tr_Dua,a.tr_Tiga,a.tr_Empat,
                                  b.trg_Keu1,b.trg_Keu2,b.trg_Keu3,b.trg_Keu4,
                                  a.AnggKeg,SUM(b.nl_Pagu) AS totalnlpagu
                          FROM datakegiatan a
                          LEFT JOIN subkegiatan b
                          ON a.id_DataKegiatan = b.id_DataKegiatan
                          WHERE a.id_DataKegiatan = '$_GET[id]'");
      $r=mysql_fetch_array($sql);
      //tanggal default pelaksanaan
      $tglawal = $_SESSION[thn_Login]."-01-01";
      $tglakhir = $_SESSION[thn_Login]."-12-31";
      $anggaran = $r['AnggKeg']-$r['totalnlpagu'];


      $r['JnsSubKeg']=='f' ? $cekk = "checked" : "";

      echo '<div class="col-md-10">
            <div class="card">
              <div class="content">';
                echo "<form class='form-horizontal' method=post id=frm_tambah action=".htmlspecialchars('modul/act_modsubkegiatan.php?module=subkegiatan&act=add').">";
                  echo '<div class="form-group">
                      <label class="col-sm-2 control-label">Nama Rincian</label>
                      <div class="col-sm-10">
                        <input class="form-control" type=text name="nm_SubKegiatan" id="nm_SubKegiatan" placeholder="Nama Rincian" size=50 required  value="'.$r[nm_SubKegiatan].'"><!--&nbsp;<input type="checkbox" name="JnsSubKeg" id="group1" value="f"> Fisik-->
                      </div>
                    </div>';
                  echo "<div class='form-group'>
                      <label class='col-sm-2 control-label'>Nilai PAGU</label>
                      <div class='col-sm-4'>
                        <input type=text class='form-control' name='nl_Pagu' placeholder='Nilai PAGU' value='$anggaran'>
                      </div>
                      <label class='col-sm-2 control-label'>Nilai Fisik</label>
                      <div class='col-sm-4'>
                        <input type=text class='form-control' name='nl_Fisik' placeholder='Nilai Fisik' value='$r[nl_Fisik]'>
                      </div>
                    </div>
                    <div class=form-group>
                      <label class='col-sm-2 control-label'>Nilai Kontrak</label>
                      <div class='col-sm-4'>
                        <input type=text class='form-control' name='nl_Kontrak' placeholder='Nilai Kontrak' value='$r[nl_Kontrak]'>
                      </div>
                      <label class='col-sm-2 control-label'>Volume</label>
                      <div class='col-sm-4'>
                        <input type=text class='form-control' name='jml_Volume' placeholder='Volume' required value='$r[jml_Volume]'>
                      </div>
                    </div>
                    <div class=form-group>
                      <label class='col-sm-2 control-label'>Alamat Lokasi/Tempat Pelaksanaan</label>
                      <div class='col-sm-10'>
                        <input type=text class='form-control' name='AlamatLokasi' placeholder='Alamat' value='$r[AlamatLokasi]' required>
                      </div>
                    </div>
                    <div class=form-group>
                      <label class='col-sm-2 control-label'>Kecamatan</label>
                      <div class='col-sm-4'>
                        <select class='form-control' name=id_Kecamatan placeholder=Kecamatan id=id_Kecamatan multiple='multiple' onchange='xpilih_kecamatan(this.value);' required>
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
                    </div>
                    <div class=form-group>
                      <label class='col-sm-2 control-label'>Kordinat Latitude</label>
                      <div class='col-sm-4'>
                        <input type='text' class='form-control' name='latitude' placeholder='Latitude'>
                      </div>
                      <label class='col-sm-2 control-label'>Kordinat Longitude</label>
                      <div class='col-sm-4'>
                        <input type='text' class='form-control' name='longitude' placeholder='Longitude'>
                      </div>
                    </div>
                    <div class=form-group>
                      <label class='col-sm-2 control-label'>Pelaksana</label>
                      <div class='col-sm-4'>
                        <input type='text' class='form-control' name='pelaksana2' id='pelaksana2' value='$r[Pelaksana]'>
                      </div>
                      <label class='col-sm-2 control-label'>Nomor Kontrak</label>
                      <div class='col-sm-4'>
                        <input type=text class='form-control' name='no_Kontrak' placeholder='Nomor Kontrak' value='$r[no_Kontrak]'>
                      </div>
                    </div>
                    <div class=form-group>
                      <label class='col-sm-2 control-label'>Kons. Perencana</label>
                      <div class='col-sm-4'>
                        <input type=text class='form-control' name='konsPerencana' placeholder='Kons. Perencana' value='$r[konsPerencana]'>
                      </div>
                      <label class='col-sm-2 control-label'>Kons. Pengawas</label>
                      <div class='col-sm-4'>
                        <input type=text class='form-control' name='konsPengawas' placeholder='Kons. Pengawas' value='$r[konsPengawas]'>
                      </div>
                    </div>
                    <div class=form-group>
                      <label class='col-sm-2 control-label'>Waktu Pengerjaan Mulai</label>
                      <div class='col-sm-4'>
                        <input type='date' class='date-picker' data-date-format='yyyy-mm-dd' name='tgl_Mulai' placeholder='tgl Mulai' value='$r[tgl_Mulai]'>
                      </div>
                      <label class='col-sm-2 control-label'>Waktu Selesai</label>
                      <div class='col-sm-4'>
                        <input type=date id='datepicker' class='date-picker' name='tgl_Selesai' data-date-format='yyyy-mm-dd' placeholder='tgl selesai' value='$r[tgl_Selesai]'>
                      </div>
                    </div>
                    <div class=form-group>
                      <label class='col-sm-2 control-label'>Target Fisik</label>
                      <div class='col-sm-10'>
                        <input type=text class='form-control required' name='trg_Fisik' placeholder='Fisik' value='$r[trg_Fisik]'>
                      </div>
                    </div>
                    <div class=form-group>
                      <label class='col-sm-2 control-label'>Target Keuangan Triwulan I</label>
                      <div class='col-sm-3'>";
                      //ini adalah nilai untuk Triwulan inisiasi nilai awal

                      $satu = $anggaran;//$r['tr_Satu']-$r['trg_Keu1'];
                      //$dua = $r['tr_Dua']-$r['trg_Keu2'];
                      //$tiga = $r['tr_Tiga']-$r['trg_Keu3'];
                      //$empat = $r['tr_Empat']-$r['trg_Keu4'];
                        echo "<input type=text class='form-control' name='trg_Keu1' placeholder='Triwulan I' value='$satu' required>
                      </div>
                      <label class='col-sm-2 control-label'>Triwulan II</label>
                      <div class='col-sm-3'>
                        <input type=text class='form-control' name='trg_Keu2' value='$dua' placeholder='Triwulan II'>
                      </div>
                    </div>

                    <div class=form-group>
                      <label class='col-sm-2 control-label'>Triwulan III</label>
                      <div class='col-sm-3'>
                        <input type=text class='form-control digits' name='trg_Keu3' value='$tiga' placeholder='Triwulan III'>
                      </div>
                      <label class='col-sm-2 control-label'>Triwulan IV</label>
                      <div class='col-sm-3'>
                        <input type=text class='form-control' name='trg_Keu4' value='$empat' placeholder='Triwulan IV'>
                      </div>
                      <div class='col-sm-2'>
                        <input type=checkbox class='' id='bagirata' name='bagirata' value='bagirata'> Bagi Rata
                      </div>
                    </div>
                        <input type=hidden name=id_Skpd value='$_SESSION[id_Skpd]'>
                        <input type=hidden name=TahunAnggaran value='$_SESSION[thn_Login]'>
                        <input type=hidden name=id_DataKegiatan value='$_GET[id]'>
                    <hr />";
                     echo "<div class='clearfix form-actions'>
                        <button class='btn btn-primary btn-sm btn-fill pull-right' type='submit' name='simpan'><i class='fa fa-save'></i> Simpan</button>
                        <button class='btn btn-primary btn-sm btn-fill' type='reset'><i class='fa fa-refresh'></i> Reset</button>
                        <button class='btn btn-warning btn-sm btn-fill' type='reset' onClick='window.history.back()'><i class='fa fa-arrow-left'></i> Kembali</button>
                        </div>
                    </div>
                  </form>";
                echo '</div>
              </div>';

  break;
  case "edit":
			$q = mysql_query("SELECT * FROM subkegiatan WHERE id_SubKegiatan = '$_GET[id]'");
			$r = mysql_fetch_array($q);

      $r['JnsSubKeg']=='f' ? $cekk = "checked" : "";

      echo '<div class="col-md-10">
            <div class="card">
              <div class="content">';
                echo "<form class='form-horizontal' method=post id=frm_tambah action=".htmlspecialchars('modul/act_modsubkegiatan.php?module=subkegiatan&act=edit').">";
                  echo '<div class="form-group">
                      <label class="col-sm-2 control-label">Nama Rincian</label>
                      <div class="col-sm-10">
                        <input class="form-control" type=text name="nm_SubKegiatan" id="nm_SubKegiatan" placeholder="Nama Rincian" size=50 required  value="'.$r[nm_SubKegiatan].'"><!--&nbsp;<input type="checkbox" name="JnsSubKeg" id="group1" value="f"> Fisik-->
                      </div>
                    </div>';
                  echo "<div class='form-group'>
                      <label class='col-sm-2 control-label'>Nilai PAGU</label>
                      <div class='col-sm-4'>
                        <input type=text class='form-control' name='nl_Pagu' placeholder='Nilai PAGU' value='$r[nl_Pagu]'>
                      </div>
                      <label class='col-sm-2 control-label'>Nilai Fisik</label>
                      <div class='col-sm-4'>
                        <input type=text class='form-control' name='nl_Fisik' placeholder='Nilai Fisik' value='$r[nl_Fisik]'>
                      </div>
                    </div>
                    <div class=form-group>
                      <label class='col-sm-2 control-label'>Nilai Kontrak</label>
                      <div class='col-sm-4'>
                        <input type=text class='form-control' name='nl_Kontrak' placeholder='Nilai Kontrak' value='$r[nl_Kontrak]'>
                      </div>
                      <label class='col-sm-2 control-label'>Volume</label>
                      <div class='col-sm-4'>
                        <input type=text class='form-control' name='jml_Volume' placeholder='Volume' required value='$r[jml_Volume]'>
                      </div>
                    </div>
                    <div class=form-group>
                      <label class='col-sm-2 control-label'>Alamat Lokasi/Tempat Pelaksanaan</label>
                      <div class='col-sm-10'>
                        <input type=text class='form-control' name='AlamatLokasi' placeholder='Alamat' value='$r[AlamatLokasi]' required>
                      </div>
                    </div>
                    <div class=form-group>
                      <label class='col-sm-2 control-label'>Kecamatan</label>
                      <div class='col-sm-4'>
                        <select class='form-control' name=id_Kecamatan placeholder=Kecamatan id=id_Kecamatan onchange='pilih_kecamatan(this.value);' required>
                        <option selected>Kecamatan</option>";
                        $qx=mysql_query("SELECT * FROM kecamatan");
                        $idkec = substr($r[id_Desa], 0,7);
                        while ($rx=mysql_fetch_array($qx)) {
                          if($rx[id_Kecamatan]==$idkec) {
                            echo "<option value=$rx[id_Kecamatan] selected>$rx[nm_Kecamatan]</option>";
                          }else{
                            echo "<option value=$rx[id_Kecamatan]>$rx[nm_Kecamatan]</option>";
                          }
                        }
                          echo "</select>
                      </div>
                      <label class='col-sm-2 control-label'>Desa</label>
                      <div class='col-sm-4'>
                        <select class='form-control'  name=id_Desa placeholder=Desa id=id_Desa onchange=''>";
                          $qx=mysql_query("SELECT * FROM desa WHERE id_Kecamatan = '$idkec'");
                          while ($rx=mysql_fetch_array($qx)) {
                            if($rx[id_Desa]==$r[id_Desa]) {
                              echo "<option value=$rx[id_Desa] selected>$rx[nm_Desa]</option>";
                            }else{
                              echo "<option value=$rx[id_Desa]>$rx[nm_Desa]</option>";
                            }
                          }
                        echo "</select>
                      </div>
                    </div>
                    <div class=form-group>
                      <label class='col-sm-2 control-label'>Kordinat Latitude</label>
                      <div class='col-sm-4'>";

                        echo '<input type="text" class="form-control" name="latitude" placeholder="Latitude" value="'.stripslashes($r[Latitude]).'">';
                      echo "</div>
                      <label class='col-sm-2 control-label'>Kordinat Longitude</label>
                      <div class='col-sm-4'>
                        <input type='text' class='form-control' name='longitude' placeholder='Longitude' value=".stripslashes($r[Longitude]).">
                      </div>
                    </div>
                    <div class=form-group>
                      <label class='col-sm-2 control-label'>Pelaksana</label>
                      <div class='col-sm-4'>
                        <input type='text' class='form-control' name='pelaksana2' id='pelaksana2' value='$r[Pelaksana]'>
                      </div>
                      <label class='col-sm-2 control-label'>Nomor Kontrak</label>
                      <div class='col-sm-4'>
                        <input type=text class='form-control' name='no_Kontrak' placeholder='Nomor Kontrak' value='$r[no_Kontrak]'>
                      </div>
                    </div>
                    <div class=form-group>
                      <label class='col-sm-2 control-label'>Kons. Perencana</label>
                      <div class='col-sm-4'>
                        <input type=text class='form-control' name='konsPerencana' placeholder='Kons. Perencana' value='$r[konsPerencana]'>
                      </div>
                      <label class='col-sm-2 control-label'>Kons. Pengawas</label>
                      <div class='col-sm-4'>
                        <input type=text class='form-control' name='konsPengawas' placeholder='Kons. Pengawas' value='$r[konsPengawas]'>
                      </div>
                    </div>
                    <div class=form-group>
                      <label class='col-sm-2 control-label'>Waktu Pengerjaan Mulai</label>
                      <div class='col-sm-4'>
                        <input type='date' class='form-control' name='tgl_Mulai' placeholder='tgl Mulai' value='$r[tgl_Mulai]'>
                      </div>
                      <label class='col-sm-2 control-label'>Waktu Selesai</label>
                      <div class='col-sm-4'>
                        <input type=date id='datepicker' class='form-control' name='tgl_Selesai' placeholder='tgl selesai' value='$r[tgl_Selesai]'>
                      </div>
                    </div>
                    <div class=form-group>
                      <label class='col-sm-2 control-label'>Target Fisik</label>
                      <div class='col-sm-10'>
                        <input type=text class='form-control required' name='trg_Fisik' placeholder='Fisik' value='$r[trg_Fisik]'>
                      </div>
                    </div>
                    <div class=form-group>
                      <label class='col-sm-2 control-label'>Target Keuangan Triwulan I</label>
                      <div class='col-sm-3'>";
                      //ini adalah nilai untuk Triwulan inisiasi nilai awal

                      $satu = $r['tr_Satu']-$r['trg_Keu1'];
                      $dua = $r['tr_Dua']-$r['trg_Keu2'];
                      $tiga = $r['tr_Tiga']-$r['trg_Keu3'];
                      $empat = $r['tr_Empat']-$r['trg_Keu4'];
                        echo "<input type=text class='form-control' name='trg_Keu1' placeholder='Triwulan I' value='$r[trg_Keu1]' required>
                      </div>
                      <label class='col-sm-2 control-label'>Triwulan II</label>
                      <div class='col-sm-3'>
                        <input type=text class='form-control' name='trg_Keu2' value='$r[trg_Keu2]' placeholder='Triwulan II'>
                      </div>
                    </div>

                    <div class=form-group>
                      <label class='col-sm-2 control-label'>Triwulan III</label>
                      <div class='col-sm-3'>
                        <input type=text class='form-control digits' name='trg_Keu3' value='$r[trg_Keu3]' placeholder='Triwulan III'>
                      </div>
                      <label class='col-sm-2 control-label'>Triwulan IV</label>
                      <div class='col-sm-3'>
                        <input type=text class='form-control' name='trg_Keu4' value='$r[trg_Keu4]' placeholder='Triwulan IV'>
                      </div>
                      <div class='col-sm-2'>
                        <input type=checkbox class='' id='bagirata' name='bagirata' value='bagirata'> Bagi Rata
                      </div>
                    </div>
                    <hr />";
                    echo "<div class='clearfix form-actions'>

                          <input type=hidden name=id_Skpd value=$_SESSION[id_Skpd] />
                          <input type=hidden name=nl_PaguLama value=$r[nl_Pagu] />
                          <input type=hidden name=id_SubKegiatan value=$r[id_SubKegiatan] />
                          <input type=hidden name=TahunAnggaran value=$_SESSION[thn_Login] />
                          <input type='hidden' name='id_DataKegiatan' value='$r[id_DataKegiatan]' />
                          <button class='btn btn-primary btn-sm btn-fill pull-right' type='submit' name='simpan'><i class='fa fa-save'></i> Simpan</button>
                          <button class='btn btn-primary btn-sm btn-fill' type='reset'><i class='fa fa-refresh'></i> Reset</button>
                          <button class='btn btn-warning btn-sm btn-fill' type='reset' onClick='window.history.back()'><i class='fa fa-arrow-left'></i> Kembali</button>
                        </div>
                    </div>
                  </form>";
                echo '</div>
              </div>';
    break;
    case "trgfisik" :
    $q = mysql_query("SELECT * FROM subkegiatan WHERE id_SubKegiatan = '$_GET[id]'");
    $r = mysql_fetch_array($q);

    $r['JnsSubKeg']=='f' ? $cekk = "checked" : "";


    echo '<div class="col-md-6">
          <div class="card">
            <div class="content">
              <div class="widget-box">
                          <div class="widget-header">
                            <h5 class="widget-title">Target Fisik dan Keuangan</h5>

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
            echo '<table class="table table-bordered">
                      <tr class="info">
                        <th>Bulan</th>
                        <th>Target Fisik</th>
                        <th>Target Keuangan</th>
                      </tr>';
            //echo "<form method=post action='modul/act_modrealisasi.php?module=realisasi&act=addx'>";
            echo "<form method=post action='modul/act_modsubkegiatan.php?module=subkegiatank&act=trgfisik'>";
            $qc = mysql_query("SELECT * FROM target WHERE id_SubKegiatan = '$_GET[id]'");
            $rc = mysql_fetch_array($qc);
              for ($i=1; $i <=12 ; $i++) {
                $tff = "tf$i";
                $tkk = "tk$i";
                echo '<tr>
                        <td>'.$arrbln[$i].'</td>
                        <td><input type="text" class="form-control" name="tf'.$i.'" value="'.$rc[$tff].'" placeholder=""></td>
                        <td><input type="number" class="form-control" name="tk'.$i.'" value="'.$rc[$tkk].'"></td>
                      </tr>';
              }
              echo '</table>';
              $qz = mysql_query("SELECT id_SubKegiatan FROM target WHERE id_SubKegiatan = '$r[id_SubKegiatan]'");
              $hit = mysql_num_rows($qz);
              if($hit == 0) {}
              $hit == 0 ? $tmb_simpan = "simpanx" : $tmb_simpan = "editx";
              echo '<hr>
              <div class="clearfix form-actions">
                <input type=hidden name="id_SubKegiatan" value="'.$r['id_SubKegiatan'].'">
                <input type=hidden name="id_DataKegiatan" value="'.$r['id_DataKegiatan'].'">
                <input class="btn btn-primary btn-fill pull-right" type="submit" name="'.$tmb_simpan.'" value=Simpan />
                <input class="btn btn-info" type="reset" value=Reset />
                <button class="btn btn-info" type="reset" onClick=\'window.history.back()\'><i class="fa fa-arrow-left"></i> Kembali</button>
              </div>
                </form>';
              echo '</div>
              </div>
            </div>';
    break;
  }//end switch
} //end tanpa hak akses
} //end tanpa session

?>
<script type="text/javascript">



$('#frm_tambah').validate();
$( "#datepicker" ).datepicker();
//disable jika swakelola
$("#tomboltambahsub").click(function(){
  $("#frm_tambah").show();
  //$("#subkegiatan1").hide();
});

$(function() {
  enable_cb();
  $("#group1").click(enable_cb);
});

function enable_cb() {
  if (this.checked) {
    $("input.group1").removeAttr("disabled");
  } else {
    $("input.group1").attr("disabled", true);
  }
}

$("#bulanan").hide();
$(function() {
  pertriwulan();
  $("#triwulan").click(pertriwulan);
});
function pertriwulan() {
  if (this.checked) {
    $("#bulanan").show();
  } else {
    $("#bulanan").hide();
  }
}

function pilih_kecamatan(id_Kecamatan)
{
  $.ajax({
    url: 'library/desa.php',
    data : 'id_Kecamatan='+id_Kecamatan,
    type: "post",
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#id_Desa').html(response);
        }
    });
}

function pilih_Urusan(id_Urusan)
{
  $.ajax({
    url: '../library/bidangurusan.php',
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
    url: '../library/program.php',
    data : 'id_BidUrusan='+id_BidUrusan,
    type: "post",
    dataType: "html",
    timeout: 10000,
    success: function(response){
      $('#id_Program').html(response);
      }
    });
}

function pilih_Program(id_Program)
{
  $.ajax({
        url: '../library/kegiatan.php',
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
        url: '../library/nm_kegiatan.php',
        data : 'id_Kegiatan='+id_Kegiatan,
    type: "post",
        dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#nm_Kegiatan').html(response);
        }
    });
}


function vw_tbl(id_Program)
{
  $.ajax({
    url: '../library/vw_kegiatan.php',
    data: 'id_Program='+id_Program,
    type: "post",
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#vw_kegiatan').html(response);
        }
    });
}
function ax_form_subkegiatan(id_SubKegiatan)
{
  $.ajax({
    url: '../library/ax_subkegiatan.php',
    data: 'id_SubKegiatan='+id_SubKegiatan,
    type: "post",
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#frm_tambah').html(response);
        }
    });
}


  //kembali
  $(".batal").click(function(event) {
    event.preventDefault();
    history.back(1);
});
$("#myTable").tablesorter({widgets: ['zebra'],
  headers: {7: {sorter: true}}
})
.tablesorterPager({container: $("#pager")});
</script>
