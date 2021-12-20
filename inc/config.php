<?php
session_start();
$GLOBALS['site_url']="http://localhost/php-crud/";
$GLOBALS['assets_url']="http://localhost/php-crud/assets/";
$GLOBALS['servername']='localhost';
$GLOBALS['username']='root';
$GLOBALS['password']='';
$GLOBALS['dbname']='php_crud';
$GLOBALS['cookie_name'] = "php_crud_login";

include_once('inc/connection.php');
include_once('inc/functions.php');
include_once('inc/auth.inc.php');
include_once('inc/user.inc.php');
?>