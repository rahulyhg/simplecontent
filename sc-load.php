<?php
/**
 * This file has got a lots of functions 
 * for simplecontent.
 */

 function sc_die($errorcode)


{
     require_once("classes/errormngr.php");
    } 

function getDomain()

{
     ini_set("allow_url_include", 1);
     $domain = $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
     $domain = str_replace("\\", "/", $domain);
     if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!='off' or $_SERVER['SERVER_PORT']==443) {
      $protocol='https://';
     } else { 
     $protocol='http://';
     }
     return str_replace("/backend", "", $domain);
    } 

function validateMail($mail)

{
     if (preg_match("/^[a-zA-Z0-9.!#$%&’*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/", $mail)) {
        return true;
         } else {
        return false;
         } 
    
    } 

/**
 * $sql = Any SQL Code, 
 * $return_fetch_assoc = BOOL, if you want a fetch assoc (result) and a query.
 */
function connectMySQL($sql = "", $return_fetch_assoc = false, $return_no = false)

{
     include_once "sc-config.php";
     $mysql_data[0] = MYSQL_USER;
     $mysql_data[1] = MYSQL_PASS;
     $mysql_data[2] = MYSQL_NAME;
     $mysql_data[3] = MYSQL_HOST;
    
     $conn = mysqli_connect($mysql_data[3], $mysql_data[0], $mysql_data[1]);
     mysqli_select_db($conn, $mysql_data[2]);
    
     if ($return_fetch_assoc == true) {
        $query = mysqli_query($conn, $sql);
         $result = mysqli_fetch_assoc($query);
         return $result;
         } elseif ($return_fetch_assoc == false AND $return_no == false) {
        $query = mysqli_query($conn, $sql);
         return $query;
         } elseif ($return_fetch_assoc == false AND $return_no == true) {
        return $conn;
         } 
    } 


function validateCommentForm($id)

{
    $errors = "";
    $conn = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_NAME);
     if (isset($_POST['email']) AND validateMail($_POST['email'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
         } else {
        $errors .= "<p>Bitte gebe eine (gültige) E-Mail-Adresse an (sie wird nicht veröffentlicht)!</p>";
         } 
    if (isset($_POST['name'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
         } else {
        $errors .= "<p>Bitte gebe einen Namen ein!</p>";
         } 
    if (isset($_POST['text'])) {
        $text = mysqli_real_escape_string($conn, strip_tags($_POST['text']));
         } else {
        $errors .= "<p>Dein Kommentar braucht einen Text!</p>";
         } 
    if (!empty($errors)) {
        return $errors;
         } else {
        $date_of_publish = date("d.m.y");
         if (getSetting("check_comments_before")) {
            $status = 0;
             } else {
            $status = 1;
             } 
        $status_note = "<p>";
         $sql = "INSERT INTO " . TBL_PRF . "comments VALUES('','$name','$email','$status','$id','$date_of_publish','$text')";
         if (mysqli_query($conn, $sql)) {
            
            if (!$status) {
                $status_note .= "Super! Dein Kommentar wartet nun auf Freischaltung, dann wird es zusehen sein.</p>";
                 } else {
                $status_note .= "Super! Dein Kommentar wurde veröffentlicht!</p>";
                 } 
            
            
            } else {
            $status_note .= "Schade... Leider gab es ein Problem, versuche es später nochmal.</p>";
             } 
        return $status_note;
        
         } 
    
    } 



function get_header()

{
     if (getSetting("disable_fa") == 0 || getSetting("template_need_fas" == 1)) {
        print("<script defer src='https://use.fontawesome.com/releases/v5.6.1/js/all.js' integrity='sha384-R5JkiUweZpJjELPWqttAYmYM1P3SNEJRM6ecTQF05pFFtxmCO+Y1CiUhvuDzgSVZ' crossorigin='anonymous'></script>\n");
         } 
    $title = getSetting("sitename");
     $subtitle = getSetting("subsitename");
     print("<title>$title – $subtitle</title>\n");
    print("<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n"); 
    
    
    } 

function updateSetting($name, $value)

{
     $conn = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_NAME);
     $name = mysqli_real_escape_string($conn, $name);
     $value = mysqli_real_escape_string($conn, $value);
     $query = connectMySQL("UPDATE " . TBL_PRF . "settings SET setting_value='$value' WHERE setting_name='$name'", false, false);
    } 
function get_category_by_id($id)
{
     $query = connectMySQL("SELECT * FROM " . TBL_PRF . "categorys WHERE category_id='$id'");
     $category = mysqli_fetch_assoc($query);
     return $category['category_name'];
    } 

function getPostId($perml)

{
     include_once "sc-config.php";
     $sql = "SELECT * FROM " . TBL_PRF . "posts_meta WHERE post_permalink = '$perml'";
    
     $query = mysqli_query(mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_NAME), $sql);
     $return = mysqli_fetch_assoc($query);
     return $return['post_meta_id'];
     } 


function getAuthorById($id)
{
    
     $sql = "SELECT * FROM " . TBL_PRF . "user WHERE user_ID ='$id'";
     $query = mysqli_query(mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_NAME), $sql);
     $userdata = mysqli_fetch_assoc($query);
     return $userdata['user_name'];
    } 



function getSetting($settingName)

{
     include_once "sc-config.php";
     $sql = "SELECT * FROM " . TBL_PRF . "settings WHERE setting_name='$settingName' AND setting_active='1'";
     $conn = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_NAME);
     $query = mysqli_query($conn, $sql);
     $setting = mysqli_fetch_assoc($query);
     return $setting['setting_value'];
     } 

/**
 * 
 * @param  $string = an string of a permalink, that have to validate
 */

function validate_perml($string)

{
     $string = str_replace("ü", "ue", $string);
     $string = str_replace("ö", "oe", $string);
     $string = str_replace("ß", "ss", $string);
     $string = str_replace(" ", "-", $string);
     $string = str_replace("ä", "ae", $string);
    
     return $string;
     } 

?>
