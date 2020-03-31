<?php
include_once "library/inc.sesadmin.php";
include_once "library/inc.library.php";

// Membaca data dari Form
$filterSql="";
$dataBagian	= isset($_POST['cmbBagian']) ? $_POST['cmbBagian'] : 'ALL'; 

// Filter data saat tombol Tampil diklik
if(isset($_POST['btnTampil'])) {
	if($_POST['cmbBagian']=="ALL") {
		$filterSql	= "";
	}
	else {
		$filterSql	= " WHERE pegawai.kd_bagian='$dataBagian'";
	}
}
?>
<ul class="breadcrumb">
				<li>
					LAPORAN DATA PEGAWAI
				</li>
				
</ul>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
<table class="table" width="400" border="0" cellpadding="2" cellspacing="1">
  <tr>
    <td colspan="3" bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
  </tr>
  <tr>
    <td width="84"><strong>Pilih Bagian  </strong></td>
    <td width="5"><strong>:</strong></td>
    <td width="295">
	<select name="cmbBagian">
      <option value="ALL">....</option>
      <?php
	  $dataSql = "SELECT * FROM bagian ORDER BY kd_bagian";
	  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errno());
	  while ($dataRow = mysqli_fetch_array($dataQry)) {
	  	if ($dataBagian == $dataRow['kd_bagian']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$dataRow[kd_bagian]' $cek>$dataRow[nm_bagian]</option>";
	  }
	  $sqlData ="";
	  ?>
    </select>
    <input name="btnTampil" type="submit" value=" Tampilkan " /></td>
  </tr>
</table>
</form>

<table class="table" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="27" align="center" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="59" bgcolor="#CCCCCC"><strong>NIP</strong></td>
    <td width="139" bgcolor="#CCCCCC"><strong>Nama Pegawai </strong></td>
    <td width="105" bgcolor="#CCCCCC"><strong> Bagian </strong></td>
    <td width="56" bgcolor="#CCCCCC"><strong> Kelamin</strong></td>
    <td width="54" bgcolor="#CCCCCC"><strong>G Darah </strong></td>
    <td width="72" bgcolor="#CCCCCC"><strong>Agama</strong></td>
    <td width="300" bgcolor="#CCCCCC"><strong>Alamat Tinggal </strong></td>
    <td width="42" bgcolor="#CCCCCC"><strong>Tools</strong></td>
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
    <td><a href="cetak/pegawai_cetak.php?Kode=<?php echo $myData['kd_pegawai']; ?>" target="_blank">Cetak</a></td>
  </tr>
  <?php } ?>
</table>
<br />
<a href="cetak/pegawai.php?KdBagian=<?php echo $dataBagian; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>