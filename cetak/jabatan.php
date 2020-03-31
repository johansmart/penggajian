<?php
session_start();
include_once "../library/inc.sesadmin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

?>
<html>
<head>
<title>:: Data Jabatan</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> DATA JABATAN </h2>
<table class="table-list" width="750" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="33" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="60" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="506" bgcolor="#CCCCCC"><strong>Nama Jabatan </strong></td>
    <td width="130" bgcolor="#CCCCCC"><strong>Tunjangan (Rp) </strong></td>
  </tr>
  <?php
	$mySql = "SELECT * FROM jabatan ORDER BY kd_jabatan ASC";
	$myQry = mysqli_query($koneksidb, $mySql)  or die ("Query salah : ".mysqli_errno());
	$nomor	 = 0; 
	while ($myData = mysqli_fetch_array($myQry)) {
	$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_jabatan']; ?></td>
    <td><?php echo $myData['nm_jabatan']; ?></td>
    <td><?php echo format_angka($myData['tunj_jabatan']); ?></td>
  </tr>
  <?php } ?>
</table>
<img src="../images/btn_print.png" width="20" onClick="javascript:window.print()" />
</body>
</html>