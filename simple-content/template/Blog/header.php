<?php
  require_once ("sc-load.php");
  $header = getSetting("header_img");
?>
<!DOCTYPE html>
<html> 
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
  get_header();
?>
<link rel="stylesheet" href="simple-content/Template/Blog/css/default.css">
</head>
<body id="Blog-Template-Main-Area-with-Head">         
<div id="main-head" style="background-image: Url('simple-content/upload/<?php echo $header; ?>');">
<div id="main-head-social-area">
<div id="main-head-social-area-content">
      <!-- User can add social media per code -->
</div>
</div>
<div id="main-header-branding">
<div id="main-header-branding-content">
<div id="main-header-branding-content-title">
<h2 class="main-header-branding-content-title-heading"><?php echo getSetting("sitename"); ?></h2>
<span class="main-header-branding-content-title-desc"><?php echo getSetting("subsitename"); ?></span>
</div>
<div id="main-header-menu">
<div id="main-header-menu-content">
<?php include_once("simple-content/template/Blog/menu.php"); ?>
</div>
</div>
</div>
</div>
</div>