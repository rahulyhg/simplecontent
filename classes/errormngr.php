<?php
function sc_error ($errcode) {
  switch($errcode) {
    case '01':
    echo "<p><strong>SIMPLECONTENT-ERROR: FATAL ERROR: SimpleContent isn't connect with the database! Please check the connection! (Error-Code: fe01)</strong></p>";
      die();	
      break;
    case '02':
    echo "<p><strong>SIMPLECONTENT-ERROR: FATAL ERROR: SimpleContent can't edit the directory 'simple-content/upload'. Please add a chmod 777. (Error-Code: fe02)</strong></p>";
      die();
    	break;
    case '03':
    echo "<p><strong>SIMPLECONTENT-ERROR: FATAL ERROR: SimpleContent needs JavaScript, to display the Editor. (Error-Code: fe03)</strong></p>";
    	  die();
      break;
    case '04':
    echo "<p><strong>SIMPLECONTENT-ERROR: FATAL ERROR: SimpleContent needs a template like simple start, to display the frontend. If you want to work without a template, set the constant useTmp in the configuration file to false. (Error-Code: fe04)</strong></p>";
      die();
    	break;
    case '05':
    echo "<p><strong>SIMPLECONTENT-ERROR: FATAL ERROR: SimpleContent needs the »Rights-SESSION«. Please log in again.</strong></p>";
    	  die();
      break;
    case '06':
    echo "<p><strong>SIMPLECONTENT-FEHLER: Du bist nicht berechtigt, diese Seite anzuzeigen. In 5 Sekunden wirst du zur Startseite weitergeleitet.</strong></p>";
    sleep(5); 
    header("Location: index.php");
    exit();
    	break;
}
}
?>