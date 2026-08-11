<?php
  session_start();
  $_SESSION[namauser]	= $r[username];
  $_SESSION[passuser]	= $r[password];
  $_SESSION[namaadm]	= $r[name];
  $_SESSION[accesslevel]= explode("-",$r[access]);
  
  header('location:index.php');
?>
