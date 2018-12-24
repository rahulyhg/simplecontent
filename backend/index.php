<?php
 
 include_once "detour.php";
 include_once "../classes/arrays.php";
 include_once "../sc-load.php";
 
 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html >
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>Welcome - simplecontent</title>
  <link rel="stylesheet" href="css/default.css">
  </head>
  <body>
  <div id="wrapper">
   <div id="top-bar"><h4>Logged in as <?php echo $usr; ?> - <a href="login.php?logoff=1" title="Log out">Log out</a>?</h4></div>
   <div id="left-menu-bar">
   <?php
    include_once "menu.inc.php";
   ?>
   </div>
   <div id="main">
    <h2>Backend</h2>
    <div id="box_max_width">
    <h2>Welcome, <?php print($usr); ?>! </h2>
    <a style="text-decoration: underline" href="../">Look at your website!</a>
    <h3>Tipps</h3>
    <ul>
    <?php
     if($rights >= 2) {
    ?>
      <li><a href="info.php">Look at the informations.</a></li>
      <li><a href="edit.php?type=post">Create a post.</a></li>
      <li><a href="media.php">Upload your images.</a></li>
      <?php
       }
      ?>
    </ul>
    </div>
   </div>
   </div>
  </body>
</html>
                                                                  