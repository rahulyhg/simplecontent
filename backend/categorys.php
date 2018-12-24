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
  <title>Categorys - simplecontent</title>
  <link rel="stylesheet" href="css/default.css">
  <link rel="stylesheet" href="css/ui.css">
  </head>
  <body style="height: 100%">
  <div id="wrapper" style="height: 100%">
   <div id="top-bar"><h4>Logged in as <?php echo $usr; ?> - <a href="login.php?logoff=1" title="Log out">Logg out</a>?</h4></div>
   <div id="left-menu-bar">
    <?php
     include_once "menu.inc.php";
    ?>
   </div>
   <div id="main">
   <h2>Kategorien</h2> 
   <p><a href='category-new.php'>New category</a></p>
    <?php
      // Get all categorys

        // Delete category if exists $_GET['delete'] AND $_GET['id']
        if(!empty($_GET['delete']) && !empty($_GET['id'])
        && is_numeric($_GET['id'])) {
          $query = connectMySQL("DELETE FROM " . TBL_PRF . "categorys WHERE category_ID = '$_GET[id]'", false, false);
          if($query) {
            echo "<p>The category (ID #$_GET[id]) was <strong>successfully deleted</strong>!</p>";
          }
        } 
        
        $post_sql   = "SELECT * FROM " . TBL_PRF . "categorys";
        $query = connectMySQL($post_sql, false, false); 
        // MySQL Connection ready, now display categorys. 
        
        ?>
        <table id="main-taible-overview">
        <tr><th>Name</th><th>Actions</th></tr>
        <?php
        while($l_item = mysqli_fetch_assoc($query)) {
          echo "<tr><td>$l_item[category_name]</td><td><a href='?delete=true&id=$l_item[category_ID]'><Delete</a> | <a href='category-edit.php?id=$l_item[category_ID]'>Edit</a></td></tr>\n";
        }
        
    ?>
    </table>
   </div>
  </body>
</html>
