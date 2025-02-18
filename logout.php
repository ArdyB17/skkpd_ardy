<?php

setcookie('username', '', time(), '/');
setcookie('level_user', '', time(), '/');
setcookie('Nama_Lengkap', '', time(), '/');

echo "<script>alert('Logout Berhasil');window.location.href='login.php'</script>";

?>