<?php
session_start();
include_once "../library/inc.sesadmin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

$namaBulan = array("01" => "Januari", "02" => "Februari", "03" => "Maret",
				 "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli",
				 "08" => "Agustus", "09" => "September", "10" => "Oktober",
				 "11" => "November", "12" => "Desember");

$dataTahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$dataBulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
?>
<html>
<head>
<title>:: Data Lembur</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> DATA LEMBUR </h2>
<table width="500" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#CCCCCC"><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td width="134"><strong>Periode Bulan</strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="337"><?php echo $namaBulan[$dataBulan]; ?> , <?php echo $dataTahun; ?></td>
  </tr>
</table>
<table class="table-list" width="700" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="26" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="91" bgcolor="#CCCCCC"><b>Tanggal</b></td>
    <td width="105" bgcolor="#CCCCCC"><strong>NIP</strong></td>
    <td width="210" bgcolor="#CCCCCC"><strong>Pegawai </strong></td>
    <td width="242" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
  </tr>
  <?php
	$mySql 	= "SELECT lembur.*, pegawai.nip, pegawai.nm_pegawai FROM lembur
				LEFT JOIN pegawai ON lembur.kd_pegawai=pegawai.kd_pegawai 
				WHERE LEFT(tanggal,4)='$dataTahun' AND MID(tanggal,6,2)='$dataBulan'
				ORDER BY lembur.id ASC";
	$myQry 	= mysqli_query($koneksidb, $mySql)  or die ("Query  salah : ".mysqli_errno());
	$nomor  = 0; 
	while ($kolomData = mysqli_fetch_array($myQry)) {
		$nomor++;
		$Kode = $kolomData['id'];
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($kolomData['tanggal']); ?></td>
    <td><?php echo $kolomData['nip']; ?></td>
    <td><?php echo $kolomData['nm_pegawai']; ?></td>
    <td><?php echo $kolomData['keterangan']; ?></td>
  </tr>
  <?php } ?>
</table>
<img src="../images/btn_print.png" width="20" onClick="javascript:window.print()" />
</body>
</html>