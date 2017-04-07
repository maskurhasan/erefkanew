<?php
session_start();
include "../config/koneksi.php";
include "../config/fungsi.php";
include "../config/errormode.php";

$module = $_GET['module'];
$act = $_GET['act'];

if ($act == "add" and $module == "datappk") {
       
} elseif($act == "edit" and $module == "datappk"){
     
} elseif($act == "delete" and $module == "user"){
      //jika user dihapus
  
}  elseif($act == "aksesdana" and $module == "sumberdana"){
       
        if(isset($_POST['Simpan'])) {
          $id_SbDana = $_POST['id_SbDana'];
          $id_DataKegiatan = $_POST['id_DataKegiatan'];
          $qw = mysql_query("UPDATE datakegiatan SET id_SbDana= '0' WHERE id_SbDana = '$id_SbDana'");
          if($qw) {
              for ($i=0 ; $i < count($id_DataKegiatan);$i++) {
                  $id_DataKegiatanx = $id_DataKegiatan[$i];
                  $q = mysql_query("UPDATE datakegiatan SET id_SbDana= '$id_SbDana' WHERE id_DataKegiatan = '$id_DataKegiatanx'");    
              }
              if ($q) {
                header('Location:../main.php?module=sumberdana');
              } else {
                header('Location:../main.php?module=sumberdana');
              }
          }
        } else { echo "gagal"; } 

} 