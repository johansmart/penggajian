<?php
include_once "library/inc.sesadmin.php";

# Set nilai pada filter
$filterSQL = "";

# MEMBACA DATA KODE Pegawai
$Kode			= isset($_GET['Kode']) ? $_GET['Kode'] : "KOSONG";
$kodePegawai 	= isset($_POST['cmbPegawai']) ? $_POST['cmbPegawai'] : $Kode;

// Membuat Sub SQL dengan Filter
if(trim($kodePegawai)=="KOSONG") {
	$filterSQL = ""; 
	
	$filterKode	= "";
}
else {
	$filterSQL = " WHERE riwayat_mutasi.kd_pegawai='$kodePegawai'";
	
	// URL Menu
	$filterKode	= "&KodeKy=$kodePegawai";
}

# UNTUK PAGING (PEMkantor HALAMAN)
$baris = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM riwayat_mutasi $filterSQL";
$pageQry = mysqli_query($koneksidb, $pageSql) or die ("error paging: ".mysqli_errno());
$jml	 = mysqli_num_rows($pageQry);
$maksData= ceil($jml/$baris);
?>
<ul class="breadcrumb">
				<li>
					DATA RIWAYAT MUTASI
				</li>
				
</ul>
	
	<form name="form1" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
      <table class="table" width="400" border="0" cellspacing="1" cellpadding="3">
        <tr>
          <td colspan="3" bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
          </tr>
        <tr>
          <td width="74"><strong> Pegawai </strong></td>
          <td width="5"><strong>:</strong></td>
          <td width="299">
		  <select name="cmbPegawai"  onchange="javascript:submitform();">
          <option value="KOSONG">....</option>
          <?php
		  $dataSql = "SELECT * FROM pegawai ORDER BY nip";
		  $dataQry = mysqli_query($koneksidb, $dataSql) or die ("Gagal Query".mysqli_errno());
		  while ($dataRow = mysqli_fetch_array($dataQry)) {
			if ($kodePegawai == $dataRow['kd_pegawai']) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$dataRow[kd_pegawai]' $cek> [ $dataRow[nip] ] $dataRow[nm_pegawai]</option>";
		  }
		  ?>
          </select></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><strong>
            <input name="btnTampil" type="submit" value="Tampilkan" />
          </strong></td>
        </tr>
      </table>
        </form>
   <a href="?page=Riwayat-Mutasi-Add<?php echo $filterKode; ?>" target="_self"><img src="images/btn_add_data.png" width="134" height="36" border="0" /></a><p></p>
	<table class="table" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="33"><strong>No</strong></th>
        <th width="319"><b>Kantor</b></th>
        <th width="120"><strong>Tgl. Mutasi </strong></th>
        <th width="203"><strong>Kantor Lama </strong></th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
      </tr>
      <?php
	$mySql 	= "SELECT riwayat_mutasi.*, kantor.nm_kantor, kantor.lokasi FROM riwayat_mutasi
				LEFT JOIN kantor ON riwayat_mutasi.kd_kantor = kantor.kd_kantor
				$filterSQL";
	$myQry 	= mysqli_query($koneksidb, $mySql)  or die ("Query  salah : ".mysqli_errno());
	$nomor  = 0; 
	while ($myData = mysqli_fetch_array($myQry)) {
		$nomor++;
		$ID = $myData['id'];
		
		// Warna baris data
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?> </td>
        <td><?php echo $myData['nm_kantor']." (".$myData['lokasi']." )"; ?> </td>
        <td><?php echo IndonesiaTgl($myData['tgl_mutasi']); ?></td>
        <td><?php echo $myData['kantor_lama']; ?></td>
        <td width="45" align="center"><a href="?page=Riwayat-Mutasi-Edit&ID=<?php echo $ID; ?>" target="_self">Edit</a></td>
        <td width="45" align="center"><a href="?page=Riwayat-Mutasi-Delete&ID=<?php echo $ID; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA riwayat MUTASI INI ... ?')">Delete</a></td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
  <strong>Halaman ke :</strong> 
	<?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?page=Riwayat-Mutasi-Data&hal=$list[$h]'>$h</a> ";
	}
	?>

