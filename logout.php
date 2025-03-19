<?php
session_start();
session_destroy();
header("Location: ad_pl_login.php");
exit();
?>