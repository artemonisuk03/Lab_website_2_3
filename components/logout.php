<?php
setcookie("User", "", time()-7200);
header("Location: /components/login.php");
exit();
?>