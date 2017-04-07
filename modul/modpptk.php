<?php
session_start();

if (empty($_SESSION[UserName]) AND empty($_SESSION[PassWord])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {
$cek=user_akses($_GET['module'],$_SESSION['id_User']);
if($cek==1 OR $_SESSION['UserLevel']=='1') {
//----------------------------------
include "../config/koneksi.php";
include "../config/fungsi.php";

//include "modmaster.php";

  switch ($_GET[act]) {
    default:

    echo '<div class="col-md-8">
              <div class="card">
                <div class="header">
                  <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                    <div class="input-group pull-right" style="width: 150px;">
                      <input type="text" name="table_search" class="form-control input-sm pull-right" placeholder="Search">
                    <div class="input-group-btn">
                      <button class="btn btn-sm btn-default"><i class="fa fa-search"></i> Cari</button>';
                      //echo "<button class='btn btn-sm btn-primary btn-fill' name='tambahsubdak' onClick=\"window.location.href='?module=datappk&act=add'\"><i class='fa fa-plus'></i> Tambah PPK</button>";
                      echo '</div>
                    </div>
                    </div>
                  </div>
                </div><!-- /.box-header -->
                <div class="content table-responsive">
                  <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                      <th>#</th><th>Nama Lengkap</th><th>NIP</th><th>Jabatan</th><th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>';
                  $sql = mysql_query("SELECT * FROM user a, pangkat b WHERE a.id_Pangkat = b.id_Pangkat
                                      AND a.id_Skpd = '$_SESSION[id_Skpd]' 
                                      AND a.UserLevel != 1 
                                      AND a.statusppk = 1");
                  $no=1;
                  while($dt = mysql_fetch_array($sql)) {
                    $Aktiv = $dt[Aktiv]==1 ? "Y" : "N";
                    $no % 2 === 0 ? $alt="alt" : $alt="";
                    echo "<tr class=$alt><td>".$no++."</td>
                            <td>$dt[nm_Lengkap]</td>
                            <td>$dt[nip_Ppk]</td>
                            <td>PPTK Kegiatan</td>
                            <td class=align-center>
                                <a href='?module=pptk&act=akseskegiatan&id=$dt[id_User]'><i class='fa fa-tasks fa-lg'></i> Kegiatan</a>
                            </tr>";
                  }
                  echo '<tbody></table>
                
                <div class="footer">
                  
                </div>
                </div>
              </div>
            </div>';
  
    break;
    case "akseskegiatan" :
                $sql = mysql_query("SELECT *
                                    FROM user a
                                    LEFT JOIN pangkat b
                                    ON a.id_Pangkat = b.id_Pangkat
                                    WHERE id_User = '$_GET[id]'");
                $r1 = mysql_fetch_array($sql);

    

      echo '<div class="col-md-6">
        <div class="profile-user-info profile-user-info-striped">
          <div class="profile-info-row">
            <div class="profile-info-name"> Jenis SPM </div>
            <div class="profile-info-value">
              '.$r1[nm_Lengkap].'
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> NIP</div>
            <div class="profile-info-value">
              '.$r1[nip_Ppk].'  Pangkat '.$r1[nm_Pangkat].'
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> Jabatan </div>
            <div class="profile-info-value">
              Pejabat Pelaksana Teknis Kegiatan
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> SKPD </div>
            <div class="profile-info-value">
              <button class="btn btn-fill btn-sm btn-info" type="reset" onClick="window.location.href=\'?module=pptk\'"><i class="fa fa-arrow-left"></i> Kembali</button>
            </div>
          </div>
        </div>
        </div>';

      echo '<div class="col-md-12">
              <div class="card">
                <div class="header">
                  
                  <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                    <div class="input-group pull-right" style="width: 350px;">
                      <input type="text" name="table_search" class="form-control" placeholder="Search">
                      <div class="input-group-btn">
                        <button class="btn btn-sm btn-info btn-fill"><i class="fa fa-search"></i> Cari</button>';
                      echo '</div>
                    </div>
                    </div>
                  </div>
                </div><!-- /.box-header -->
                <div class="content table-responsive">
                <form method=post action="modul/act_modpptk.php?module=pptk&act=akseskegiatan">
                  <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                      <th></th><th><input type=checkbox id=selecctall></th><th>Nama Kegiatan</th><th style=width:20%>PPTK</th>
                    </tr>
                    </thead>
                    <tbody>';
                                function ck_pptk($id_DataKegiatan,$id_Pptk) {
                                  $qrr = mysql_query("SELECT a.id_DataKegiatan
                                                      FROM datakegiatan a
                                                      WHERE a.id_DataKegiatan = '$id_DataKegiatan'
                                                      AND a.id_Pptk = '$id_Pptk'");
                                  $rqrr = mysql_fetch_array($qrr);
                                  $hit = mysql_num_rows($qrr);
                                  $checked = $hit == 1 ? "checked='checked'" : '';
                                  $ck = "<input type=checkbox name='id_DataKegiatan[]' value='$id_DataKegiatan' $checked class='checkbox1'>";
                                  return $ck;
                              }
                              $sql = mysql_query("SELECT a.id_DataKegiatan,a.AnggKeg,b.nm_Kegiatan,c.nm_Lengkap
                                                    FROM kegiatan b,datakegiatan a
                                                    LEFT JOIN user c
                                                    ON a.id_Pptk = c.id_User
                                                    WHERE a.TahunAnggaran = '$_SESSION[thn_Login]'
                                                    AND a.id_Kegiatan = b.id_Kegiatan
                                                    AND a.id_Skpd = '$_SESSION[id_Skpd]'");
                              $no = 1;
                              while($dt = mysql_fetch_array($sql)) {
                                $no % 2 === 0 ? $alt="alt" : $alt="";
                                echo "<tr class=$alt>
                                        <td>".$no++."</td>
                                        <td>".ck_pptk($dt['id_DataKegiatan'],$_GET['id'])."</td>
                                        <td>$dt[nm_Kegiatan]</td>
                                        <td>$dt[nm_Lengkap]</td>
                                        </tr>";
                              }
                  echo '<tbody></table>
                
                <div class="">';
                 echo "<input type=checkbox id=selecctall1> Pilih Semua Kegiatan<br />
                          <input type=hidden name=id_Pptk value=$_GET[id]>
                          <input class='submit-green' type='submit' name='Simpan' value=Simpan />
                          <input class='submit-gray' type='reset' value=Reset />
                          <button type='reset' onClick='window.history.back()'><i class='fa fa-arrow-left'></i> Kembali</button>
                          </form>";
                echo '</div>
                </div>
              </div>
            </div>';

    break;
  }//end switch
} //end tanpa hak akses
} //end tanpa session

?>
<script type="text/javascript">
$(document).ready(function() {
    $('#selecctall').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"
            });
        }
    });
    $('#selecctall1').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"
            });
        }
    });

});

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

function vw_tbl(id_BidUrusan)
{
  $.ajax({
    url: '../library/vw_skpd.php',
    data: 'id_BidUrusan='+id_BidUrusan,
    type: "post",
    dataType: "html",
    timeout: 10000,
    success: function(response){
      $('#vw_skpd').html(response);
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
