<?php
 include_once "detour.php";
 include_once "../classes/errormngr.php";
 include_once "../sc-config.php";
 include_once "../sc-load.php";
 
 if($rights < 3) {
  successfully
 }
 
?>
<!DOCTYPE HTML>
<html style="height: 100%">
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>Comments - simplecontent</title>
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
   
        if(isset($_GET['comment_id']) &&  is_numeric($_GET['comment_id'])) { 
          $id = $_GET['comment_id'];
          $delete_sql = "DELETE FROM " . TBL_PRF . "comments WHERE comment_ID = '$id'";
          
          $conn = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_NAME);
          
          if(mysqli_query($conn, $delete_sql)) {
            $note = "<p class='notification_y'>The comment is now deleted.</p>";
          } else {
            $note = "<p class='error'>Error: We can't delete this comment.</p>";
          }
        }
      }
    }
   ?>
   </div>
   <div id="main">  
    <?php
        if(isset($_GET['id']) AND isset($_GET['comment_ok']) == true AND is_numeric($_GET['id']))   {
          $id = $_GET['id'];
          $query = connectMySQL("UPDATE " . TBL_PRF . "comments SET comment_status='1' WHERE comment_ID='$id'");
          if($query) {
            $note = "<p>The comment is now public!</p>";
          } else {
            $note = "<p>Error: You can't set the comment public.</p>";
          }
        }
      
        ?> 
    <h2>Kommentare</h2>
    
    <?php
    if(!empty($note)) {
      echo $note;
    }

        $c_sql   = "SELECT * FROM " . TBL_PRF . "comments ";
        include_once "../sc-load.php";
        $query = connectMySQL($c_sql, false,false); 
        ?>
       
        
      <table id="main-taible-overview">
        <tr><th>Author</th><th>Text</th><th>Date</th><th>Actions</th></tr>
        <?php
        while($c_list_item = mysqli_fetch_assoc($query)) {
        if(getSetting("check_comments_before") AND $c_list_item['comment_status'] == 0) {
        $attr = "| <a href='?id=$c_list_item[comment_ID]&comment_ok=true'>Publish for all</a>";
        } else {
        $attr = "";
        }
        
          echo "<tr><td>$c_list_item[comment_author]</td><td>$c_list_item[comment_content]</td><td>$c_list_item[comment_date]</td><td><a href='?delete=true&comment_id=$c_list_item[comment_ID]'>Delete</a> $attr</td></tr>\n";
        }
    ?>
    </table>
   </div>
   </div>
  </body>
</html>
