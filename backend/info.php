<?php
 include_once "detour.php";
 include_once "../classes/errormngr.php";
 include_once "../sc-config.php";
 
 
?>
<!DOCTYPE HTML>
<html style="height: 100%">
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>Information - simplecontent</title>
  <link rel="stylesheet" href="css/default.css">
  <link rel="stylesheet" href="css/ui.css">
  </head>
  <body style="height: 100%">
  <div id="wrapper" style="height: 100%">
   <div id="top-bar"><h4>Eingeloggt als <?php echo $usr; ?> - <a href="login.php?logoff=1" title="Ausloggen">Ausloggen</a>?</h4></div>
   <div id="left-menu-bar">
    <?php
     include_once "menu.inc.php";
    ?>
   </div>
   <div id="main">
    <h2>Information</h2>
    Your simplecontent-Version: <strong>0.0.1</strong>   <br>
    <h2>Credits</h2>
    simplecontent use the Editor TinyMCE (Version 3) from Moxiecode.
    <br>
    simplecontent use the Thumbnail-Script from SelfPHP.
   
   </div>
  </body>
</html>
