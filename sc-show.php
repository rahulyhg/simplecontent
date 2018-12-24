<?php
 /**
  * @package simplecontent
  */
  
  require_once "sc-config.php";
  if(ACTIVATE == "yes___") {
  require_once("sc-load.php");
  
  $template = getSetting("actual_template");
  
  require_once("simple-content/template/$template/index.php");
  
  if(file_exists("backend/install.php")) {
    unlink("backend/install.php");
  }
  } elseif(ACTIVATE == "no_____") {
    header("Location: backend/install.php");  
  }
?>