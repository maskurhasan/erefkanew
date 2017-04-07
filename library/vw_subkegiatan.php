<?php
include "../config/koneksi.php";

//ambil value dri data kd_Urusan + kd_BidUrusan + kd_Program
$terima = $_POST[id_DataKegiatan];

//echo $terima;
//exit();
$postur = $_POST[kd_Program];
$sql1 = 'SELECT id_SubKegiatan,nm_SubKegiatan FROM subkegiatan WHERE id_DataKegiatan = "'.$terima.'"';
$result1 = mysql_query($sql1);
	echo '<option value="">Pilih Sub Kegiatan</option>';
while($dt = mysql_fetch_array($result1)) {
	//$id_Kegiatan = substr($dt[id_Kegiatan],-2);
	echo "<option value=$dt[id_SubKegiatan]> $dt[nm_SubKegiatan]</option>";
}

?>