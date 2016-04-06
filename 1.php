<? 
error_reporting(0);
	require_once('config/config.php');
	
$qu=mysql_query("select * from tbl_add");
while($te=mysql_fetch_array($qu))
{
$id=$te['add_id'];
$key=$te['nkeyword'];

$k1=explode(".",$key);
$k2=$k1[0];

mysql_query("UPDATE `tbl_add` SET `nkeyword`='$k2' WHERE add_id='$id'");



}

?>