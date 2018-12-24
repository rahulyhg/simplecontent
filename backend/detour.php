<?php

session_start();
require_once("../sc-config.php");

// Ist der Benutzer eingeloggt? Wenn nicht wird er zum Login-Formular weitergeleitet
if(isset($_SESSION['simplecontent_logged_in']) AND 
isset($_SESSION['username']) AND isset($_SESSION['sc_rights']) AND 
isset($_SESSION['simplecontent_logged_hash']) AND 
$_SESSION['simplecontent_logged_hash'] == $secure_code) {
  $usr = $_SESSION['username'];
  $rights = $_SESSION['sc_rights'];
  $usr_ID = $_SESSION['usr_id'];
  } else {
   header("Location: login.php");
   exit();
 }
  
  if( ACTIVATE == "no_____") {
  
  header("Location: install.php");
  exit();
  
 } elseif(file_exists("install.php") AND ACTIVATE != "no_____") {
  unlink("install.php");
 } 
?>                         