<?php

setcookie("username", "", time() - 1);
session_start();
session_unset();
session_destroy();
header("Refresh: 1; url=admin.php");

?>