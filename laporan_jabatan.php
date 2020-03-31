<?php
include_once "library/inc.sesadmin.php";
include_once "library/inc.library.php";
?>
<ul class="breadcrumb">
				<li>
					LAPORAN DATA JABATAN
				</li>
				
</ul>
<table class="table" width="750" border="0" cellspacing="1" cellpadding="2">
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
<br />
<a href="cetak/jabatan.php" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>