<?php
 include_once "detour.php";
 include_once "../classes/errormngr.php";
 include_once "../sc-config.php";
 
 if($rights < 4) {
  die("You can't display the page.");
 }
 
?>
<!DOCTYPE HTML>
<html style="height: 100%">
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>User - simplecontent</title>
  <link rel="stylesheet" href="css/default.css">
  <link rel="stylesheet" href="css/ui.css">
  </head>
  <body style="height: 100%">
  <div id="wrapper" style="height: 100%">
   <div id="top-bar"><h4>Logged in as <?php echo $usr; ?> - <a href="login.php?logoff=1" title="Log out">Log out</a>?</h4></div>
   <div id="left-menu-bar">
   <?php
    include_once "menu.inc.php";
    if(isset($_GET['delete']))  {
      if($_GET['delete']) {    
   
        if(isset($_GET['usr_id']) &&  is_numeric($_GET['usr_id'])) { 
          $id = $_GET['usr_id'];
          $delete_sql = "DELETE FROM " . TBL_PRF . "user WHERE user_ID = '$id'";
          
          $conn = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_NAME);
          
          if(mysqli_query($conn, $delete_sql)) {
            $note = "<p class='notification_y'>We've deleted the user.</p>";
          } else {
            $note = "<p class='error'>Error: We had not deleted the user.</p>";
          }
        }
      }
    }
   ?>
   </div>
   <div id="main">
    <h2>Benutzer</h2>
    <p><a href="user.php?new=true">Add user</a></p>
    
    <?php
    if(!empty($note)) {
      echo $note;
    }

        $post_sql   = "SELECT * FROM " . TBL_PRF . "user ";
        include_once "../sc-load.php";
        $query = connectMySQL($post_sql, false,false); 
        ?>
       
        
        <?php
      
      
        ?> <table id="main-taible-overview">
        <tr><th>Name</th><th>E-Mail-Adress</th><th>Rights</th><th>Actions</th></tr>
        <?php
        while($user_list_item = mysqli_fetch_assoc($query)) {
          echo "<tr><td>$user_list_item[user_name]</td><td>$user_list_item[user_email]</td><td>$user_list_item[user_rights]</td><td><a href='?delete=true&usr_id=$user_list_item[user_ID]'>Delete</a> | <a href='user.php?id=$user_list_item[user_ID]'>Edit</a></td></tr>\n";
        }
    ?>
    </table>
   </div>
   </div>
  </body>
</html>
