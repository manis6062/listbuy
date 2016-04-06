<?

error_reporting(0);
set_time_limit(0);
session_start();
if(!isset($_SESSION['username']))
{
header("location:index.php");
}

$username = 'listbuy_srch';
$password = 'Kandia2013';
$hostname = 'localhost';
$database = 'listbuy_srch';

$filename = "backup-" . date("d-m-Y"). ".sql.gz";
$mime = "application/x-gzip";

header( "Content-Type: " . $mime );
header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
$cmd = "mysqldump -u $username --password=$password $database| gzip --best";   
passhthru( $cmd );

exit(0);
