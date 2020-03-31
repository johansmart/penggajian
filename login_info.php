<?php
$loginSql = "SELECT * FROM user WHERE kd_user='".$_SESSION['SES_LOGIN']."'";
$loginQry = mysqli_query($koneksidb, $loginSql)  or die ("Query user salah : ".mysqli_errno());
$loginRow = mysqli_fetch_array($loginQry);
?> <br><br>
<table width="600" border="0" class="table-list">
  <tr>
    <td colspan="3"><strong>INFO LOGIN </strong></td>
  </tr>
  <tr>
    <td width="195">User ID </td>
    <td width="10"><strong>:</strong></td>
    <td width="381"><?php echo $loginRow['username']; ?></td>
  </tr>
  <tr>
    <td>Nama Anda </td>
    <td><strong>:</strong></td>
    <td><?php echo $loginRow['nm_user']; ?></td>
  </tr>
</table>
