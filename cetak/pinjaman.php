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
<title>:: Data Pinjaman</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> DATA PINJAMAN </h2>
<table width="400" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#CCCCCC"><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td width="134"><strong>Periode Bulan</strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="337"><?php echo $namaBulan[$dataBulan]; ?> , <?php echo $dataTahun; ?></td>
  </tr>
</table>
<br />

<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="30" align="center" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="81" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
    <td width="92" bgcolor="#CCCCCC"><b>NIP </b></td>
    <td width="184" bgcolor="#CCCCCC"><strong>Nama Pegawai </strong></td>
    <td width="110" align="right" bgcolor="#CCCCCC"><strong> Pinjaman (Rp) </strong></td>
    <td width="198" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
    <td width="69" bgcolor="#CCCCCC"><strong>Status </strong></td>
  </tr>
  <?php
	$mySql = "SELECT pinjaman.*, pegawai.nip, pegawai.nm_pegawai FROM pinjaman
				LEFT JOIN pegawai ON pinjaman.kd_pegawai=pegawai.kd_pegawai 
				WHERE LEFT(tanggal,4)='$dataTahun' AND MID(tanggal,6,2)='$dataBulan'
				ORDER BY pinjaman.no_pinjaman ASC";
	$myQry = mysqli_query($koneksidb, $mySql)  or die ("Query salah : ".mysqli_errno());
	$nomor	 = 0; 
	while ($myData = mysqli_fetch_array($myQry)) {
		$nomor++;

		// Status Lunas
		if($myData['status_lunas']=="Lunas") {
			$status="Lunas";
		}
		else {
			$status = "Hutang";
		}
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tanggal']); ?></td>
    <td><?php echo $myData['nip']; ?></td>
    <td><?php echo $myData['nm_pegawai']; ?></td>
    <td align="right"><?php echo format_angka($myData['besar_pinjaman']); ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td><?php echo $status; ?></td>
  </tr>
  <?php } ?>
</table>
<img src="../images/btn_print.png" width="20" onClick="javascript:window.print()" />
</body>
</html>