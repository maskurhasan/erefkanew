<?php
include "../config/koneksi.php";

//ambil value dri data kd_Urusan + kd_BidUrusan + kd_Program
$terima = $_POST[id_DataKegiatan];

$sql_lokasi="SELECT a.nm_SubKegiatan,a.latitude,a.longitude 
                            FROM subkegiatan a,datakegiatan b   
                            WHERE a.id_DataKegiatan = b.id_DataKegiatan 
                            AND b.id_Skpd = $_SESSION[id_Skpd] 
                            AND b.TahunAnggaran = $_SESSION[thn_Login]";
$sql1 = 'SELECT id_SubKegiatan,nm_SubKegiatan,latitude,longitude FROM subkegiatan WHERE id_DataKegiatan = "'.$terima.'"';
$result1 = mysql_query($sql1);
	echo '<strong>Daftar Subkegiatan</strong>';
while($l = mysql_fetch_array($result1)) {
	
	//echo "<option value=$dt[id_SubKegiatan] onclick='javascript:setpeta(".$l['latitude'].",".$l['longitude'].",".$l['id_SubKegiatan'].")\'> $l[nm_SubKegiatan]</option>";
	echo "<li><a href=\"javascript:setpeta(".$l['latitude'].",".$l['longitude'].",".$l['id_SubKegiatan'].")\">".$l['nm_SubKegiatan']."</a></li>";
}

?>