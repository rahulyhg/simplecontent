<?php
require_once "sc-load.php";
$query = connectMySQL("SELECT * FROM " . TBL_PRF . "posts_meta WHERE post_type='2' AND is_publish='1'",false,false);
while ($item = mysqli_fetch_assoc($query)){
if($item['post_nofollow']) {
  $attr = "nofollow";
} else {
  $attr = "";
}
  echo "<a href='$item[post_permalink]' title='$item[post_meta_title]'>$item[post_meta_title]</a>\n";
}
?>