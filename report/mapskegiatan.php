<html>
<head>
<title>Warteg</title>
<!--<link href="assets/css/bootstrap.css" rel="stylesheet">
<style>
  body {
	padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
  }
</style>
<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap-alert.js"></script>-->

<!-- load googlemaps api dulu  AIzaSyA-FKPVfHfzAPD94bfGuBf4dCWH2IGkNQ8 -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-FKPVfHfzAPD94bfGuBf4dCWH2IGkNQ8&callback=initMap&sensor=false"
  type="text/javascript"></script>



<script type="text/javascript">
	var peta;
	var gambar_tanda;
	gambar_tanda = 'assets/img/marker.png';
	
	function peta_awal(){
		// posisi default peta saat diload
	    var lokasibaru = new google.maps.LatLng(-6.912889,107.609787);
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
<div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">WARTEG CICKO</a>
          <div class="btn-group pull-right">
           
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
<?php

$o = "";
	
if (isset($_GET['success']) && ($_GET['success'] == "1")) {

	$o .= '<div class="alert alert-success">
			<a class="close" data-dismiss="alert" href="#">x</a>
			Proses tambah cabang berhasil
			</div>';
			
} elseif (isset($_GET['success']) && ($_GET['success'] == "0")) {
	
	$o .= '<div class="alert alert-error">
			<a class="close" data-dismiss="alert" href="#">x</a>
			Proses tambah cabang gagal
		   </div>';
} elseif (isset($_GET['remove']) && ($_GET['remove'] == "1")) {

	$o .= '<div class="alert alert-success">
			<a class="close" data-dismiss="alert" href="#">x</a>
			Proses hapus cabang berhasil
			</div>';
			
} elseif (isset($_GET['remove']) && ($_GET['remove'] == "0")) {
	
	$o .= '<div class="alert alert-error">
			<a class="close" data-dismiss="alert" href="#">x</a>
			Proses hapus cabang gagal
		   </div>';
}
		
echo $o;

?>
<div class="row">
<div class="span8">
	<div class="control-group">
	 <div id="map_canvas" style="width:100%; height:500px"></div>
	</div>
</div>
	
	<form action="?action=add" method="POST"> 
	<div class="span4">
	<div class="control-group">
	  <label class="control-label" for="input01">Nama Cabang</label>
	  <div class="controls">
		<input type="text" class="input-xlarge" id="nama_cabang" name="nama_cabang" rel="popover" data-content="Masukkan nama cabang." data-original-title="Cabang">
	  </div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="input01">Longitude</label>
		  <div class="controls">
			<input type="text" class="input-xlarge" id="longitude" name="longitude" >
		  </div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="input01">Latitude</label>
		  <div class="controls">
			<input type="text" class="input-xlarge" id="latitude" name="latitude">
		  </div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="input01"></label>
		  <div class="controls">
		   <button type="submit" class="btn btn-success">Tambah Cabang</button>
	
		  </div>
	</div>
	</form>
	<div class="control-group">
		<label class="control-label" for="input01">Daftar Cabang</label>
		  <div class="controls">
		  <div id="daftar">
		  <ul>
		  <?php
		  require ('config.php');
		  // mengambil data dari database
		  $lokasi = mysql_query("select * from `cabang`");
			
			while($l=mysql_fetch_array($lokasi)){
				// membuat fungsi javascript untuk nantinya diolah dan ditampilkan dalam peta
				
				echo "<li><a href=\"javascript:setpeta(".$l['lat'].",".$l['long'].",".$l['id'].")\">".$l['nama_cabang']."</a> | <a href='?action=remove&id=".$l['id']."'>Hapus</a></li>";
			}
		  ?>
		  </ul>
		  </div>
	
		  </div>
	</div>
		

</div>
</div>
<hr>
	  <footer>
        <p>&copy; Warteg Cicko 2012</p>
      </footer>
</div>
</body>
</html>

<?php


if ($_GET['action'] == "add") {
	
	require ('config.php');
	$nama_cabang	= htmlentities(mysql_real_escape_string($_POST['nama_cabang']));
	$longitude		= htmlentities(mysql_real_escape_string($_POST['longitude']));
	$latitude		= htmlentities(mysql_real_escape_string($_POST['latitude']));
	
	// input data ke database
	$input_cabang = mysql_query("insert into `cabang` (`nama_cabang`,`lat`,`long`) values ('$nama_cabang','$latitude','$longitude')");
	
	if ($input_cabang) {
		?>
		<script language="javascript">
		document.location="?success=1";
		</script>
		<?php
	} else {
		?>
			<script language="javascript">
			document.location="?success=0";
			</script>
		<?php
	}
	
} elseif ($_GET['action'] == "remove") {
	$id = htmlentities(mysql_real_escape_string($_GET['id']));
	// hapus data dari database
	$hapus_cabang = mysql_query("DELETE FROM `cabang` WHERE `id` = '".$id."'");
	
	if ($hapus_cabang) {
		?>
		<script language="javascript">
		document.location="?remove=1";
		</script>
		<?php
	} else {
		?>
			<script language="javascript">
			document.location="?remove=0";
			</script>
		<?php
	}
}
