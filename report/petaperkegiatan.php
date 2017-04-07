<?php 
session_start();
include '../config/koneksi.php';

?>

<html>
<head>
<title>Pemetaan Kegiatan SKPD</title>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
<style>
  body {
	padding-top: 10px; /* 60px to make the container go all the way to the bottom of the topbar */
  }
</style>

<script src="../assets/js/jquery-1.10.2.js"></script>

<script src="../assets/js/bootstrap.min.js"></script>

<!-- load googlemaps api dulu -->
<script src="http://maps.google.com/maps/api/js?key=AIzaSyA-FKPVfHfzAPD94bfGuBf4dCWH2IGkNQ8&sensor=false"></script>

<script type="text/javascript">
	var peta;
	var gambar_tanda;
	gambar_tanda = '../assets/img/icon.png';
	
	function peta_awal(){
		// posisi default peta saat diload
	    var lokasibaru = new google.maps.LatLng(-2.5485313,120.3493045);
    	var petaoption = {
			zoom: 13,
			center: lokasibaru,
			mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        
	    peta = new google.maps.Map(document.getElementById("map_canvas"),petaoption);
	    
	    // ngasih fungsi marker buat generate koordinat latitude & longitude
	    tanda = new google.maps.Marker({
	        position: lokasibaru,
	        map: peta, 
	        icon: gambar_tanda,
	        draggable : true
	    });
	    
	    // ketika markernya didrag, koordinatnya langsung di selipin di textfield
	    google.maps.event.addListener(tanda, 'dragend', function(event){
				document.getElementById('latitude').value = this.getPosition().lat();
				document.getElementById('longitude').value = this.getPosition().lng();
		});
	}

	function setpeta(x,y,id){
		// mengambil koordinat dari database
		var lokasibaru = new google.maps.LatLng(x, y);
		var petaoption = {
			zoom: 14,
			center: lokasibaru,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		
		peta = new google.maps.Map(document.getElementById("map_canvas"),petaoption);
		 
		 // ngasih fungsi marker buat generate koordinat latitude & longitude
		tanda = new google.maps.Marker({
			position: lokasibaru,
			icon: gambar_tanda,
			draggable : true,
			map: peta
		});
		
		// ketika markernya didrag, koordinatnya langsung di selipin di textfield
		google.maps.event.addListener(tanda, 'dragend', function(event){
				document.getElementById('latitude').value = this.getPosition().lat();
				document.getElementById('longitude').value = this.getPosition().lng();
		});
	}
</script> 
</head>
<body onload="peta_awal()">
<div class="container">
<div class="navbar navbar-default">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="navbar-brand text-success" href="#">Pemetaan Kegiatan SKPD </a>
          <div class="btn-group pull-right">
           
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

<div class="row">
<div class="col-md-8">
	<div class="control-group">
	 <div id="map_canvas" style="width:100%; height:500px"></div>
	</div>
</div>
	
	
	<div class="col-md-4">
	<?php 
	echo "<form class='form-horizontal' method=get action='' target='_blank'>";
                        echo '<div class="form-group">
                            <label for="inputPassword3" class="col-sm-4 control-label">Kegiatan</label>
                            <div class="col-sm-8">';
                            echo '<select class="form-control" name="id_DataKegiatan" id="id_DataKegiatan" onchange="pilih_Subkeg(this.value);">
                                  <option value="">Pilih Kegiatan</option>';
                                  $q=mysql_query("SELECT a.nm_Kegiatan,id_DataKegiatan  
                                                  FROM kegiatan a, datakegiatan b   
                                                  WHERE a.id_Kegiatan = b.id_Kegiatan 
                                                  AND b.id_Skpd = '$_SESSION[id_Skpd]' 
                                                  AND b.TahunAnggaran = '$_SESSION[thn_Login]'");
                                  while ($r=mysql_fetch_array($q)) {
                                    echo "<option value='$r[id_DataKegiatan]'>$r[nm_Kegiatan]</option>";
                                  }
                            echo '</select>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-4 control-label">Sub. Kegiatan</label>
                            <div class="col-sm-8">';
                            echo "<select class='form-control' name=id_SubKegiatan id='id_SubKegiatanxxx' onchange=''>
                                    <option value=''>Pilih Sub Kegiatan</option>";
                            echo '</select>
                            </div>
                          </div>
                          
                      <hr>
                      <div id="id_SubKegiatan"></div>
                      </form>';
	?>	
	</div>
</div>
<hr>
	  <footer>
        <p>&copy; E-RFK Luwu Utara</p>
      </footer>
</div>
</body>
</html>

<script>
function pilih_Subkeg(id_DataKegiatan)
{
  $.ajax({
        url: '../library/vw_subkegkordinat.php',
        data : 'id_DataKegiatan='+id_DataKegiatan,
        type: "post",
        dataType: "html",
        timeout: 10000,
        success: function(response){
          $('#id_SubKegiatan').html(response);
        }
    });
}

</script>