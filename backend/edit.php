<?php
   $errors = "";
   include_once "detour.php";
   if($rights < 2) {
    die("You can't display this page.");
   }
   include_once "../sc-load.php";
   include_once "../sc-config.php";
   
   if(empty($_GET['type'])) {
       header("Location: index.php");
       exit();
   }
   $conn = connectMySQL('',false,true);
   if(!preg_match("/^post$|^page$/", $_GET['type'])) {
       header("Location: index.php");
   }
   $type = $_GET['type'];
   if($type == "page") {
       $type_good = "Page";
       $type_good_all = "The page";
       $type_good_pl = "Pages";
       $type_code = 2; // 1=Post 2=Page
       if($rights < 3) {
        die("You can't display this page.");
       }
   } else {
       $type_good = "Post";
       $type_good_all = "The post";
       $type_good_pl = "Posts";
       $type_code = 1;
   }
   $edit_mode = false;
   if(isset($_GET['id']) AND is_numeric($_GET['id'])) {
      $pid = $_GET['id'];
      $edit_mode = true;
   }
   
  
   
   
   if(isset($_POST['publish-standard']) || isset($_POST['publish-private'])) {
    $publish_private = (isset($_POST['publish-private'])) ? 2 : 1; 
   
   
     
     if(empty($_POST['post_title'])) {
     $errors .= "<p class='error_note'><strong>Please enter a title!</strong></p><br>\n";
     }  else {
     $post_title = mysqli_real_escape_string($conn, $_POST['post_title']);
     }
     if(empty($_POST['url_add'])) {
     $errors .= "<p class='error_note'><strong>Please choose a permalink!</strong></p><br>\n";
     }  else {
     $post_url_adding = mysqli_real_escape_string($conn, $_POST['url_add']);
     }
     if(empty($errors)) {
      
     if(isset($_POST['post-content'])) {
     $post_content = mysqli_real_escape_string($conn,$_POST['post-content']);
     } else {
     $post_content = "";
     }
     if(isset($_POS['keywords'])) {
     $post_keywords = mysqli_real_escape_string($conn,$_POST['keywords']);
     } else {
      $post_keywords = "";
     }
     if(isset($_POST['post-meta-desc'])) {
     $post_meta_desc = mysqli_real_escape_string($conn, $_POST['post-meta-desc']);
     }  else {
      $post_meta_desc = "";
      }
     if(isset($_POST['seo-nofollow']))   {
     $post_nofollow = ($_POST['seo-nofollow'] == "on") ? 1 : 0;
     } else {
     $post_nofollow = 0;
     }
     $post_category = $_POST['category'];                                    
     if(isset($_POST['allow-comments'])) {
     $post_allow_comments = ($_POST['allow-comments'] == "on") ? true : false;
     }  else {
      $post_allow_comments = 0;
     }
   
     if(isset($_POST['input_post_img_field'])) {
     $post_img = $_POST['input_post_img_field'];
     } else {
     $post_img = "";
     }
     $post_publish_date = date("d.m.Y");
     $post_modified_date = "";
     $post_type = $type_code;     
     $post_author_id = $usr_ID;
     if(isset($_POST['post-pw']))  {
     $post_pw = sha1($_POST['post-pw']);
     } else {
     $post_pw = "";
     } 
     $post_url_adding = validate_perml($post_url_adding);
     
     if(!$edit_mode) {
     
     $post_img = trim($post_img);
     $conn = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_NAME);
     $post_sql1 = "INSERT INTO " . TBL_PRF . "posts VALUES ('', '$usr_ID', '$post_content')";
     $post_sql = "INSERT INTO " . TBL_PRF . "posts_meta VALUES ('',  '$post_url_adding', '$post_publish_date', '$post_category', '$post_keywords', '$post_nofollow', '$post_meta_desc', '$post_title', '$post_modified_date', '$post_allow_comments', '$post_pw', '$post_type', '', '$post_img', NULL, '$publish_private')";
     if(mysqli_query($conn, $post_sql) === TRUE AND mysqli_query($conn, $post_sql1)) {
      $good_note =  "<p class='good_note'>$type_good_all was published!</P>";
     } else {
      echo "<p>Error: We can't publish.</p>";
      echo mysqli_connect_error();
     }
     
     } else {
      $conn = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_NAME);
      $post_sql1 = "UPDATE " . TBL_PRF . "posts SET 	post_author_id='$usr_ID', 	post_text='$post_content' WHERE 'post_id' = '$pid'";
     
      $post_sql = "UPDATE `" . TBL_PRF . "posts_meta` SET `post_image` = '$post_img', `post_image_alt` = NULL, `post_permalink` = '$post_url_adding',  `post_category_id` = '$post_category', `post_keywords` = '$post_keywords', `post_nofollow` = '$post_nofollow', `post_meta_description` = '$post_meta_desc', `post_meta_title` = '$post_title', `post_modified` = '$post_modified_date', `post_can_comment` = '$post_allow_comments', `post_pw` = '$post_pw', `post_type` = '$post_type'  , `is_publish`='$publish_private' WHERE `post_meta_id` = '$pid' ";
 
       
     if(mysqli_query($conn, $post_sql) === TRUE AND mysqli_query($conn, $post_sql1)) {
      $good_note =  "<p class='good_note'>$type_good_all was updated!</P>";
     } else {
      echo "<p>Error: We can't publish your text. Please <a href='javascript:location.reload()'>try again</a>.</p>";
      echo mysqli_connect_error();
     }
     
     }
     
   }
      $errors .= "</p>";
      }
       if($edit_mode) {
    $e_conn = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_NAME);
    $e_sql  = "SELECT * FROM " . TBL_PRF . "posts WHERE post_id = '$pid'";
    $e_sql2 = "SELECT * FROM " . TBL_PRF . "posts_meta WHERE post_meta_id = '$pid'";
    
    $meta_query = mysqli_query($e_conn, $e_sql2);
    $e_query    = mysqli_query($e_conn, $e_sql);
    $meta_res   = mysqli_fetch_assoc($meta_query);
    $e_res      = mysqli_fetch_assoc($e_query);
    
    
   }
   ?>
<!DOCTYPE html>
<html style="height: 100%">
   <head>
      <title> <?php if($edit_mode) { echo "Edit"; } else { echo "Add"; }  echo $type_good ?> - simplecontent</title>
      <meta charset="utf-8">
     <script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
      <link rel="stylesheet" href="css/ui.css">
      <script src="js/var.js"></script>
      <script src="js/form-elements.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
      <link rel="stylesheet" href="css/default.css">
      <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
      <script type="text/javascript">
         tinyMCE.init({
         	// General options
              mode : "exact",
              elements : "sc-editor",
              theme : "advanced",
         	plugins : "safari,pagebreak,style,layer,table,save,advhr,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
            relative_urls: false,
         
         	// Theme options
         	theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontsizeselect",
         	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
         	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
         	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
         	theme_advanced_toolbar_location : "top",
         	theme_advanced_toolbar_align : "left",
         	theme_advanced_statusbar_location : "bottom",
         	theme_advanced_resizing : true,
         
                
                language: 'en', 
         
         	// Drop lists for link/image/media/template dialogs
         	template_external_list_url : "lists/template_list.js",
         	external_link_list_url : "lists/link_list.js",
         	external_image_list_url : "lists/image_list.js",
         	media_external_list_url : "lists/media_list.js",
         
         	 // CSS
                content_css: "css/tiny_mce.css", 
         });
      </script> 
      <script src="https://code.jquery.com/jquery-latest.js"></script>
   </head>
   <body style="height: 100%">
      <div id="wrapper" style="height: 100%">
         <div id="top-bar">
            <h4>Logged in as <?php echo $usr; ?> - <a href="login.php?logoff=1" title="Log out">Log out</a>?</h4>
         </div>
         <div id="left-menu-bar">
            <?php
               include_once "menu.inc.php";
               ?>
         </div>
         <div id="main">
            <h2><?php echo $type_good; ?> <?php if($edit_mode) { echo "bearbeiten"; } else { echo "erstellen"; } ?></h2>
            <form action="" id="form" method="POST" id="main-post-form">
               <div id="main-post-form">
                  <main id="main-control-panel">
                                                                 
                     <aside id="control-panel-input-content-editor">   
                     <noscript>
                      <h3>JS support</h3>
                      <p>We need JS, to display the visual Editor.</p>
                     </noscript>
                     <?php 
                      if(!empty($errors)) {
                     ?>
                     <div id="errors">
                      <?php
                       echo $errors;
                      ?>
                     </div>
                     <?php
                      }
                     ?>
                     <?php
                      if(isset($good_note)) {
                        echo $good_note;
                      }
                     ?>
                        <input style="width: 70%;background:white;margin:0" type="text" <?php if($edit_mode) { echo "value='$meta_res[post_meta_title]'"; } ?> name="post_title" width="60%" id="main-title-input" placeholder="Title..."><br>   
                        <p>Permalink: <i><?php echo getDomain(); ?></i><strong>/</strong><input
                        <?php if($edit_mode) { echo "value='$meta_res[post_permalink]'"; } ?>
                         type="text" name="url_add" id="url-input-field" value="<?php echo 'post-' . time(); ?>" class="url_input"> &nbsp; <a href="javascript:generateURL()">Generate permalink</a></p>
                         <br>
                         <!-- Here comes the SC-EDITOR, it works with Tiny MCE (an old version, updated by simplecontent) -->
                        <textarea name="post-content" id="sc-editor"><?php if($edit_mode) { echo "$e_res[post_text]"; } ?></textarea>
                     </aside>
                     <aside id="control-panel-right-option-bar">
                     <details open>
                     <br>
                     <summary>Veröffentlichung</summary>
                     <input type="submit" value="Publish" class="publish-standard" title="Publish now!" name="publish-standard"> <input type="submit" value="Publish private" name="publish-private" class="publish-private" title="Den Beitrag nur für Admins veröffentlichen">    
                     </details>
                     <details>
                      <summary>Password (not supported for all templates)</summary>
                      <p>Please enter password, if you will hide the post:</p>
                      <input type="password"  minlenght="4" maxlenght="15" class="pw" name="post-pw">
                    </details>
                     <details> 
                        <summary>SEO</summary>
                        <p>
                           <span>Keywords</span><br>
                           <input  name="keywords" class="sc-meta-keywords" <?php if($edit_mode == true) { echo "value='$meta_res[post_keywords]'"; } ?> placeholder="Note keywords">
                        </p>
                        <p>
                           <span>Description</span>&nbsp;&nbsp;<br>
                           <textarea name="post-meta-desc" id="input-textarea-meta-desc" ><?php if($edit_mode == true) { echo $meta_res['post_meta_description']; } ?></textarea>
                        </p>
                        <p>
                          <span>Search engines</span>
                          <br>
                          <input id="nofollow" name="seo-nofollow" type="checkbox" <?php if($edit_mode) { if($meta_res['post_nofollow']) { echo "checked"; } }  ?>> <label for="nofollow"> Add <code>nofollow</code> attribute    <a href="javascript:alert(nofollow_explain);">?</a>
                        </p>
                        
                    </details>  
                    <details>
                        <summary>Category</summary>
                        <p>
                            <span>Category</span><br>
                            <select name="category">
                                <?php
                                $cquery = connectMySQL("SELECT * FROM " . TBL_PRF . "categorys");
                                while($cat = mysqli_fetch_assoc($cquery)) {
                                    if($cat['category_standard'] === 1 AND $edit_mode == false) {
                                        $attr = "selected";
                                    }  elseif($cat['category_standard'] === 0 AND $edit_mode == false) {
                                      $attr = "";
                                    }  elseif($edit_mode) {
                                      if($meta_res['post_category'] == $cat['category_ID']) {
                                        $attr = "selected";
                                      }
                                    }
                                    echo "<option value='$cat[category_ID]' $attr>$cat[category_name]</option>\n";
                                }
                                ?>
                            </select>

                        </p>
                    </details>
                    <details>
                      <summary>Comments</summary>
                      <p>Hier kannst du Kommentare ein/ausschalten (not all templates will hide the comment-area)</p>
                      <input type="checkbox" id="allow-comments" name="allow-comments" 
                      <?php
                       if($edit_mode) {
                        if($meta_res['post_can_comment']) {
                          echo "checked";
                        } 
                       } else {
                        echo "checked";
                       }
                      ?>
                      >  <label for="allow-comments">Allow comments</label>
                    </details>
                    
                    <?php 
                     if($type == "post") {
                    ?>
                    <details>
                      <summary>Post-Image</summary>
                      <p>
                      <a href="javascript:openMediaLib()">Open Media-Lib</a>
                      <input type="text" readonly name="input_post_img_field" id="input_post_img_field" value="
                      <?php
                       if($edit_mode) {
                        if(!empty($meta_res['post_image']))   {
                          echo $meta_res['post_image'];
                        }
                       }
                      ?>
                      ">
                      
                      </p>
                    </details>
                    
                    <?php
                     }
                    ?>
                     </aside>
                  </main>
               </div>
            </form>
         </div>
      </div>
      <div id="media_lib"> <a class="close" href="javascript:closeMediaLib()">X</a>
      <div id="media_lib_list">
      <?php
    
      $dir = "../simple-content/upload/";   
      $handle = opendir($dir);
      while($file = readdir($handle)) {
        if($file != ".." && $file != ".") {
          $size = GetImageSize("../simple-content/upload/$file");
          $goodsize = array();
          echo "<a class='img_link' href=\"javascript:initIMG('$file');\"><img title='$file' id='img_thumb' class='lib_thumb' src='../classes/thumbnail_creator.php?file=$dir$file'></a>&nbsp;&nbsp;";
        }
       } 
        ?>
      </div>
      </div>
     
   </body>
</html>
