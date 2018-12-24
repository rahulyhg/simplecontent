<?php
 session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta name="generator" content="PSPad editor, www.pspad.com">
  <title>Installation - simplecontent</title>
  </head>
  <body>
  <style>
     @import url('https://fonts.googleapis.com/css?family=Open+Sans');
     * { font-family: Open Sans, sans-serif; }
     body { background: whitesmoke; }
     
     #wrapper { width: 60%; padding: 1%; background: white; margin: 0 auto; }
     #button { padding: 3px; background: rgb(230,230,230); border: 0px solid white; color: gray; text-decoration: none; }
     #smb-btn { border: 0px solid white; padding: 1%; background: #E6E6E6; cursor: pointer; }
     input { margin-top: 6px; }
  </style>
  <div id="wrapper">
  <?php
   if(empty($_GET['step'])) {
  ?>
   <h2>Hello!</h2>
   <p>Hello! First: Thank you for using simplecontent. THANKS! Let's start the installation!</p>
   
   <a href="?step=1" id="button">Start Setup</a>
   <?php
    }
    if(!empty($_GET['step']) AND is_numeric($_GET['step'])) {
    if($_GET['step'] == 1) {
   ?>
   
   <h2>Step 1</h2>
   <p>Look for your MySQL Data from your Hoster!</i></p>
   
   <form action="" method="post">
   
   MySQL-Host: <input type="text" name="mysql_host" value="localhost"> <small>Meist heißt dieser <code>localhost</code></small><br>
   MySQL-User: <input type="text" name="mysql_user" <?php if(!empty($_POST['mysql_user'])) { echo "value='$_POST[mysql_user]'"; } ?>> <small>At XAMPP it's <code>root</code>.</small><br>
   MySQL-Password: <input type="password" name="mysql_pass" <?php if(!empty($_POST['mysql_pass'])) { echo "value='$_POST[mysql_pass]'"; } ?>> <small>At XAMPP you have a empty password.</small><br>
   MySQL-DB-Name: <input type="text" name="mysql_name" <?php if(!empty($_POST['mysql_name'])) { echo "value='$_POST[mysql_name]'"; } ?>> <small>Look at your hosting.</small><br>
   MySQL-Table-Prefix: <input type="text" name="mysql_pref" <?php if(!empty($_POST['mysql_pref'])) { echo "value='$_POST[mysql_pref]'"; } else { $any= rand(0,99); echo "value='{$any}_'"; } ?>> <small>Please note: At the ending it must have a _</small><br>
   <br>
   <input type="submit" value="Go to step 2" id="smb-btn" name="go_ins_1">
   </form>
   <?php
    if(!empty($_POST['go_ins_1'])) {
    $errors = "";
      if(empty($_POST['mysql_host'])) {
        $errors .= "<p><strong>Please enter your MySQL-Host!</strong></p>";  
      }
      if(empty($_POST['mysql_user'])) {
        $errors .= "<p><strong>Please enter your MySQL-Username!</strong></p>";
      }
      if(empty($_POST['mysql_pass'])) {
        $pw = "";
      } else {
        $pw = $_POST['mysql_pass'];
      }
      if(empty($_POST['mysql_name'])) {
        $errors .= "<p><strong>Please enter your MySQL-DB-Name!</strong></p>";
      }
      if(empty($_POST['mysql_pref']) OR !preg_match("/[a-zA-Z0-9_][_]/",$_POST['mysql_pref'])) {
        $errors .= "<p><strong>Please enter a (valid) Prefix!</strong></p>";
      }
      
      if(!empty($errors)) {
        echo $errors;
      } else {          
        $conn = mysqli_connect($host,$user,$pass,$name);
        $host = mysqli_real_escape_string($conn, $_POST['mysql_host']);
        $user = mysqli_real_escape_string($conn, $_POST['mysql_user']);
        $pass = mysqli_real_escape_string($conn, $_POST['mysql_pass']);
        $name = mysqli_real_escape_string($conn, $_POST['mysql_name']);
        $pref = mysqli_real_escape_string($conn, $_POST['mysql_pref']);
        
        
        
        if (mysqli_connect_errno()) {
          echo "<p>We can't talk with mysql. Please try again later.</p>";
          exit();
        } else {
          $sc = rand(999,9999); 
          $sc = sha1(md5($sc));
          $sc = $sc . sha1($sc) . md5($sc) . sha1($sc) . time() . rand(9999,99999);
         
          $content = file_get_contents("../sc-config.php",FILE_USE_INCLUDE_PATH);
          $content = str_replace("MYSQL_HOST_HERE", $host, $content);
          $content = str_replace("MYSQL_USER_HERE", $user, $content);
          $content = str_replace("MYSQL_PASS_HERE", $pass, $content);
          $content = str_replace("MYSQL_NAME_HERE", $name, $content);
          $content = str_replace("no_____", "yes___", $content);
          $content = str_replace("HERE_SECURE_CODE", $sc, $content);
          $content = str_replace("TABLE_PREFIX_HERE", $pref,$content);
          $fp = fopen("../sc-config.php", "w");
          fwrite($fp, $content);
          fclose($fp);
          
          
          header("Location: install.php?step=2");
        }
      }
    }
    }
    if($_GET['step'] == 2) {
   ?>
   <h2>Step 2</h2>
 
   <form action="" method="post" >
    Title: <input type="text" name="title" <?php if(!empty($_POST['title'])) { echo " value='$_POST[title]' "; } ?>>
    <br>
    Subtitle: <input type="text" name="subtitle" <?php if(!empty($_POST['subtitle'])) { echo " value='$_POST[subtitle]' "; } ?>>
    <br>
    E-Mail-Adress: <input type="email" name="mail" <?php if(!empty($_POST['mail'])) { echo " value='$_POST[mail]' "; } ?>>
    <br>
    Admin-Username: <input type="text" name="admin_username" <?php if(!empty($_POST['admin_username'])) { echo " value='$_POST[admin_username]' "; } ?>>
    <br>
    Admin-Password: <input type="password" name="admin_pw" <?php if(!empty($_POST['pw'])) { echo " value='$_POST[admin_pw]' "; } ?>> <small>Achte auf Sicherheit!</small>
    <br><br>
    <h3>Must-Haves for passwords</h3>
    <p id="pw-notes"><ul>
    <li>at least 8 cases</li>
    <li>at least 1 upper- und at least 1 lowercase</li>
    <li>at least 1 number</li>
    <li>at least 1 special character (@,="$%\)</li>
    </ul></p>
    <p>
    <input type="submit" value="Next" name="go_2" id="smb-btn">
    </p>
    
    <?php
     $errors = "";
     if(!empty($_POST['go_2'])) {
      if(empty($_POST['title'])) {
        $errors .= "<p>Please enter a title!</p>";
      }
      if(empty($_POST['subtitle'])) {
        $_POST['subtitle'] = "A simplecontent-Blog";
      }
      if(empty($_POST['admin_username'])) {
        $errors .= "<p>Please enter a username!</p>";
      }
      require_once "../sc-load.php";
      
      if(empty($_POST['mail']) OR !validateMail($_POST['mail']))  { 
        $errors .= "<p>Please enter a (valid) email.</p>";
      }
      
      // Minimum eight characters, at least one uppercase letter, one lowercase letter and one number (only a tip)
      
      if(empty($_POST['admin_pw']) || strlen($_POST['admin_pw']) < 8 || strlen($_POST['admin_pw']) > 20) {
        $errors .= "<p>Please enter a (good :-)) password!</p>";
      } 
      
      
      if(empty($errors)) {
        include_once("../sc-load.php");
    

        
        require_once("../sc-config.php");
        $conn = mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PASS,MYSQL_NAME);
        // Variables:
        $subsitename = mysqli_real_escape_string($conn,$_POST['subtitle']);
        $user = mysqli_real_escape_string($conn,$_POST['admin_username']);
        $pw   = sha1($_POST['admin_pw']);
        $mail = mysqli_real_escape_string($conn,$_POST['mail']);
        $date = date("d.m.y"); 
        $domain = getDomain();
        $pref = TBL_PRF;
        $sitename  = mysqli_real_escape_string($conn,$_POST['title']); 
$sql = "
CREATE TABLE {$pref}categorys (
  category_ID int(11) NOT NULL,
  category_name varchar(60) COLLATE utf8_croatian_ci NOT NULL,
  category_owner_id int(11) NOT NULL,
  category_standard tinyint(1) DEFAULT NULL
)
-------


INSERT INTO {$pref}categorys  VALUES ('1', 'Allgemein', '1', '1');

-------


CREATE TABLE {$pref}comments (
  comment_ID int(11) NOT NULL,
  comment_author varchar(50) COLLATE utf8_croatian_ci DEFAULT NULL,
  comment_author_mail varchar(60) COLLATE utf8_croatian_ci DEFAULT NULL,
  comment_status varchar(4) COLLATE utf8_croatian_ci DEFAULT NULL,
  comment_post_id int(11) NOT NULL,
  comment_date varchar(8) COLLATE utf8_croatian_ci NOT NULL,
  comment_content text COLLATE utf8_croatian_ci NOT NULL
) 
-------

INSERT INTO {$pref}comments (comment_ID, comment_author, comment_author_mail, comment_status, comment_post_id, comment_date, comment_content) VALUES
('1', 'Ein Kommentator', 'test@example.com', '1', '1', '$date', 'Dies ist ein Test-Kommentar: Im Backend kannst du ihn löschen.');
-------



CREATE TABLE {$pref}posts (
  post_id int(11) NOT NULL,
  post_author_id int(11) NOT NULL,
  post_text text COLLATE utf8_croatian_ci NOT NULL
) 

-------


INSERT INTO {$pref}posts (post_id, post_author_id, post_text) VALUES
('1', '0', '<p>Hallo Welt! simplecontent wurde gro&szlig;artig installiert, und l&auml;uft fehlerfrei. Dieser Beitrag ist nur zu Testzwecken: Also kannst du ihn l&ouml;schen oder gleich im <a href=\'backend'\>Backend</a> bearbeiten, und ihn f&uuml;r deine Leser verf&uuml;gbar machen.<!-- READMORE -->Momentan wird der Beitrag <strong>nicht von Suchmaschinen indexiert</strong>, das hei&szlig;t, er wird sehr warscheinlich wenige Aufrufe haben. Wenn du ihn im Backend bearbeitest, kannst du unter SEO das H&auml;ckchen neben <strong>nofollow </strong>entfernen, dann wird er bald indexiert.</p>
<h2>Auf Google und co gefunden werden</h2>
<p>Wenn du gerne eine hohe Aufmerksamkeit auf Google und anderen Suchmaschinen erlangen willst, solltest du dich bei der <a title='Die Google Search Console' href=\'https://www.google.com/webmasters\' target=\'_blank\'>Google Search Console</a> registrieren, dann wird deine Seite schneller bei Google gefunden. Noch ein Tipp: Setze nur ein nofollow-Link bei Beitr&auml;gen, die du einem nicht so gro&szlig;en Publikum zeigen willst: Diese Beitr&auml;ge werden, wie gesagt, nicht von Google indexiert.</p>'),
('2', '0', '');
-------

CREATE TABLE {$pref}posts_meta (
  post_meta_id int(11) NOT NULL,
  post_permalink varchar(70) COLLATE utf8_croatian_ci DEFAULT NULL,
  post_publish_date varchar(13),
  post_category_id tinyint(3) UNSIGNED DEFAULT NULL,
  post_keywords text COLLATE utf8_croatian_ci,
  post_nofollow tinyint(1) DEFAULT NULL,
  post_meta_description text COLLATE utf8_croatian_ci,
  post_meta_title varchar(50) COLLATE utf8_croatian_ci DEFAULT NULL,
  post_modified timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  post_can_comment tinyint(1) DEFAULT NULL,
  post_pw varchar(50) COLLATE utf8_croatian_ci DEFAULT NULL,
  post_type tinyint(1) UNSIGNED DEFAULT NULL COMMENT '1=post 2=page',
  post_visits int(11) DEFAULT NULL,
  post_image varchar(55) COLLATE utf8_croatian_ci DEFAULT NULL,
  post_image_alt varchar(60) COLLATE utf8_croatian_ci DEFAULT NULL,
  is_publish tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-------
INSERT INTO {$pref}posts_meta (post_meta_id, post_permalink, post_publish_date, post_category_id, post_keywords, post_nofollow, post_meta_description, post_meta_title, post_modified, post_can_comment, post_pw, post_type, post_visits, post_image, post_image_alt, is_publish) VALUES
('1', 'hallo-welt', '19.12.2018', '1', '','2', '', 'Hallo Welt!', '0000-00-00 00:00:00', '1', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '1', '0', 'preview.jpg', NULL, '1'),
(2, 'home', '19.12.2018', '1', '', '0', '', 'Home', '0000-00-00 00:00:00', '1', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '2', '0', '', NULL, '1');
 -------

CREATE TABLE {$pref}settings (
  setting_name varchar(70) COLLATE utf8_croatian_ci NOT NULL,
  setting_value text COLLATE utf8_croatian_ci NOT NULL,
  setting_active tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;
-------

INSERT INTO {$pref}settings (setting_name, setting_value, setting_active) VALUES
('actual_template', 'Blog', 1),
('check_comments_before', '0', 1),
('disable_fa', '0', 1),
('display_posts', '2', 1),
('homepage', '$domain', 1),
('leave_comments', 'on', 1),
('simplecontent_ver', '0.0.1', 1),
('sitename', '$sitename', 1),
('siteurl', '$domain', 1),
('subsitename', '$subsitename', 1),
('template_need_fas', '1', 1),
('use_fontawesome', '1', 1),
('header_img', 'header-background.png', 1),
('where_show_posts', '2', 1);

-------
CREATE TABLE {$pref}user (
  user_ID int(11) NOT NULL,
  user_name varchar(15) COLLATE utf8_croatian_ci DEFAULT NULL,
  user_pw varchar(50) COLLATE utf8_croatian_ci DEFAULT NULL,
  user_email varchar(50) COLLATE utf8_croatian_ci DEFAULT NULL,
  user_timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  user_rights tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-------
INSERT INTO {$pref}user (user_ID, user_name, user_pw, user_email, user_timestamp, user_rights) VALUES
('0', '$user', '$pw', '$mail', '','4');


-------
ALTER TABLE {$pref}categorys
  ADD PRIMARY KEY (category_ID);
-------

ALTER TABLE {$pref}comments
  ADD PRIMARY KEY (comment_ID);
 -------

ALTER TABLE {$pref}posts
  ADD PRIMARY KEY (post_id);
-------

ALTER TABLE {$pref}posts_meta
  ADD UNIQUE KEY post_meta_id (post_meta_id),
  ADD UNIQUE KEY post_meta_id_2 (post_meta_id);
-------
ALTER TABLE {$pref}settings
  ADD UNIQUE KEY setting_name (setting_name);
 -------

ALTER TABLE {$pref}user
  ADD PRIMARY KEY (user_ID),
  ADD UNIQUE KEY user_pw (user_pw);
     -------



ALTER TABLE {$pref}categorys
  MODIFY category_ID int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

  -------
ALTER TABLE {$pref}comments
  MODIFY comment_ID int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-------
ALTER TABLE {$pref}posts
  MODIFY post_id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
     -------
ALTER TABLE {$pref}posts_meta
  MODIFY post_meta_id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
                      -------
";

$all = explode("-------", $sql);

foreach($all as $sql_part) {
  if(!empty($sql_part)) {
  if(!mysqli_query($conn,$sql_part)) {
    die("Die Datenbanktabellen konnten nicht auf dem MySQL-Server auf deinem Host installiert werden. MySQL meldet: " . mysqli_error($conn) . ".");
  } 
  }
}


       $_SESSION['user'] = $user;
       $_SESSION['mail'] = $mail;
      
       header("Location: install.php?step=3");
       exit(); 
     }
    ?>
   </form>
   <?php
    }
    }
    if($_GET['step'] == 3) {
    require_once("../sc-load.php");
      ?>
      
      <h2>Yeah!</h2>
      <p>Yeah! simplecontent installed! Now you can look at your site at<?php
       echo getDomain();
      ?> or at <?php echo getDomain() . 'backend'; ?> manage. Happy blogging! 
      <p>
      Username: <?php echo $_SESSION['user']; ?><br>
      Password: <i>You know...</i>   <br>
      E-Mail-Adress: <?php echo $_SESSION['mail']; ?>
      </p>
     
      <?php
    }
    
    }
   ?>
  </div>
  </body>
</html>
