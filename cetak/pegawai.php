<?php
session_start();
include_once "../library/inc.sesadmin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

if(isset($_GET['KdBagian'])){
	$dataBagian	= isset($_GET['KdBagian']) ? $_GET['KdBagian'] : 'ALL'; 
	
	if($dataBagian=="ALL") {
		$filterSql	= "";
		$namaBagian= "Semua Bagian";
	}
	else {
		$filterSql	= "WHERE pegawai.kd_bagian='$dataBagian'";
		
		// Untuk informasi 
		$infoSql	= "SELECT * FROM bagian WHERE kd_bagian='$dataBagian'";
		$infoQry	= mysqli_query($infoSql, $koneksidb) or die ("Gagal Query".mysqli_errno());
	    $infoRow 	= mysqli_fetch_array($infoQry);
		$namaBagian = $infoRow['nm_bagian'];
	}
}
?>
<html>
<head>
<title>:: Data Pegawai</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> DATA PEGAWAI </h2>
<table width="400" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#CCCCCC"><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td width="134"><strong>Bagian</strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="337"><?php echo $namaBagian; ?></td>
  </tr>
</table>
<br />

<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="26" align="center" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="85" bgcolor="#CCCCCC"><strong>NIP</strong></td>
    <td width="174" bgcolor="#CCCCCC"><strong>Nama Pegawai </strong></td>
    <td width="131" bgcolor="#CCCCCC"><strong> Bagian </strong></td>
    <td width="60" bgcolor="#CCCCCC"><strong> Kelamin</strong></td>
    <td width="63" bgcolor="#CCCCCC"><strong>G Darah </strong></td>
    <td width="84" bgcolor="#CCCCCC"><strong>Agama</strong></td>
    <td width="236" bgcolor="#CCCCCC"><strong>Alamat Tinggal </strong></td>
  </tr>
  <?php
	$mySql = "SELECT pegawai.*, bagian.nm_bagian FROM pegawai
				LEFT JOIN bagian ON pegawai.kd_bagian=bagian.kd_bagian
				$filterSql
				ORDER BY pegawai.kd_pegawai ASC";
	$myQry = mysqli_query($koneksidb, $mySql)  or die ("Query salah : ".mysqli_errno());
	$nomor	 = 0; 
	while ($myData = mysqli_fetch_array($myQry)) {
	$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['nip']; ?></td>
    <td><?php echo $myData['nm_pegawai']; ?></td>
    <td><?php echo $myData['nm_bagian']; ?></td>
    <td><?php echo $myData['kelamin']; ?></td>
    <td><?php echo $myData['gol_darah']; ?></td>
    <td><?php echo $myData['agama']; ?></td>
    <td><?php echo $myData['alamat_tinggal']; ?></td>
  </tr>
  <?php } ?>
</table>
<img src="../images/btn_print.png" width="20" onClick="javascript:window.print()" />
</body>
</html>