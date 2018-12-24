<?php
 include_once "detour.php";
 include_once "../classes/errormngr.php";
 include_once "../sc-config.php";
 if($rights < 4) {
  die("You can't display the page.");
 }
 include_once "../sc-load.php";
    if(isset($_GET['id']) AND is_numeric($_GET['id']) OR !empty($_GET['new']))
    {
      if(!empty($_GET['new'])) {
        $new = true;
      } else {
        $new = false;
      }
    } else {
      header("Location: user-overview.php");
    }                      
    
    $note = "";
    $errors = "";
    $conn = mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PASS,MYSQL_NAME);
    
    if(!empty($_POST['go'])) {
      
      if(!empty($_POST['username'])) {
         $username = mysqli_real_escape_string($conn,$_POST['username']);
      } else {
         $errors .= "<p>Please enter an username!</p>";
      }
      
      if(!empty($_POST['email']) AND validateMail($_POST['email'])) {
         $email = mysqli_real_escape_string($conn,$_POST['email']);
      } else {
         $errors .= "<p>Please enter a (valid) E-Mail-Adress!</p>";
      }
      if(!empty($_POST['pw']) AND strlen($_POST['pw']) >= 8 AND !$new) {
         $pw = ", user_pw='" . sha1($_POST['pw']) . "'";
      } elseif(empty($_POST['pw']) AND $new) {
         $errors .= "<p>Please enter a (good) password!</p>";
      }     
      
      if(!empty($_POST['rights']) AND is_numeric($_POST['rights'])) {
         $rights_q = ", user_rights='" . mysqli_real_escape_string($conn,$_POST['rights']) . "'";
         if($new) {
          $rights_clear = $_POST['rights'];
         }
      } else {
        if(!$new AND $usr_ID != $_GET['id']) {
         $errors .= "<p>Please select a right!</p>";
        } else {
         $rights_q = "";
        }
      }
      
      if(empty($pw) AND !$new) {
         $pw = "";
      } 
      
      
      if(!$new AND empty($errors)) {
        $sql = "UPDATE " . TBL_PRF . "user SET user_name = '$username', user_email='$email' $pw $rights_q WHERE user_ID ='$_GET[id]'";
      } elseif($new AND empty($errors)) {
        $pw_clear = sha1($_POST['pw']);
        $sql = "INSERT INTO " . TBL_PRF . "user VALUES('', '$username', '$pw_clear', '$email', '', '$rights_clear')";
      }
      
      if($new)  {
        $type = "created";
      } else {
        $type = "updated";
      }
      if(mysqli_query($conn,$sql) AND empty($errors)) {
        $note = "<p>The user was $type!</p>";
      }else{
        $note = "<p>Error: We hadn't created/edited the user.</p>";
      }
      
      
      
      
      
      
    }
 
?>
<!DOCTYPE HTML>
<html style="height: 100%">
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title><?php if($new) { echo "Create"; } else { echo "Edit"; } ?> user - simplecontent</title>
  <link rel="stylesheet" href="css/default.css">
  <link rel="stylesheet" href="css/ui.css">
  </head>
  <body style="height: 100%">
  <div id="wrapper" style="height: 100%">
   <div id="top-bar"><h4>Logged in as <?php echo $usr; ?> - <a href="login.php?logoff=1" title="Ausloggen">Logg out</a>?</h4></div>
   <div id="left-menu-bar">
   <?php
    include_once "menu.inc.php";
   ?>
   </div>
   <div id="main">
   <form action="" method="post">
   <h2> <?php if($new) { echo "Create"; } else { echo "Edit"; } ?> user</h2>
   
   <?php
   echo $note;
   echo $errors;
    if(!$new) {
     $query = connectMySQL("SELECT * FROM " . TBL_PRF . "user WHERE user_ID='$_GET[id]'"); 
     $user_data = mysqli_fetch_assoc($query); 
    }
   ?>
   Username: <input type="text" name="username" id="username" <?php if(!$new) { echo "value=\"" . $user_data['user_name'] . "\""; }?>>  <br>
   E-Mail: <input type="email" name="email" id="email" <?php if(!$new) { echo "value=\"" . $user_data['user_email'] . "\""; }?>>    <br>
   Password: <input type="password" name="pw" id="pw"> <?php if(!$new) { echo "Let this filed empty, if you willn't change the password."; }?>           <br>
   <?php
   if(!$new AND $usr_ID != $user_data['user_ID'] ) {
   $self=false;
   ?>
   Rechte: <select name="rights">
   <option value="1" <?php if(!$new){ if($user_data['user_rights'] == 1) { echo "selected"; }} ?>>Follower</option>
   <option value="2" <?php if(!$new){ if($user_data['user_rights'] == 2) { echo "selected"; }} ?>>Author</option>
   <option value="3" <?php if(!$new){ if($user_data['user_rights'] == 3) { echo "selected"; }} ?>>Manager</option>     
   <option value="4" <?php if(!$new){ if($user_data['user_rights'] == 4) { echo "selected"; }} ?>>Administrator</option>
   </select>
   <?php
    } else {
     $self=true;
    }
   ?>
   <p><input type="submit" name="go" value="<?php if($new) { echo "Create"; } else { echo "Update"; } ?>"></p>
   </form>
   </div>
   </div>
  </body>
</html>
