<?php
 include_once "detour.php";
 include_once "../classes/errormngr.php";
 include_once "../sc-config.php";
 include_once "../sc-load.php";
 
 
?>
<!DOCTYPE HTML>
<html style="height: 100%">
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>New category - simplecontent</title>
  <link rel="stylesheet" href="css/default.css">
  <link rel="stylesheet" href="css/ui.css">
  </head>
  <body style="height: 100%">
  <div id="wrapper" style="height: 100%">
   <div id="top-bar"><h4>Logged in as <?php echo $usr; ?> - <a href="login.php?logoff=1" title="Log out">Log out</a>?</h4></div>
   <div id="left-menu-bar">
    <?php
     include_once "menu.inc.php";
    ?>
   </div>
   <div id="main">
   <h2>New category</h2> 
   <form action="#" method="POST">
    Name: <input type="text" name="name">
    <br>
    <input type="submit" name="go" value="Create" class="publish-standard">
   </form>
   <?php
    if(!empty($_POST['go'])) {
      $conn = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_NAME);
      $name = mysqli_real_escape_string($conn, $_POST['name']);
      $sql  = "INSERT INTO " . TBL_PRF . "categorys VALUES ('', '$name', '$usr_ID', '0')";
      $query= connectMySQL($sql, false, false);
      if($query) {
        echo "<p>The category was <strong>successfully created</strong>!</p>";
      } else {
        echo "<p>We <strong>can't update the category</strong>!</p>";
      }
    }
   ?>
   </div>
  </body>
</html>
