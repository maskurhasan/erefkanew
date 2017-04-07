<?php
session_start();
if (empty($_SESSION['UserName']) AND empty($_SESSION['PassWord'])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {

//----------------------------------
include "../config/koneksi.php";
include "../config/fungsi.php";
include "../config/fungsi_indotgl.php";
include "../assets/css/printer.css";
include "../config/errormode.php";
?>
<html>
<head>
<style type="text/css">
.style4 {font-size: 10; }
.style7 {	font-size: 10;
	color: #265180;
	font-family: Georgia, "Times New Roman", Times, serif;
}
</style>
<script language="javascript" type="text/javascript">
window.print();
</script>
<title>Laporan</title>
</head>
<body>
<?php  
function rlsbulan($id_Bulan,$id_DataKegiatan){
    $q = mysql_query("SELECT SUM(a.rls_Keu2) keu 
                        FROM realisasi a,subkegiatan b 
                        WHERE a.id_Subkegiatan = b.id_Subkegiatan 
                        AND b.id_DataKegiatan = '$id_DataKegiatan' 
                        AND a.id_Bulan = '$id_Bulan'");
    $r = mysql_fetch_array($q);
    $bln_lalu = $id_Bulan - 1;
    return $r['keu'];
}
function rlsbulanlalu($id_Bulan,$id_DataKegiatan){
    $bln_lalu = $id_Bulan - 1;
    $q = mysql_query("SELECT SUM(a.rls_Keu2) keu 
                        FROM realisasi a,subkegiatan b 
                        WHERE a.id_Subkegiatan = b.id_Subkegiatan 
                        AND b.id_DataKegiatan = '$id_DataKegiatan' 
                        AND a.id_Bulan = '$bln_lalu'");
    $r = mysql_fetch_array($q);
    return $r['keu'];
}
function maxbulan($id_DataKegiatan){
    $q = mysql_query("SELECT MAX(a.id_Bulan) AS bulan
                        FROM realisasi a,subkegiatan b 
                        WHERE a.id_Subkegiatan = b.id_Subkegiatan 
                        AND b.id_DataKegiatan = '$id_DataKegiatan'");
    $r = mysql_fetch_array($q);
    //$bln_lalu = $id_Bulan - 1;
    return $r['bulan'];
}
function totalkeg($id_Bulan,$id_DataKegiatan){
    $q = mysql_query("SELECT SUM(a.rls_Keu2) AS keu 
                        FROM realisasi a,subkegiatan b 
                        WHERE a.id_Subkegiatan = b.id_Subkegiatan 
                        AND b.id_DataKegiatan = '$id_DataKegiatan' 
                        AND a.id_Bulan = '$id_Bulan'");
    $r = mysql_fetch_array($q);
    //$bln_lalu = $id_Bulan - 1;
    return $r['keu'];
}
$qskpd = mysql_query("SELECT nm_Skpd FROM skpd WHERE id_Skpd = '$_SESSION[id_Skpd]'");
$rskpd = mysql_fetch_array($qskpd);
$idkec = $_GET[id_Kecamatan];
//cari data
echo "<div id=print>
				<div align=center>
				<table class=basic width=796 border=0 align=center cellpadding=0 cellspacing=0>
				<tr align=center><td>LAPORAN MONITORING ANGGARAN PER KECAMATAN</td></tr>
				<tr align=center><td>".strtoupper($rskpd[nm_Skpd])."</td></tr>
                <tr align=center><td>KECAMATAN ".strtoupper($arrkec[$idkec])."</td></tr>
				<tr align=center><td>Tahun Anggaran : $_SESSION[thn_Login]</td></tr></table></div>	
<table class=basic width=796 border=0 align=center cellpadding=0 cellspacing=0 id=tablemodul1>  
<tr>
    <th>No</th>
    <th>Program / Kegiatan</th>
    <th>Lokasi</th>
    <th>Anggaran</th>
    <th>Realisasi</th>
    <th>Total</th>
    <th>%</th>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>";
  /*
    $q = mysql_query("SELECT *,b.id_Program,a.id_Skpd,a.TahunAnggaran  
                        FROM datakegiatan a, kegiatan b 
                        WHERE a.id_Kegiatan = b.id_Kegiatan 
                        AND a.id_Skpd = '$_SESSION[id_Skpd]' 
                        AND a.TahunAnggaran = '$_SESSION[thn_Login]' 
                        GROUP BY b.id_Program");
    while($r=mysql_fetch_array($q)) {
            $q1 = mysql_query("SELECT nm_Program, id_Program  
                                      FROM program 
                                      WHERE id_Program = '$r[id_Program]'");
            $r1=mysql_fetch_array($q1);
        echo "<tr>
            <td>&nbsp;</td>
            <td><strong>$r1[nm_Program]</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>";
        $q2 = mysql_query("SELECT a.nm_Kegiatan, b.id_DataKegiatan,b.AnggKeg, LEFT(c.id_Desa,7) kec 
                FROM kegiatan a, datakegiatan b, subkegiatan c  
                WHERE a.id_Kegiatan = b.id_Kegiatan 
                AND b.id_DataKegiatan = c.id_DataKegiatan 
                AND b.id_Skpd = '$r[id_Skpd]' 
                AND b.TahunAnggaran = '$r[TahunAnggaran]' 
                AND a.id_Program = '$r1[id_Program]' 
                HAVING kec = '$_GET[id_Kecamatan]'");
        while ($r2=mysql_fetch_array($q2)) {
            echo "<tr>
                    <td>&nbsp;</td>
                    <td>$r2[nm_Kegiatan]</td>
                    <td>$r2[kec]</td>
                    <td></td>";
                    
                    //$total = totalkeg(maxbulan($r2['id_DataKegiatan']),$r2['id_DataKegiatan']);
                    //$persen = ($total / $r2['AnggKeg']) * 100;
                echo "<td>".number_format($total)."</td>
                    <td>".round($persen,2)."</td>
                    <td>".round($persen,2)."</td>
                  </tr>";
            $q3 = mysql_query("SELECT nm_SubKegiatan,nl_Pagu FROM subkegiatan 
                                WHERE id_DataKegiatan = '$r2[id_DataKegiatan]'");
            while($r3=mysql_fetch_array($q3)) {
                    echo "<tr>
                            <td>&nbsp;</td>
                            <td>- $r3[nm_SubKegiatan]</td>
                            <td></td>
                            <td>$r3[nl_Pagu]</td>";
                        echo "<td></td>
                            <td></td>
                            <td></td>
                          </tr>";
            }
        }
    }

*/
  $q = mysql_query("SELECT *,b.id_Program,a.id_Skpd,a.TahunAnggaran, LEFT(c.id_Desa,7) kec  
                        FROM datakegiatan a, kegiatan b, subkegiatan c 
                        WHERE a.id_Kegiatan = b.id_Kegiatan 
                        AND a.id_DataKegiatan = c.id_DataKegiatan
                        AND a.id_Skpd = '$_SESSION[id_Skpd]' 
                        AND a.TahunAnggaran = '$_SESSION[thn_Login]' 
                        GROUP BY b.id_Program");   
                        //HAVING kec = '$_GET[id_Kecamatan]'");
    while($r=mysql_fetch_array($q)) {
            $q1 = mysql_query("SELECT nm_Program, id_Program  
                                      FROM program 
                                      WHERE id_Program = '$r[id_Program]'");
            $r1=mysql_fetch_array($q1);
        echo "<tr>
            <td>&nbsp;</td>
            <td><strong>$r1[nm_Program]</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>";
        $q2 = mysql_query("SELECT a.nm_Kegiatan, b.id_DataKegiatan,b.AnggKeg, LEFT(c.id_Desa,7) kec 
                FROM kegiatan a, datakegiatan b, subkegiatan c  
                WHERE a.id_Kegiatan = b.id_Kegiatan 
                AND b.id_DataKegiatan = c.id_DataKegiatan 
                AND b.id_Skpd = '$r[id_Skpd]' 
                AND b.TahunAnggaran = '$r[TahunAnggaran]' 
                AND a.id_Program = '$r1[id_Program]' 
                GROUP BY a.id_Kegiatan  
                HAVING kec = '$_GET[id_Kecamatan]'");
        while ($r2=mysql_fetch_array($q2)) {
            echo "<tr>
                    <td>&nbsp;</td>
                    <td>$r2[nm_Kegiatan]</td>
                    <td></td>
                    <td></td>";
                    
                    //$total = totalkeg(maxbulan($r2['id_DataKegiatan']),$r2['id_DataKegiatan']);
                    //$persen = ($total / $r2['AnggKeg']) * 100;
                echo "<td>".number_format($total)."</td>
                    <td>".round($persen,2)."</td>
                    <td>".round($persen,2)."</td>
                  </tr>";
            $q3 = mysql_query("SELECT a.nm_SubKegiatan,a.nl_Pagu,b.nm_Desa,LEFT(a.id_Desa,7) kec  
                                FROM subkegiatan a, desa b  
                                WHERE a.id_DataKegiatan = '$r2[id_DataKegiatan]' 
                                AND a.id_Desa = b.id_Desa
                                HAVING kec = '$_GET[id_Kecamatan]'");
            while($r3=mysql_fetch_array($q3)) {
                    echo "<tr>
                            <td>&nbsp;</td>
                            <td>- $r3[nm_SubKegiatan]</td>
                            <td>".$arrkec[$r3[kec]]." / $r3[nm_Desa]</td>
                            <td>".number_format($r3[nl_Pagu])."</td>";
                        echo "<td></td>
                            <td></td>
                            <td></td>
                          </tr>";
            }
        }
    }


echo "</table>
</body>";

}


?>