<?php
include_once "library/inc.sesadmin.php";
include_once "library/inc.library.php";
?>
<h2>LAPORAN DAFTAR USER </h2>
<table class="table-list" width="600" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="40" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="222" bgcolor="#CCCCCC"><strong>Nama User</strong></td>
    <td width="192" bgcolor="#CCCCCC"><strong>Username</strong></td>  
    <td width="125" bgcolor="#CCCCCC"><strong>Level</strong></td>
  </tr>
	<?php
	$mySql = "SELECT * FROM user ORDER BY kd_user ASC";
	$myQry = mysqli_query($koneksidb, $mySql)  or die ("Query salah : ".mysqli_errno());
	$nomor	 = 0; 
	while ($myData = mysqli_fetch_array($myQry)) {
	$nomor++;
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['nm_user']; ?></td>
    <td><?php echo $myData['username']; ?></td>
    <td><?php echo $myData['level']; ?></td>
  </tr>
  <?php } ?>
</table>
<br />
<a href="cetak/user.php" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
