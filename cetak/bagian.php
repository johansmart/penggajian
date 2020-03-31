<?php
session_start();
include_once "../library/inc.sesadmin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

?>
<html>
<head>
<title>:: Data Bagian</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> DATA BAGIAN </h2>
<table class="table-list" width="752" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="30" align="center" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="106" bgcolor="#CCCCCC"><strong>Kode Bagian </strong></td>
    <td width="160" bgcolor="#CCCCCC"><b>Nama Bagian </b></td>
    <td width="100" bgcolor="#CCCCCC"><strong>Gaji Pokok </strong></td>
    <td width="120" bgcolor="#CCCCCC"><strong>Uang Transport </strong></td>
    <td width="100" bgcolor="#CCCCCC"><strong>Uang Makan </strong></td>
    <td width="100" bgcolor="#CCCCCC"><strong>Uang Lembur </strong></td>
  </tr>
  <?php
	$mySql = "SELECT * FROM bagian ORDER BY kd_bagian ASC";
	$myQry = mysqli_query($koneksidb, $mySql)  or die ("Query salah : ".mysqli_errno());
	$nomor	 = 0; 
	while ($myData = mysqli_fetch_array($myQry)) {
	$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_bagian']; ?></td>
    <td><?php echo $myData['nm_bagian']; ?></td>
    <td><?php echo format_angka($myData['gaji_pokok']); ?></td>
    <td><?php echo format_angka($myData['uang_transport']); ?></td>
    <td><?php echo format_angka($myData['uang_makan']); ?></td>
    <td><?php echo format_angka($myData['uang_lembur']); ?></td>
  </tr>
  <?php } ?>
</table>
<img src="../images/btn_print.png" width="20" onClick="javascript:window.print()" />
</body>
</html>