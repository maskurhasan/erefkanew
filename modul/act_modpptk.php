<?php
session_start();
include "../config/koneksi.php";
include "../config/fungsi.php";


$module = $_GET['module'];
$act = $_GET['act'];

if ($act == "add" and $module == "ppk") {
        
} elseif($act == "edit" and $module == "datappk"){
        

} elseif($act == "delete" and $module == "user"){
      //jika user dihapus
  
}  elseif($act == "akseskegiatan" and $module == "pptk"){
      
        if(isset($_POST['Simpan'])) {
          $id_Pptk = $_POST['id_Pptk'];
          $id_DataKegiatan = $_POST['id_DataKegiatan'];
          $qw = mysql_query("UPDATE datakegiatan SET id_Pptk= '0' WHERE id_Pptk = '$id_Pptk'");
          if($qw) {
              for ($i=0 ; $i < count($id_DataKegiatan);$i++) {
                  $id_DataKegiatanx = $id_DataKegiatan[$i];
                  $q = mysql_query("UPDATE datakegiatan SET id_Pptk= '$id_Pptk' WHERE id_DataKegiatan = '$id_DataKegiatanx'");    
              }
              if ($q) {
                header('Location:../main.php?module=pptk');
              } else {
                header('Location:../main.php?module=pptk');
              }
          } else {
            header('Location:../main.php?module=pptk');
          }
        } else { echo "gagal"; } 

} 