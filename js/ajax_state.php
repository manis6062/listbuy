<? require_once('../config/config.php');	?>
	<select name="state" class="drop_box">
	<option selected="selected" value="">Select</option>
	<?
	$sql_m="select * from ".STATE." where countryId_fk='".$_REQUEST['country_id']."' order by stateName";
	$rs_m=mysql_query($sql_m);
	if(mysql_num_rows($rs_m)>0)
	{
		while($obj_m=mysql_fetch_object($rs_m))
		{
			echo("<option value='".$obj_m->stateId."'>".$obj_m->stateName."</option>");
		}
	}
	?>
	</select>
	
	