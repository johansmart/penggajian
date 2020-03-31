<?php
include_once "library/inc.sesadmin.php";

# PADA SAAT TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# BACA DATA DALAM FORM, masukkan datake variabel
	$txtNamaUser= $_POST['txtNamaUser'];
	$txtTelpon	= $_POST['txtTelpon'];
	$txtUsername= $_POST['txtUsername'];
	$txtPassword= $_POST['txtPassword'];
	$cmbLevel	= $_POST['cmbLevel'];

	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($txtNamaUser)=="") {
		$pesanError[] = "Data <b>Nama User</b> tidak boleh kosong !";		
	}
	if (trim($txtTelpon)=="") {
		$pesanError[] = "Data <b>No. Telepon</b> tidak boleh kosong !";		
	}
	if (trim($txtUsername)=="") {
		$pesanError[] = "Data <b>Username</b> tidak boleh kosong !";		
	}
	if (trim($txtPassword)=="") {
		$pesanError[] = "Data <b>Password</b> tidak boleh kosong !";		
	}
	if (trim($cmbLevel)=="KOSONG") {
		$pesanError[] = "Data <b>Level login</b> belum dipilih !";		
	}
			
	
	# VALIDASI NAMA, jika sudah ada akan ditolak
	$cekSql="SELECT * FROM user WHERE username='$txtUsername'";
	$cekQry=mysqli_query($koneksidb, $cekSql) or die ("Eror Query".mysqli_errno()); 
	if(mysqli_num_rows($cekQry)>=1){
		$pesanError[] = "USERNAME <b> $txtUsername </b> SUDAH ADA, ganti dengan yang lain";
	}

	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		# SIMPAN DATA KE DATABASE. Jika tidak menemukan pesan error, simpan data ke database
		$kodeBaru	= buatKode("kd_user","user", "U");
		$mySql  	= "INSERT INTO user (kd_user, nm_user, no_telepon, username, password, level)
						VALUES ('$kodeBaru', 
								'$txtNamaUser', 
								'$txtTelpon', 
								'$txtUsername', 
								MD5('$txtPassword'), 
								'$cmbLevel')";
		$myQry=mysqli_query($koneksidb, $mySql) or die ("Gagal query".mysqli_errno());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=User-Add'>";
		}
		exit;
	}	
} // Penutup POST

# MASUKKAN DATA KE VARIABEL
// Supaya saat ada pesan error, data di dalam form tidak hilang. Jadi, tinggal meneruskan/memperbaiki yg salah
$dataKode		= buatKode("kd_user","user", "U");
$dataNamaUser	= isset($_POST['txtNamaUser']) ? $_POST['txtNamaUser'] : '';
$dataUsername	= isset($_POST['txtUsername']) ? $_POST['txtUsername'] : '';
$dataTelpon		= isset($_POST['txtTelpon']) ? $_POST['txtTelpon'] : '';
$dataLevel		= isset($_POST['cmbLevel']) ? $_POST['cmbLevel'] : '';
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
    <tr>
      <th colspan="3"><b>TAMBAH DATA USER </b></th>
    </tr>
    <tr>
      <td width="231"><b>Kode</b></td>
      <td width="5"><b>:</b></td>
      <td width="950"> <input name="textfield" type="text" value="<?php echo $dataKode; ?>" size="10" maxlength="6" readonly="readonly"/></td>
    </tr>
    <tr>
      <td><b>Nama User </b></td>
      <td><b>:</b></td>
      <td><input name="txtNamaUser" type="text" value="<?php echo $dataNamaUser; ?>" size="60" maxlength="100" /></td>
    </tr>
    <tr>
      <td><b>No. Telepon </b></td>
      <td><b>:</b></td>
      <td><input name="txtTelpon" type="text" value="<?php echo $dataTelpon; ?>" size="60" maxlength="20" /></td>
    </tr>
    <tr>
      <td><b>Username</b></td>
      <td><b>:</b></td>
      <td> <input name="txtUsername" type="text"  value="<?php echo $dataUsername; ?>" size="60" maxlength="20" /></td>
    </tr>
    <tr>
      <td><b>Password</b></td>
      <td><b>:</b></td>
      <td><input name="txtPassword" type="password" size="60" maxlength="100" /></td>
    </tr>
    <tr>
      <td><b>Level</b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbLevel">
          <option value="KOSONG">....</option>
          <?php
		  $pilihan	= array("kasir", "direktur", "admin");
          foreach ($pilihan as $nilai) {
            if ($dataLevel==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>
        <input type="submit" name="btnSimpan" value=" Simpan " />      </td>
    </tr>
  </table>
</form>
