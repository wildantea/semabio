<?php
ini_set( "display_errors", true );
define( "HOST", "localhost" );
//nama database
define( "DATABASE_NAME", "new_backend" );
define( "DB_USERNAME", "root" );
//password mysql
define( "DB_PASSWORD", "mypatrick" );

//main directory
define( "DIR_MAIN", "match_app");

//admin directory
define( "DIR_ADMIN", "match_app/admina");


define('DB_CHARACSET', 'utf8');

//languange
$language  = "en";

require_once ("lang/$language.php");
require_once ('Database.php');
require_once ('Dtable.php');
require_once ('My_pagination.php');
require_once ('function.php');

$db=new Database();
$pg=New My_pagination();
$datatable=New Dtable();
function handleException( $exception ) {
  echo  $exception->getMessage();
}

set_exception_handler( 'handleException' );
?>
