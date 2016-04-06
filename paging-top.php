<? 
//######################### FOR PAGING ######################
	
	if(empty($_GET['PageNo']))
		{
		if($StartRow == 0)
			{
			$PageNo = $StartRow + 1;
			}
		}
	else
		{
			$PageNo = $_GET['PageNo'];
			$StartRow = ($PageNo - 1) * $PageSize;
		 }
	//Set the counter start
	if($PageNo % $PageSize == 0){
			$CounterStart = $PageNo - ($PageSize - 1);
			}else{
			$CounterStart = $PageNo - ($PageNo % $PageSize) + 1;
			}
	//Counter End
		$CounterEnd = $CounterStart + ($PageSize - 1);
		$TRecord=mysql_query($sql);
		$RecordCount = mysql_num_rows($TRecord);
	//Set Maximum Page
		$MaxPage = $RecordCount % $PageSize;
		if($RecordCount % $PageSize == 0){
		$MaxPage = $RecordCount / $PageSize;
		}else{
		$MaxPage = ceil($RecordCount / $PageSize);
		}
		$prpg=mysql_query($sql);
		$prpgrec=mysql_num_rows($prpg);
##########____________________________##########
		  $query1= $sql." LIMIT ". $StartRow.",".$PageSize;	
		 // echo $query1;
		 
		  $rs = mysql_query($query1)or die(mysql_errno()." ".mysql_error());	
		  $rows=mysql_num_rows($rs);
//********************************************************************************************
?>