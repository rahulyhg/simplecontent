<?php
include_once "../classes/errormngr.php";
if(empty($rights))   {
  sc_error(5);
} else {
  if($rights >= 1) {
    echo "<a href='index.php' title='Home'>Home</a><br>";
  } 
  if($rights >= 2) {
    echo "<a href='overview.php?type=post' title='Posts'>Posts</a><br>
    &nbsp;&nbsp;&nbsp;&nbsp;<a href='edit.php?type=post'>Add post</a><br>
    &nbsp;&nbsp;&nbsp;&nbsp;<a href='categorys.php'>Categorys</a><br>";
    echo "<a href='media.php' title='Media'>Media</a><br>";
  }
  if($rights >= 3) {
    echo "<a href='overview.php?type=page' title='Pages'>Pages</a><br>
    &nbsp;&nbsp;&nbsp;&nbsp;<a href='edit.php?type=page'>Add Page</a><br>";
    echo "<a href='templates.php' title='Templates'>Templates</a><br>";
    echo "<a href='comments.php' title='Comments'>Comments</a><br>"; 
  }
  if($rights >= 4) {
    echo "<a href='user-overview.php' title='Manage user'>User</a><br>";
    echo "<a href='settings.php' title='Settings'>Settings</a><br>";
  }
}
?>