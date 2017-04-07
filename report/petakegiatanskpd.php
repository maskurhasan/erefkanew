<?php 
session_start();
//error_reporting(1);
include '../config/koneksi.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Latihan Google  map</title>
  <style type='text/css'>
  #peta {
  width: 100%;
  height: 500px;

} </style>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyA-FKPVfHfzAPD94bfGuBf4dCWH2IGkNQ8&sensor=false"></script>
   <script type="text/javascript">
    
(function() {
window.onload = function() {
var map;
var locations = [
   <?php
      //konfgurasi koneksi database 
      //mysql_connect('localhost','root','');
      //mysql_select_db('rfknew');
      
              $sql_lokasi="SELECT a.nm_SubKegiatan,a.latitude,a.longitude 
                            FROM subkegiatan a,datakegiatan b   
                            WHERE a.id_DataKegiatan = b.id_DataKegiatan 
                            AND b.id_Skpd = $_SESSION[id_Skpd] 
                            AND b.TahunAnggaran = $_SESSION[thn_Login]";
              $result=mysql_query($sql_lokasi);
        // ambil nama,lat dan lon dari table lokasi
        while($data=mysql_fetch_object($result)){
        ?>
             ['<?php echo $data->nm_SubKegiatan; ?>', <?php echo $data->latitude; ?>, <?php echo $data->longitude; ?>],
       <?php
        }
    ?>    
    
    ];

    //Parameter Google maps
    var options = {
      zoom: 14, //level zoom
    //posisi tengah peta
      center: new google.maps.LatLng(-2.5485313,120.3493045),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
  
   // Buat peta di 
    var map = new google.maps.Map(document.getElementById('peta'), options);
   // Tambahkan Marker 
  
    var infowindow = new google.maps.InfoWindow();

    var marker, i;
     /* kode untuk menampilkan banyak marker */

    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
      position: new google.maps.LatLng(locations[i][1], locations[i][2]),
      map: map,
      icon: '../assets/img/icon.png'
      });
     /* menambahkan event clik untuk menampikan
       infowindows dengan isi sesuai denga
      marker yang di klik */
    
      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
  

  };
})();

  </script>
  </head>
  <body>
    
    <div id="peta"></div>

  </body>
</html>