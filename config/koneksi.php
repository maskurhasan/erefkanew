<?php
error_reporting(1);
$hostName	= "localhost";
$userName	= "root";
$passWord	= "";
$dataBase	= "rfknew";
$offline = 0;

mysql_connect($hostName,$userName,$passWord) or die('Koneksi Gagal');
mysql_select_db($dataBase) or die('Database tidak ditemukan');



?>
