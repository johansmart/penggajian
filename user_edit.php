<?php
include_once "library/inc.sesadmin.php";

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
	if (trim($cmbLevel)=="KOSONG") {
		$pesanError[] = "Data <b>Level login</b> belum dipilih !";		
	}
	
	# VALIDASI NAMA, jika sudah ada akan ditolak
	$txtUsernameLm	= $_POST['txtUsernameLm'];
	$cekSql="SELECT * FROM user WHERE username='$txtUsername' AND NOT(username='$txtUsernameLm')";
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
		// Jika tidak menemukan error, simpan data ke database

		# Cek Password baru
		if (trim($txtPassword)=="") {
			$sqlSub = " password='".$_POST['txtPasswordLm']."'";
		}
		else {
			$sqlSub = "  password ='".md5($txtPassword)."'";
		}
		
		# SIMPAN DATA KE DATABASE. 
		$Kode	= $_POST['txtKode']; // membaca Kode dari form hidden
		$mySql  = "UPDATE user SET nm_user='$txtNamaUser', username='$txtUsername', 
					no_telepon='$txtTelpon', level='$cmbLevel', $sqlSub  WHERE kd_user='$Kode'";
		$myQry=mysqli_query($koneksidb, $mySql) or die ("Gagal query".mysqli_errno());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=User-Data'>";
		}
		exit;
	}	
} // Penutup POST

# ====================== TAMPILKAN  DATA KE FORM ===============================================
# TAMPILKAN DATA DARI DATABASE, Untuk ditampilkan kembali ke form edit
$Kode  = isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 
$mySql = "SELECT * FROM user WHERE kd_user='$Kode'";
$myQry = mysqli_query($koneksidb, $mySql)  or die ("Query ambil data salah : ".mysqli_errno());
	// Baca data
	$myData = mysqli_fetch_array($myQry);
	
	// Masukkan data ke dalam variabel
	$dataKode		= $myData['kd_user'];
	$dataNamaUser	= isset($_POST['txtNamaUser']) ? $_POST['txtNamaUser'] : $myData['nm_user'];
	$dataUsername	= isset($_POST['txtUsername']) ? $_POST['txtUsername'] : $myData['username'];
	$dataTelpon		= isset($_POST['txtTelpon']) ? $_POST['txtTelpon'] : $myData['no_telepon']; 
	$dataLevel		= isset($_POST['cmbLevel']) ? $_POST['cmbLevel'] : $myData['level'];
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
    <tr>
      <th colspan="3"><b>UBAH DATA USER </b></th>
    </tr>
    <tr>
      <td width="231"><b>Kode</b></td>
      <td width="5"><b>:</b></td>
      <td width="950"> <input name="textfield" type="text"  value="<?php echo $dataKode; ?>" size="10" maxlength="5"  readonly="readonly"/>
      <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td>
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
      <td><input name="txtUsername" type="text"  value="<?php echo $dataUsername; ?>" size="60" maxlength="20" />
      <input name="txtUsernameLm" type="hidden" value="<?php echo $myData['username']; ?>" /></td>
    </tr>
    <tr>
      <td><b>Password</b></td>
      <td><b>:</b></td>
      <td><input name="txtPassword" type="password" size="60" maxlength="100" />
      <input name="txtPasswordLm" type="hidden" value="<?php echo $myData['password']; ?>" /></td>
    </tr>
    <tr>
      <td><b>Level</b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbLevel">
          <option value="BLANK">....</option>
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
        <input type="submit" name="btnSimpan" value=" Simpan " /> </td>
    </tr>
  </table>
</form>
