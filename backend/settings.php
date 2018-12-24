<?php
 include_once "detour.php";
 include_once "../classes/errormngr.php";
 include_once "../sc-config.php";
  require_once "../sc-load.php";
  if($rights < 4) {
    die("You can't display the page.");
  }
?>
<!DOCTYPE HTML>
<html style="height: 100%">
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>Settings - simplecontent</title>
  <link rel="stylesheet" href="css/default.css">
  <link rel="stylesheet" href="css/ui.css">
  </head>
  <body style="height: 100%">
  <div id="wrapper" style="height: 100%">
   <div id="top-bar"><h4>Logged in as <?php echo $usr; ?> - <a href="login.php?logoff=1" title="Logg out">Logg out</a>?</h4></div>
   <div id="left-menu-bar">
    <?php
     include_once "menu.inc.php";
    ?>
   </div>
   <div id="main">
   <div id="setting-area">
   <form action="" method="POST">
   <h2>Einstellungen</h2>
   <?php
   
   
   if(!empty($_POST['update'])) {
    if(isset($_POST['sitename'])) {
       updateSetting("sitename",$_POST['sitename']);
    }
    if(isset($_POST['subsitename'])) {
       updateSetting("subsitename",$_POST['subsitename']);
    }
    if(isset($_POST['where-posts'])) {
       updateSetting("display_posts",$_POST['where-posts']);
    }
    if(isset($_POST['check_comments_before'])) {
       updateSetting("check_comments_before",$_POST['check_comments_before']);
    } else {
       updateSetting("check_comments_before","0");
    }
    if(isset($_POST['leave_comments'])) {
       updateSetting("leave_comments",$_POST['leave_comments']);
    }
    if(isset($_POST['use_fas'])) {
       updateSetting("disable_fa",$_POST['use_fas']);
    }
    
    if(!empty($_POST['headerIMG'])) {
       updateSetting("header_img",$_POST['headerIMG']);
    }
    if(!empty($_POST['template'])) {
       updateSetting("actual_template",$_POST['template']);
    }
    
    echo "<p>Einstellungen aktualisiert!</p>";
    
    
   }
   ?>
  <p> <a href="#general"> General settings - <a href="#comments">Comment-Settings</a> - <a href="#posts">Post- and Page-Settings</a>  - <a href="#design">Design-Settings</a> - <a href="info.php">Information about simplecontent</a></p>
   <div id="general">
   Title: <input type="text" name="sitename" value="<?php echo getSetting('sitename'); ?>" name="sitename">     <br>   
   Subtitle: <input type="text" name="subsitename" value="<?php echo getSetting('subsitename'); ?>">  <br>
   </div>
   <div id="posts">
   <h3>Posts & Pages</h3>
   Page of posts (there are the posts): <select name="where-posts">
   <?php
   
    $query = connectMySQL("SELECT * FROM " . TBL_PRF . "posts_meta WHERE post_type='2'",false,false);
  
    while($page_item = mysqli_fetch_assoc($query)) {
    if(getSetting("where_show_posts") == $page_item['post_meta_id']) {
      echo "<option value='$page_item[post_meta_id]' selected>$page_item[post_meta_title]</option>";
    } else {
      echo "<option value='$page_item[post_meta_id]'>$page_item[post_meta_title]</option>";
    }
    }
   ?>
   </select>
   </div>
   <div id="#comments">
   <h3>Comments</h3>
   <?php
    if(getSetting("check_comments_before")) {
     echo "<input type='checkbox' value='1' name='check_comments_before' id='3' checked> <label for='3'>Check comments before publishing</label>";
    } else {
      echo "<input type='checkbox' name='check_comments_before' value='1' id='4'> <label for='4'>Check comments before publishing</label>";
    }
   ?>
   <br>
   <?php
    if(getSetting("leave_comments")) {
     echo "<input type='checkbox' name='leave_comments' checked id='5'> <label for='5'>Allow comments</label>";
    } else {
      echo "<input type='checkbox' name='leave_comments' id='5'> <label for='5'>Allow comments</label>";
    }
   ?>
   </div>
   <div id="design">
    <h3>Design</h3>
    <?php
     if(getSetting("template_need_fas")) {
      echo "<p>Your template use <strong>Font Awesome</strong>, that's why you can't <em>turn off</em>.</p>";
     } else {
     ?>
     <input type="checkbox" name="use_fas" id="use_fas" value='1' <?php if(!getSetting("disable_fa")){ echo "checked"; }?>><label for="use_fas">FontAwesome</label> 
     
     <?php
     }
    ?>  
    Header-Image (Not all templates support this, look at the <a href="media.php" style="text-decoration: underline">Media-Lib</a> for pictures): <input name="headerIMG" type="text" value="<?php echo getSetting("header_img"); ?>">
    <p>You use now the template <strong><?php echo getSetting("actual_template"); ?></strong>.</p>
    Template (You have to download it): <input type="text" name="template" value="<?php echo getSetting('actual_template'); ?>"><br>
   </div>
    <?php
    
    ?>
   </div>
   <input type="submit" name="update" value="Update settings">
   
   </form>
   </div>
  </body>
</html>
