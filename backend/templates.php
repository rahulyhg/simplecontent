<?php
 include_once "detour.php";
 include_once "../classes/errormngr.php";
 include_once "../sc-config.php";
 if($rights < 3) {
  die("You can't display the page.");
 }
 
 
?>
<!DOCTYPE HTML>
<html style="height: 100%">
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>Templates - simplecontent</title>
  <link rel="stylesheet" href="css/default.css">
  <link rel="stylesheet" href="css/ui.css">
  </head>
  <body style="height: 100%">
  <div id="wrapper" style="height: 100%">
   <div id="top-bar"><h4>Logged in as <?php echo $usr; ?> - <a href="login.php?logoff=1" title="Logg out">Log out</a>?</h4></div>
   <div id="left-menu-bar">
    <?php
     include_once "menu.inc.php";
    ?>
   </div>
   <h2>Templates</h2>
   <iframe style="margin-left: 30px;" name="simplecontent_template_mashine" width="80%" src="http://localhost/simplecontent-cms.org/templates?no_menu=true" height="80%" frameborder="no"></iframe>
   
   </div>
  </body>
</html>
