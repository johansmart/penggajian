<?php
include_once "library/inc.sesadmin.php";
include_once "library/inc.library.php";
?>
<ul class="breadcrumb">
				<li>
					DATA BAGIAN
				</li>
				
</ul>
<table class="table" width="750" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="26" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="218" bgcolor="#CCCCCC"><strong>Nama Bagian </strong></td>
    <td width="119" bgcolor="#CCCCCC"><strong>Gaji Pokok (Rp) </strong></td>
    <td width="120" bgcolor="#CCCCCC"><strong>Uang Transport (Rp) </strong></td>
    <td width="118" bgcolor="#CCCCCC"><strong>Uang Makan (Rp) </strong></td>
    <td width="118" bgcolor="#CCCCCC"><strong>Uang Lembur (Rp) </strong></td>
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
    <td><?php echo $myData['nm_bagian']; ?></td>
    <td><?php echo format_angka($myData['gaji_pokok']); ?></td>
    <td><?php echo format_angka($myData['uang_transport']); ?></td>
    <td><?php echo format_angka($myData['uang_makan']); ?></td>
    <td><?php echo format_angka($myData['uang_lembur']); ?></td>
  </tr>
  <?php } ?>
</table>
<br />
<a href="cetak/bagian.php" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>