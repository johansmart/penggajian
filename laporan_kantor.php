<?php
include_once "library/inc.sesadmin.php";
include_once "library/inc.library.php";
?>
<h2> LAPORAN DATA KANTOR </h2>
<table class="table-list" width="750" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="33" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="60" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="282" bgcolor="#CCCCCC"><strong>Nama Kantor </strong></td>
    <td width="354" bgcolor="#CCCCCC"><strong>Lokasi</strong></td>
  </tr>
	<?php
	$mySql = "SELECT * FROM kantor ORDER BY kd_kantor ASC";
	$myQry = mysqli_query($koneksidb, $mySql)  or die ("Query salah : ".mysqli_errno());
	$nomor	 = 0; 
	while ($myData = mysqli_fetch_array($myQry)) {
	$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_kantor']; ?></td>
    <td><?php echo $myData['nm_kantor']; ?></td>
    <td><?php echo $myData['lokasi']; ?></td>
  </tr>
  <?php } ?>
</table>
<br />
<a href="cetak/kantor.php" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>