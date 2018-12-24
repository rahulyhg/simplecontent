<?php
 include_once "detour.php";
 include_once "../classes/errormngr.php";
 include_once "../sc-config.php";
 if(empty($_GET['type'])) {
  
 header("Location: index.php");
  exit();
 }
 if(!preg_match("/^post$|^page$/", $_GET['type'])) {
 header("Location: index.php");
 }
 if($_GET['type'] == "page") {
   $type = "page";
   $type_good = "Seiten";
   $type_all = "Die Seite";      
   $tc = 2;
   if($rights < 3) {
        die("Du bist nicht berechtigt, diese Seite aufzurufen.");
       }
 } else {
   $tc = 1;
   $type = "post";
   $type_good = "Beiträge";
   $type_all = "Der Beitrag";
 }
 $note = "";
 
?>
<!DOCTYPE HTML>
<html style="height: 100%">
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>Übersicht der <?php echo $type_good; ?> - simplecontent</title>
  <link rel="stylesheet" href="css/default.css">
  <link rel="stylesheet" href="css/ui.css">
  </head>
  <body style="height: 100%">
  <div id="wrapper" style="height: 100%">
   <div id="top-bar"><h4>Eingeloggt als <?php echo $usr; ?> - <a href="login.php?logoff=1" title="Ausloggen">Ausloggen</a>?</h4></div>
   <div id="left-menu-bar">
   <?php
    include_once "menu.inc.php";
    if(isset($_GET['delete']))  {
      if($_GET['delete']) {    
   
        if(isset($_GET['item_id']) &&  is_numeric($_GET['item_id'])) { 
          $id = $_GET['item_id'];
          $delete_sql = "DELETE FROM " . TBL_PRF . "posts WHERE post_id = '$id'";
          $delete_sql2 = "DELETE FROM " . TBL_PRF . "posts_meta WHERE post_meta_id= '$id'";
          
          $conn = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_NAME);
          
          if(mysqli_query($conn, $delete_sql) AND mysqli_query($conn, $delete_sql2)) {
            $note = "<p class='notification_y'>$type_all wurde gelöscht.</p>";
          } else {
            $note = "<p class='error'>Es gab einen Fehler: Der Beitrag wurde nicht gelöscht.</p>";
          }
        }
      }
    }
   ?>
   </div>
   <div id="main">
    <h2><?php echo $type_good; ?></h2>
    
    <?php
      echo $note;
      // Get all posts or pages

        $post_sql   = "SELECT * FROM " . TBL_PRF . "posts_meta WHERE post_type='$tc' LIMIT 15";
        include_once "../sc-load.php";
        $query = connectMySQL($post_sql, false); // Look for the operation in the file sc-load.php on line 13
        // MySQL Connection ready, now display posts. 
        ?>
       
        
        <?php
        $nothing = false;
        if(mysqli_num_rows($query) == 0) {
          echo "<strong>Keine $type_good in der Datenbank gefunden... <a href=\"edit.php?type=$type\" title=\"Erstelle eine(n)!\">Erstelle eine(n)!</a></strong>";
          $nothing = true;
        }
        if(!$nothing) {
        ?> <table id="main-taible-overview">
        <tr><th>Titel</th><th>Veröffentlichungsdatum</th><th>Aktionen</th></tr>
        <?php
        while($post_list_item = mysqli_fetch_assoc($query)) {
          echo "<tr><td>$post_list_item[post_meta_title]</td><td>$post_list_item[post_publish_date]</td><td><a href='?type=$type&delete=true&item_id=$post_list_item[post_meta_id]'>Löschen</a> | <a href='edit.php?type=$type&id=$post_list_item[post_meta_id]'>Bearbeiten</a></td></tr>\n";
        }
        }
    ?>
    </table>
   </div>
   </div>
  </body>
</html>
