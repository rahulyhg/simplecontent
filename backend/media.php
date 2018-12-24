<?php
 include_once "detour.php";
 include_once "../classes/errormngr.php";
 include_once "../sc-config.php";
 if($rights < 2) {
  die("Du bist nicht berechtigt, diese Seite aufzurufen.");
 }
 
 
?>
<!DOCTYPE HTML>
<html style="height: 100%">
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>Übersicht der Medien - simplecontent</title>
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
    <h2>Medien</h2>
    <form action="" method="post" enctype="multipart/form-data">
    <h3>Medien hochladen</h3>
      <input type="file" name="upload" accept="image/text/*"><input type="submit" value="Hochladen" name="upload-smb">
      <p><strong>Tipp: </strong>Wenn du den Dateinamen der Datei erfahren willst, fahre über die Datei und warte kurz.</p>
      <p><small>Wenn du auf Hochladen geklickt hast, und nichts passiert, ist die Datei zu groß.</small></p>
    </form>
   </div>
   
     <?php
      if(!empty($_POST['upload-smb'])) {
        if(move_uploaded_file($_FILES['upload']['tmp_name'], "../simple-content/upload/" . $_FILES['upload']['name'])) {
       
        echo "<p>Die Datei ist hochgeladen!</p>";
        } else {
        echo "<p>Es gab einen Fehler, deshalb konnte die Datei nicht hochgeladen werden!</p>";
        }
      }
      $dir = "../simple-content/upload/";   
      if(!empty($_GET['unlink'])) {
           unlink($dir . $_GET['unlink']);
           echo "<p>Datei $_GET[unlink] gelöscht</p>";
      }
      $handle = opendir($dir);
      echo "<div id='images'>";
      while($file = readdir($handle)) {
        if($file != ".." && $file != ".") {
         $type = mime_content_type($dir . $file);
         if(getImageSize("../simple-content/upload/" . $file)) {
          echo "<div><img title='$file' id='img_thumb' class='lib_thumb' src='../classes/thumbnail_creator.php?file=$dir$file'><br>$file <br> <a href='?unlink=$file'>Löschen</a></div>&nbsp;&nbsp;";
         } elseif($type == "application/pdf") {
          echo "<div><img title='$file' id='img_pdf' class='img_pdf' src='img/pdf.png'><br>$file <br> <a href='?unlink=$file'>Löschen</a></div>";
         } elseif($type == "text/html" OR $type == "text/css") {
          echo "<div><img title='$file' id='img_code' class='img_code' src='img/code.png'><br>$file <br> <a href='?unlink=$file'>Löschen</a></div>";
         }
        }
       } 
       
       
        ?>
        </div>
   </div>
  </body>
</html>
