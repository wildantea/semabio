<?php
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
ini_set( "display_errors", true );

$host = "localhost";
$port = 3306;
$db_username = "root";
$db_password = "mypatrick234";
$db_name = "submission_bio";

//main directory
define( "DIR_MAIN", "semabio");

//admin directory
define( "DIR_ADMIN", "semabio/dashboard");


define('DB_CHARACSET', 'utf8');

define ('SITE_ROOT', $_SERVER['DOCUMENT_ROOT']."/".DIR_MAIN);

//languange
$language  = "id";

require_once ("lang/$language.php");
require_once ('Database.php');
require_once ('Dtable.php');
require_once ('New_db.php'); 
require_once ('New_dtable.php');
require_once ('My_pagination.php');
require_once ('function.php');

$db=new Database($host,$port,$db_username,$db_password,$db_name);
$db2=new New_db($host,$port,$db_username,$db_password,$db_name);
$datatable2=New New_dtable($host,$port,$db_username,$db_password,$db_name);
$pg=New My_pagination($db);
$datatable=New Dtable($host,$port,$db_username,$db_password,$db_name);
function handleException( $exception ) {
  echo  $exception->getMessage();
}

set_exception_handler( 'handleException' );
?>
