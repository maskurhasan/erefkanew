<?php
session_start();

include "../config/koneksi.php";
include "../config/fungsi.php";

//mengambil data desa
$postur = $_POST['id_Kegiatan'];
$pecah =  explode('_',$postur);
if($pecah[1]=='x') {
  $sql= "SELECT a.*,b.nm_Skpd,c.id_Agenda,c.Tindaklanjut FROM kegiatan a, skpd b,agenda c
                      WHERE a.id_Skpd = b.id_Skpd
                      AND a.id_Kegiatan = c.id_Kegiatan
                      AND c.id_Agenda = '$pecah[0]'";
  $q = mysql_query($sql);
  $dt = mysql_fetch_array($q);
} else {
      $sql= "SELECT a.*,b.nm_Skpd FROM kegiatan a, skpd b
                          WHERE a.id_Skpd = b.id_Skpd
                          AND a.id_Kegiatan = '$pecah[0]'";
      $q = mysql_query($sql);
      $dt = mysql_fetch_array($q);
}

$jns_prioritas = array(1=>'Penting',2=>'Standar',3=>'Darurat');
$jns = $dt['Prioritas'];




echo '
        <input type="hidden" name="id_Agenda" value="'.$dt[id_Agenda].'">

        <input type="hidden" name="id_Skpd" value="'.$_SESSION[id_Skpd].'">
        <input type="hidden" name="id_Skpd" value="'.$_SESSION[id_Skpd].'">
        <input type="hidden" name="id_Kegiatan" value="'.$dt['id_Kegiatan'].'">
        <input type="hidden" name="id_User" value="'.$_SESSION['id_User'].'">
        <div class="profile-user-info profile-user-info-striped">
          <div class="profile-info-row">
            <div class="profile-info-name"> Prioritas </div>
            <div class="profile-info-value">
              '.$jns_prioritas[$jns].'
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> Nomor </div>
            <div class="profile-info-value">
              '.$dt['NomorSurat'].'  / Tanggal '.$dt['tgl_Surat'].'
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> Waktu</div>
            <div class="profile-info-value">
              Jam : '.$dt['Pukul'].' / Tanggal : '.$dt['tgl_Mulai'].' s.d '.$dt['tgl_Selesai'].'
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> Tempat</div>
            <div class="profile-info-value">
              '.$dt['Tempat'].'
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> Perihal </div>
            <div class="profile-info-value">
              '.$dt['Perihal'].'
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> SKPD </div>
            <div class="profile-info-value">
              '.$dt['nm_Skpd'].'
            </div>
          </div>
          <div class="profile-info-row">
            <div class="profile-info-name"> Tindak Lanjut </div>
            <div class="profile-info-value">';
            $jns_tl = array(1=>'Hadir',2=>'Tidak Hadir',3=>'Tunda');
            echo "<select name='Tindaklanjut' class='col-xs-10 col-sm-5' id='form-field-1' required>
                    <option value=''>-Pilih TL-</option>";
                  foreach ($jns_tl as $key => $value) {
                    if($dt[Tindaklanjut] == $key) {
                      echo "<option value=$key selected>$value</option>";
                    } else {
                      echo "<option value=$key>$value</option>";
                    }
                  }
            echo "</select>";
            echo '</div>
          </div>
        </div>





      ';


?>
