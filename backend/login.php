<?php
 // Startet die Session
 session_start();
 
 // Benötigte Dateien einbinden
 include_once "../sc-config.php";
 
 // Wenn der Benutzer schon angemeldet ist, wird er zur Backend-Startseite weitergeleitet. 
 if(isset($_SESSION['sc_logged_in']) AND $_SESSION['sc_logged_in'] == $secure_code) {
  // Auf index.php weiterleiten.
  header("Location: index.php");
  exit();
 } elseif(ACTIVATE == "no_____") {
  header("Location: install.php");
  exit();
 }
 
  // Fehler-Variable generieren, falls Fehler auftreten
  $errors = "";
 
 // Wurde das Formular abgeschickt?
 if(isset($_POST['submit-form'])) {
  // Wurde das Benutzername-Feld ausgefüllt?
  if(empty($_POST['username'])) {
   // Das Feld wurde ausgelassen, Fehlervariable befüllen.
   $errors .= "<p><b>Bitte gebe deinen Benutzernamen ein!</b></p>";
  }
  // Wurde ein Passwort eingegeben? 
  if(empty($_POST['pw'])) {
   // Das Feld wurde ausgelassen, Fehlervariable befüllen.
   $errors .= "<p><b>Bitte gebe dein Passwort ein!</b></p>";
  }
  
  // Wenn es keine weiteren Fehler gibt, wird weiter überprüft:
  
  if(empty($errors)) {
    // Überprüfen, ob die Mindestlänge des Benutzernamen (5 Stellen) eingehalten wurde:
    // Der reguläre Ausdruck lässt Zeichen wie ,-_. und alle Zahlen und Buchstaben zu.
    if(strlen($_POST['username']) < 4 OR strlen($_POST['username']) > 15 OR !preg_match("/[a-zA-Z0-9.-_]{4,15}/", $_POST['username'])) {
      $errors .= "<p><b>Bitte gebe einen gültigen Benutzernamen ein!</b></p>";
    }
    // Überprüfung des Passwortes (Mindestlänge: 8; Maximallänge: 20)
    if(strlen($_POST['pw']) > 20 OR strlen($_POST['pw']) < 8) {
      $errors .= "<p><b>Bitte gebe ein gültiges Passwort ein!</b></p>";
    }
    
    // Sollten alle Fehler behoben sein, wird die Datenbankabfrage ausgeführt.
    if(empty($errors)) {
      // Verbindung zu MySQL herstellen
      $conn = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_NAME);
      // Password hashen
      $password = sha1($_POST['pw']);
      // Benutzernamen sichern
      $username = mysqli_real_escape_string($conn, $_POST['username']);
      // SQL-Code speichern
      $loginsql = "SELECT * FROM " . TBL_PRF . "user WHERE user_name='$username' AND user_pw='$password'";  
      
      // Query senden
      $query = mysqli_query($conn, $loginsql);
      
  
      // Sind die Login-Daten richtig? 
      if(mysqli_num_rows($query) == 1) {
        // Login-Daten korrekt         
        // Werte aus DB speichern
        $user = mysqli_fetch_assoc($query);
        require_once("../sc-config.php");
        $errors .= "<p><b>Du bist jetzt eingeloggt, $username!</b></p>";
  
        $_SESSION['simplecontent_logged_in'] = true;
        $_SESSION['simplecontent_logged_hash'] = $secure_code;
        $_SESSION['username'] = $username;
        $_SESSION['usr_id'] = $user['user_ID'];
        $_SESSION['sc_rights'] = $user['user_rights'];
        header("Location: index.php");
        exit();
        
        
      } else {
        // Login-Daten falsch
        $errors .= "<p><b>Bitte überprüfe die eingegebenen Daten!</b></p>";
      }
      
      
    }
  }
  
 }
 
 // Wollte sich der User ausloggen?
 if(isset($_GET['logoff']))  {
  session_destroy();
  $_SESSION = array();
 }
 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta charset="utf-8">
  <meta name="generator" content="PSPad editor, www.pspad.com">
  <title>Anmelden</title>
  
  <style>
   @import url('https://fonts.googleapis.com/css?family=Open+Sans');
  * {
  font-family: Open Sans, sans-serif;
  }
  body {
   background: white; 
  }
  #main {
    width: 40%;
    margin:  0 auto;
  }
   
  </style>
  </head>
  <body>
  
  <div id="main">
  <h1>Anmelden</h1>
  <?php
  
  ?>
  <form action="" method="POST">
    Benutzername: <input type="text" name="username" minwidth="5" maxwidth="15"><br>
    Passwort:     <input type="password" name="pw" minwidth="8" maxwidth="20">  <br>
    <input type="submit" name="submit-form" value="Anmelden">
    <p>
    <a href="javascript:history.back();" style="color: #0080ff; text-decoration: none">&#x2190; Zur letzten Seite zurückkehren</a>
    </p>
  </form>
  
  <?php
   // Wenn es Fehler gibt, werden die jetzt angezeigt: 
   echo $errors;
  ?>
  </div>
  
  </body>
</html>
