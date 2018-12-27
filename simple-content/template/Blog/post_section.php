<?php           
$conn = mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PASS,MYSQL_NAME);

$showposts = false;
if(!empty($_SERVER['QUERY_STRING'])) {
$querystring = mysqli_real_escape_string($conn, $_SERVER['QUERY_STRING']);
$getSQL = "SELECT * FROM " . TBL_PRF . "posts_meta WHERE post_permalink = '$querystring'";
$query    = connectMySQL($getSQL,false,false);

if(mysqli_num_rows($query) == 1) {
  $item = mysqli_fetch_assoc($query);
  if(getSetting("where_show_posts") != $item['post_meta_id']) {
  $text = connectMySQL("SELECT * FROM " . TBL_PRF . "posts WHERE post_id='$item[post_meta_id]'",true,false);
  echo "\n<h2>$item['post_meta_title']</h2>\n";  
  $category = get_category_by_id($item['post_category_id']);
  $date     = $item['post_publish_date'];
  $author   = getAuthorById($text['post_author_id']);
echo <<<SOCIAL
<i class="fas fa-thumbtack"></i> $category &nbsp;&nbsp; <i class="fas fa-calendar-alt"></i> $date  &nbsp;&nbsp;<i class="fas fa-user"></i> $author
SOCIAL;
  echo "<div style='width: 60%' id='c-area'>\n" . $text['post_text'] . "\n</div>\n";
  if(getSetting("leave_comments") AND $item['post_type'] == 1) {
    echo "<div id='comment-area'>\n<hr>\n";
    echo "<h2>Kommentare</h2>\n";
echo <<<COMMENTFORM
<form action="" method="post">
Name: <input type="text" name="name" >
<br>
E-Mail-Adresse: <input type="email" name="email">
<br>
<br>
Kommentar: <br>
<textarea name="text"></textarea><br><br>
<div id="btns">
<input type="submit" value="Senden" id="default_subm" name="go">&nbsp;&nbsp;<input type="reset" value="Formular leeren" id="default_clear">
</div>
</form>
COMMENTFORM;
    echo "</div>\n";
    if(isset($_POST['go'])) {
      echo validateCommentForm($item['post_meta_id']);
    }
    echo "<div id='comments'>\n";
    $query = connectMySQL("SELECT * FROM " . TBL_PRF . "comments WHERE comment_status='1' AND comment_post_id='$item[post_meta_id]' ORDER BY comment_id DESC");
    while($comment = mysqli_fetch_assoc($query)) {
      echo "<div id='comment'><p><i class='fas fa-calendar-alt'></i> $comment[comment_date] <i class='fas fa-user'></i> $comment[comment_author]</p><p>$comment[comment_content]</p></div>";
    }
    echo "</div>\n";
    
  }
  } else {
    $showposts = true;
  }
} else {
  $showposts = true;
}
}  else  {
$showposts = true;
}



if($showposts == true) {
$post_query = connectMySQL("SELECT * FROM " . TBL_PRF . "posts ORDER BY post_id DESC",false,false);

while($post = mysqli_fetch_assoc($post_query)) {
  $post_meta_query = connectMySQL("SELECT * FROM " . TBL_PRF . "posts_meta WHERE post_meta_id = '$post[post_id]' AND is_publish='1'",false,false);
  $post_meta       = mysqli_fetch_assoc($post_meta_query);
  $category = get_category_by_id($post_meta['post_category_id']);
  $date     = $post_meta['post_publish_date'];
  $author   = getAuthorById($post['post_author_id']);
  $post_permalink = $post_meta['post_permalink'];
  $post_title     = $post_meta['post_meta_title'];
  $post_reading   = substr($post['post_text'], 0, strpos($post['post_text'], '<!-- READMORE -->', 0));
  if($post_meta['post_type'] == 1) {
echo <<<POST_SECTION
<div id="default-post">
<div id="default-post-meta">
<div id="default-post-meta-content">
<i class="fas fa-thumbtack"></i> $category &nbsp;&nbsp; <i class="fas fa-calendar-alt"></i> $date  &nbsp;&nbsp;<i class="fas fa-user"></i> $author
</div>
</div>
<div id="default-post-title-section">
<div id="default-post-title-section-content">
<h2 class="default-post-heading"><a href="$post_permalink">$post_title</a></h2>
</div>
</div>
<div id="default-post-reading-section">
<p>$post_reading <a href="$post_permalink">Weiterlesen</a></p>
</div>
</div>
POST_SECTION;
  }  
  
}
}
?>
