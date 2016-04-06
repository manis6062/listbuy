<?

if($_REQUEST['usrchk']!=""){
	$_SESSION['usr']=implode(",",$_REQUEST['usrchk']);	
}
?>

<script language="javascript">
	function delayer(){
		document.getElementById("txtHint").innerHTML="<?=successfulMessage("All Mails Has been Success fully Sent. <br>Please Wait you will be redirected to the All News Letter Page within 3 seconds.")?>";
		setTimeout('redirect()', 6000);
	}
	function redirect()
	{
		window.location="home.php?page=all-newsletter";
	}
	function delayer1(){
    setTimeout('delayer()', 10000);
	}
	
</script>

<form name="frm" method="post" action="">
			<input type="hidden" name="mid" value="<?=$_REQUEST['mid']?>">
					<input type="hidden" name="action" value="DOMail">
					 <input type="hidden" name="mode" value="<?=$_REQUEST['mode']?>">
					<input type="hidden" name="cat" value="<?=$_REQUEST['cat']?>">
<table width="100%" >
			<tr>
			  <td align="center" id="txtHint">
			  <?
			  if(isset($_REQUEST['action']) && $_REQUEST['action']=="DOMail")
			  {
			  ?>
			  <img src="images/progress.gif" border="0" />
			  <br />
			  <br />
			 <strong>Please wait while the mails are being sent</strong>
			  <?
			  }
			  else
			  {
			  if($_REQUEST['mode']=="selected")$mode="selected users";
			  if($_REQUEST['mode']=="all")$mode="all_users";
			  if($_REQUEST['mode']=="")$mode="all_users";
			  //if(!isset($_REQUEST['mode'])$mode="all users";
			  ?><br />

			  <strong>You Have Selected to Send Mail to <?php echo $mode;?>.</strong>
			  <?
			  }
			  ?>  
			 
			  </td>
			  </tr>
		   <? if(isset($_REQUEST['action']) && $_REQUEST['action']=="DOMail")
					  	{
						}
						else{
						?>
						<tr><td>&nbsp;</td></tr>
			<tr>
			  <td align="center"><input name="btn_confirm" type="submit" class="btnmain" value="Confirm! Send Mail To <?php echo $_REQUEST['mode']=="selected" ? "Selected User" : "All"?>"/></td>
			  </tr>
			  <?
			  }
			  ?>
			</table>
</form>
<?
if(isset($_REQUEST['action']) && $_REQUEST['action']=="DOMail"){
	if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="selected"){
	
		$news=explode(",",$_SESSION['newsletter']);
		
		$usrchk=explode(",",$_SESSION['usr']);
		
		for($n=0;$n<sizeof($news);$n++){
			$obnews=Select_Qry("*",NEWSLETTER," newsletter_id='".$news[$n]."'","","","", "");
			if($obnews)
			{
				$subject=stripslashes($obnews['subject']);
				$content=stripslashes($obnews['content']);
			}
			for($u=0; $u<sizeof($usrchk); $u++){
				$fieldUS = "*";
				$tableUS = USER;
				$where_clauseUS = " id='".$usrchk[$u]."'";
				
				
				
				$obj_ps=Select_Qry($fieldUS,$tableUS,$where_clauseUS,"","","","");
				$to      	= $obj_ps['email'];
				$subject 	= $subject;
				$body 		= $content;
				//$body		.= " <p>You can Unscribe this service by click <a href='".$_SERVER['HTTP_HOST']."/unscribenews.php?u=".$usrchk[$u]."'>here</a></p>";
				$mail_Headers  = "MIME-Version: 1.0\r\n";
				$mail_Headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$mail_Headers .= "To: ".$to."\r\n";
				$mail_Headers .= "From: ".ADMIN_EMAIL."\r\n";
				//echo($body);
				if($obj_ps["status"]=='1'){
					mail($to, $subject, $body, $mail_Headers);
				}
			}
		}
		
	}
	else{
	$obj=Select_Qry("*",NEWSLETTER," newsletter_id='".$_REQUEST['mid']."'","","","", "");
	
	//$sql="SELECT * FROM news_letter WHERE id='".$_REQUEST['mid']."'";
	//$rs=mysql_query($sql);
	if($obj)
	{
		$subject=stripslashes($obj['subject']);
		$content=stripslashes($obj['content']);
	}
	$fieldUS = "*";
	$tableUS = USER;
	$where_clauseUS = " WHERE status='1'";

	//$sql_ps="SELECT display_name,email FROM user ORDER BY id";
	//$rs_ps=mysql_query($sql_ps);
		$result=Listing_Qry($fieldUS,$tableUS,$where_clauseUS,"");
		if($result)
		{
		
		foreach($result as $obj_ps)
		//while($obj_ps=mysql_fetch_object($rs_ps))
		{
###############Send Mail
			$to = $obj_ps['email'];
		
			$subject 	= $subject;
			$body 		= $content;
			$mail_Headers  = "MIME-Version: 1.0\r\n";
			$mail_Headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$mail_Headers .= "To: ".$to."\r\n";
			$mail_Headers .= "From: ".ADMIN_EMAIL."\r\n";
			//echo($body);
			mail($to, $subject, $body, $mail_Headers);
			#######################
		}
	   }
	   else
	   {
	        //header('location: home.php?status=newsletterlist');
			echo"<script>window.location=home.php?status=newsletterlist</script>";
	   }
	   }
#########################
		echo("<script language='javascript'>delayer1()</script>");
}
?>