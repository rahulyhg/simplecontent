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
  <title>Edit Category - simplecontent</title>
  <link rel="stylesheet" href="css/default.css">
  <link rel="stylesheet" href="css/ui.css">
  </head>
  <body style="height: 100%">
  <div id="wrapper" style="height: 100%">
   <div id="top-bar"><h4>You´re logged in as <?php echo $usr; ?> - <a href="login.php?logoff=1" title="Log out">Log out</a>?</h4></div>
   <div id="left-menu-bar">
    <?php
     include_once "menu.inc.php";
    ?>
   </div>
   <div id="main">
    <h2>Edit category</h2>
    <?php
     if(!empty($_GET['id']) && is_numeric($_GET['id'])) {
     $query = connectMySQL("SELECT * FROM " . TBL_PRF . "categorys WHERE category_ID='$_GET[id]'",false,false);
     $cat   = mysqli_fetch_assoc($query);
      ?>
      <form action="#" method="POST">
       Name: <input type="text" name="name" value="<?php
       echo $cat['category_name'];
       ?>">
      <br>    <br>
      <input type="submit" name="go" value="Update category" class="publish-standard">
      </form>
      <?php
      if(!empty($_POST['go'])) {
        if(!empty($_POST['name'])) {
          $conn = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_NAME);
          $name = mysqli_real_escape_string($conn, $_POST['name']);
          $sql  = "UPDATE " . TBL_PRF . "categorys SET category_name = '$name' WHERE category_id='$cat[category_ID]'";
          $query= connectMySQL($sql, false, false);                                                                                            
          if($query) {
            echo "<p>The catgeory has <strong>successfully updated</strong>!</p>";
          } else {
            echo "<p><strong>Error</strong>: We can't update the category. Maybe you have already added a category with this name?</p>";
          }
        } else {
          echo "<p><strong>Error</strong>: Please enter a name!</p>";
        }
      }
     } else {
      echo "<p><strong>Hacking-Attac</strong>: We've cancel the action!</p>";
     }
    ?>
   
   </div>
  </body>
</html>
