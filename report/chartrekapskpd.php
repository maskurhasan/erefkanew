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
<script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="assets/js/highcharts.js" type="text/javascript"></script>
<script type="text/javascript">
/*
$(function () {
    Highcharts.chart('container', {
        title: {
            text: 'Monthly Average Temperature',
            x: -20 //center
        },
        subtitle: {
            text: 'Source: WorldClimate.com',
            x: -20
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: 'Temperature (°C)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '°C'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: 'Tokyo',
            data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
        }, {
            name: 'New York',
            data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
        }, {
            name: 'Berlin',
            data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
        }, {
            name: 'London',
            data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
        }]
    });
});
*/


var chart1; // globally available
$(document).ready(function() {
      chart1 = new Highcharts.Chart({
         chart: {
            renderTo: 'container',
            type: 'line'
         },   
         title: {
            text: 'Progress Fisik dan Keuangan'
         },
         xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
             
         },
         yAxis: {
            title: {
               text: 'Realisasi'
            }
         },
        series: [{
            name: 'T Keu',
            data: 
            <?php
            $q1 = mysql_query("SELECT SUM(a.t1) satu,SUM(a.t2) dua,SUM(a.t3) tiga,SUM(a.t4) empat,
                                    SUM(a.t5) lima,SUM(a.t6) enam,SUM(a.t7) tujuh,SUM(a.t8) delapan,
                                    SUM(a.t9) sembilan,SUM(a.t10) sepuluh,SUM(a.t11) sebelas,SUM(a.t12) duabelas 
                                FROM realisasi a,subkegiatan b,datakegiatan c
                                WHERE a.id_SubKegiatan = b.id_SubKegiatan 
                                AND b.id_DataKegiatan = c.id_DataKegiatan 
                                AND c.TahunAnggaran = '$_SESSION[thn_Login]' 
                                AND c.id_Skpd = '$_SESSION[id_Skpd]'");
            $r1 = mysql_fetch_array($q1);
            ?>  
                [<?php echo $r1[satu]; ?>, <?php echo $r1[dua]; ?>,<?php echo $r1[tiga]; ?>, <?php echo $r1[empat]; ?>, 
                <?php echo $r1[lima]; ?>, <?php echo $r1[enam]; ?>, <?php echo $r1[tujuh]; ?>, <?php echo $r1[delapan]; ?>, 
                <?php echo $r1[sembilan]; ?>, <?php echo $r1[sepuluh]; ?>, <?php echo $r1[sebelas]; ?>,<?php echo $r1[duabelas]; ?>]
        }, {
            name: 'R Keu',
            data: 
            <?php
            $q1 = mysql_query("SELECT SUM(a.b1) satu,SUM(a.b2) dua,SUM(a.b3) tiga,SUM(a.b4) empat,
                                    SUM(a.b5) lima,SUM(a.b6) enam,SUM(a.b7) tujuh,SUM(a.b8) delapan,
                                    SUM(a.b9) sembilan,SUM(a.b10) sepuluh,SUM(a.b11) sebelas,SUM(a.b12) duabelas 
                                FROM realisasi a,subkegiatan b,datakegiatan c
                                WHERE a.id_SubKegiatan = b.id_SubKegiatan 
                                AND b.id_DataKegiatan = c.id_DataKegiatan 
                                AND c.TahunAnggaran = '$_SESSION[thn_Login]' 
                                AND c.id_Skpd = '$_SESSION[id_Skpd]'");
            $r1 = mysql_fetch_array($q1);
            ?>  
                [<?php echo $r1[satu]; ?>, <?php echo $r1[dua]; ?>,<?php echo $r1[tiga]; ?>, <?php echo $r1[empat]; ?>, 
                <?php echo $r1[lima]; ?>, <?php echo $r1[enam]; ?>, <?php echo $r1[tujuh]; ?>, <?php echo $r1[delapan]; ?>, 
                <?php echo $r1[sembilan]; ?>, <?php echo $r1[sepuluh]; ?>, <?php echo $r1[sebelas]; ?>,<?php echo $r1[duabelas]; ?>]
            
        }, {
            name: 'T. Fisik',
            data: [0]
        }, {
            name: 'R. Fisik',
            data: [0]
        }]

      });
   });	

</script>
	</head>
	<body>
		<div id='container'></div>		
	</body>
</html>