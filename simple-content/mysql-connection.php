<?php
  require_once ("./simple-config.php");
  $conn = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD);
  mysqli_select_db($conn, MYSQL_NAME);
?>