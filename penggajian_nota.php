<?php
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

# Baca variabel URL
$noNota = $_GET['noNota'];

# Perintah untuk mendapatkan data dari tabel penggajian
$mySql = "SELECT penggajian.*, user.nm_user, pegawai.nip, pegawai.nm_pegawai, bagian.nm_bagian, bagian.uang_lembur
			FROM penggajian
			LEFT JOIN user ON penggajian.kd_user=user.kd_user 
			LEFT JOIN pegawai ON penggajian.kd_pegawai=pegawai.kd_pegawai
			LEFT JOIN bagian ON pegawai.kd_bagian=bagian.kd_bagian
			WHERE no_penggajian='$noNota'";
$myQry = mysqli_query($koneksidb, $mySql)  or die ("Query salah sss: ".mysqli_errno());
$myData= mysqli_fetch_array($myQry);

$kdPegawai = $myData['kd_pegawai'];

$dataBulan	= substr($myData['periode_gaji'],0,2); // ambil bulan
$dataTahun	= substr($myData['periode_gaji'],3,4); // ambil tahun

// Hitung Gaji Total
$totalGaji	= 0;
$totalGaji	= $totalGaji + $myData['gaji_pokok'];
$totalGaji	= $totalGaji + $myData['tunj_jabatan'];
$totalGaji	= $totalGaji + $myData['tunj_transport'];
$totalGaji	= $totalGaji + $myData['tunj_makan'];
$totalGaji	= $totalGaji + $myData['total_lembur'];
$totalGaji	= $totalGaji + $myData['total_bonus'];
$totalGaji	= $totalGaji - $myData['total_pinjaman'];
?>
<html>
<head>
<title> :: Slip Gaji Pegawai</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles/styles_cetak.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
	window.print();
	window.onfocus=function(){ window.close();}
</script>
</head>
<body onLoad="window.print()">
<table class="table-list" width="430" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td colspan="4" align="center"><h2>SLIP GAJI </h2></td>
  </tr>
  <tr>
    <td  colspan="4" align="center">
      <table width="100%" border="0" cellpadding="2" cellspacing="1">
        <tr>
          <td width="24%"><strong>Tanggal</strong></td>
          <td width="4%"><strong>:</strong></td>
          <td width="72%"> <?php echo IndonesiaTgl($myData['tanggal']); ?> </td>
        </tr>
        <tr>
          <td><strong>Periode Gaji</strong></td>
          <td><strong>:</strong></td>
          <td> <?php echo $myData['periode_gaji']; ?> </td>
        </tr>
        <tr>
          <td><strong>Nama</strong></td>
          <td><strong>:</strong></td>
          <td> <?php echo $myData['nip']." / ".$myData['nm_pegawai']; ?> </td>
        </tr>
        <tr>
          <td><strong>Bagian</strong></td>
          <td><strong>:</strong></td>
          <td> <?php echo $myData['nm_bagian']; ?> </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td width="294" align="right"><strong>Gaji Pokok   (Rp)+ : </strong></td>
    <td width="125" align="right"><?php echo format_angka($myData['gaji_pokok']); ?></td>
  </tr>
  <tr>
    <td align="right"><strong> Tunjangan Jabatan (Rp)+ : </strong></td>
    <td align="right"><?php echo format_angka($myData['tunj_jabatan']); ?></td>
  </tr>
  <tr>
    <td align="right"><strong> Tunjangan Transport (Rp)+ : </strong></td>
    <td align="right"><?php echo format_angka($myData['tunj_transport']); ?></td>
  </tr>
  <tr>
    <td align="right"><strong>Tunjangan Makan (Rp)+ : </strong></td>
    <td align="right"><?php echo format_angka($myData['tunj_makan']); ?></td>
  </tr>
  
 <?php
 $my2Sql = "SELECT * FROM lembur WHERE kd_pegawai='$kdPegawai' AND LEFT(tanggal,4)='$dataTahun' AND MID(tanggal,6,2)='$dataBulan' ";
 $my2Qry = mysqli_query($koneksidb, $my2Sql)  or die ("Query salah : ".mysqli_errno()); 
 $lemburKe =0;
 while($my2Data= mysqli_fetch_array($my2Qry)) {
 $lemburKe++;
 ?>
  <tr>
    <td align="right"><strong>Uang Lembur  <?php echo $lemburKe; ?> (Rp)+ : </strong></td>
    <td align="right"><?php echo format_angka($myData['uang_lembur']); ?></td>
  </tr>
  <?php } ?>
  
  <tr>
    <td align="right"><strong>Uang Bonus  (Rp)+ : </strong></td>
    <td align="right"><?php echo format_angka($myData['total_bonus']); ?></td>
  </tr>
  
  <?php
 $my3Sql = "SELECT * FROM pinjaman WHERE kd_pegawai='$kdPegawai' AND status_lunas='Yes' 
 			AND LEFT(tanggal,4)='$dataTahun' AND MID(tanggal,6,2)='$dataBulan' ";
 $my3Qry = mysqli_query($koneksidb, $my3Sql)  or die ("Query salah : ".mysqli_errno());
 $pinjamKe =0;
 while($my3Data= mysqli_fetch_array($my3Qry)) {
 $pinjamKe++;
 ?>
  <tr>
    <td align="right"><strong>Total Pinjaman <?php echo $pinjamKe; ?> (Rp)- : </strong></td>
    <td align="right"><?php echo format_angka($my3Data['besar_pinjaman']); ?></td>
  </tr>
  <?php } ?>
  
  <tr>
    <td align="right" bgcolor="#CCCCCC"><strong>Total Gaji   (Rp) : </strong></td>
    <td align="right" bgcolor="#CCCCCC"><b><?php echo format_angka($totalGaji); ?></b></td>
  </tr>
  <tr>
    <td colspan="4">Admin : <?php echo $myData['nm_user']; ?></td>
  </tr>
</table>
<table width="430" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">** TERIMA KASIH ** </td>
  </tr>
</table>
</body>
</html>