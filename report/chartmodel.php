<?php
  //error_reporting(E_ALL ^ E_NOTICE);
  //error_reporting (E_ALL ^ E_DEPRECATED ^ E_NOTICE);
  error_reporting(1);
  //error_reporting(E_ALL);
  //ini_set('display_errors',1);  
?>



<?php
function rlsbulanx($id_Bulan,$id_Subkegiatan){
    $q = mysql_query("SELECT a.rls_Keu2 keu 
                        FROM realisasi a,subkegiatan b 
                        WHERE a.id_Subkegiatan = b.id_Subkegiatan 
                        AND a.id_Subkegiatan = '$id_Subkegiatan' 
                        AND a.id_Bulan = '$id_Bulan'");
    $r = mysql_fetch_array($q);
    $bln_lalu = $id_Bulan - 1;
    return $r['keu'];
}
function rlsbulanxxxx($id_Bulan,$id_DataKegiatan){
    $q = mysql_query("SELECT SUM(a.rls_Keu2) keu 
                        FROM realisasi a,subkegiatan b 
                        WHERE a.id_Subkegiatan = b.id_Subkegiatan 
                        AND a.id_Subkegiatan = '$id_Subkegiatan'");
    $r = mysql_fetch_array($q);
    $bln_lalu = $id_Bulan - 1;
    return $r['keu'];
}
function rlsbulan($id_Bulan,$id_Subkegiatan){
    $bul = "b".$id_Bulan;
    $q = mysql_query("SELECT a.$bul keu 
                        FROM realisasi a,subkegiatan b 
                        WHERE a.id_Subkegiatan = b.id_Subkegiatan 
                        AND a.id_Subkegiatan = '$id_Subkegiatan' ");
    $r = mysql_fetch_array($q);
    $bln_lalu = $id_Bulan - 1;
    return $r['keu'];
}
?>
<html>
	<head>
<!--<script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>-->
<script src="assets/js/highcharts.js" type="text/javascript"></script>
<script type="text/javascript">
	var chart1; // globally available
$(document).ready(function() {
      chart1 = new Highcharts.Chart({
         chart: {
            renderTo: 'container',
            type: 'column'
         },   
         title: {
            text: 'Realisasi Keuangan '
         },
         xAxis: {
            categories: ['Bulan']
             
         },
         yAxis: {
            title: {
               text: 'Realisasi'
            }
         },
              series:             
            [
              <?php

              for($i=1;$i<=12;$i++) { 
              $bulan = $arrbln2[$i];
              $realisasi = rlsbulan($i,$postur);
              ?>
      				{
                
                name: '<?php echo $bulan; ?>',
                data: [<?php echo $realisasi; ?>]
      				},
              <?php } ?>
            ]
      });
   });	
</script>
	</head>
	<body>
		<div id='container'></div>		
	</body>
</html>