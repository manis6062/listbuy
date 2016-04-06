<?php
	require_once('config/config.php');
	
	// read the post from PayPal system and add 'cmd'
	$req = 'cmd=_notify-validate';
	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$req .= "&$key=$value";
	}
	
	// post back to PayPal system to validate
	$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
	$fp = fsockopen ("www.".PAYPAL_URL.".com", 80, $errno, $errstr, 30);
	
	// assign posted variables to local variables
	$payment_amount = $_POST['amount'];
	$item_number = $_POST['item_number'];
	$txn_id = $_POST['txn_id'];
	if (!$fp) {
		// HTTP ERROR
	} 
	else{
		fputs ($fp, $header . $req);
		while (!feof($fp)) {
			$res = fgets ($fp, 1024);
			if(strcmp ($res, "VERIFIED") == 0) {
				
				Update_Qry(TRANSACTION,"txn_id='".$txn_id."', status='1', payment_date=NOW()"," WHERE trans_id='".$item_number."'");
				
				$obj=Select_Qry("*",TRANSACTION,"trans_id='".$item_number."'","","","","");
				
				$objPro=Select_Qry("*",ADVERTISE,"add_id='".$obj['add_id']."'","","","","");
				##########################TABLECREDIT######################
				$objCredit=Select_Qry("*",CREDIT,"user_id='".$obj['user_id']."'","","","","");
				if($obj['trans_purpose']=='Credit Purchase Fee'){
					if($objCredit != ''){
						Update_Qry(CREDIT," credit=(credit+".$obj['credit'].")","WHERE user_id='".$obj["user_id"]."'");
					}
					else
					{
						$creditValue="user_id='".$obj['user_id']."',credit='".$obj['credit']."',posted_on=NOW(),status='1'";
						Insert_Qry(CREDIT,$creditValue);
					}
				}
	###########################ENDCREDIT#######################
	if($obj['trans_purpose']=='Buy It Now Payment'){
		
		Update_Qry(ADVERTISE,"status='2',winner_id='".$obj['user_id']."'","WHERE add_id='".$obj['add_id']."'");
		Update_Qry(BIN,"status='3'","WHERE bin_id='".$obj['id']."'");
		
		$buyer=Select_Qry("*",USER,"user_id='".$obj['user_id']."'","","","","");
		$seller=Select_Qry("*",USER,"user_id='".$objPro['user_id']."'","","","","");	
		$title1="You have purchased a listing at ".WEB_ADDRESS;
		$title2="Your listing has been sold at ".WEB_ADDRESS;
		
		$body2="<p>Dear ".USERNAME($objPro['user_id']).",</p>
		<p>Your listing, ".ADDTITLE($obj['add_id']).", buyer has paid you directly via paypal. Below you will find the contact details of the buyer.</p>
		<p>&nbsp;</p>
		<p>
		<table style='height: 232px;' border='0' cellspacing='3' cellpadding='3' width='433' align='left'>
		<tbody>
		<tr>
		<td>Name</td>
		<td>:</td>
		<td>".USERNAME($obj['user_id'])."</td>
		</tr>
		<tr>
		<td>Street Addrees</td>
		<td>:</td>
		<td>".$buyer['st_add']."</td>
		</tr>
		<tr>
		<td>City</td>
		<td>:</td>
		<td>".$buyer['city']."</td>
		</tr>
		<tr>
		<td>State</td>
		<td>:</td>
		<td>".STATE($buyer['state'])."</td>
		</tr>
		<tr>
		<td>Zip</td>
		<td>:</td>
		<td>".$buyer['zip']."</td>
		</tr>
		<tr>
		<td>Country</td>
		<td>:</td>
		<td>".COUNTRY($buyer['country'])."</td>
		</tr>
		<tr>
		<td>Email</td>
		<td>:</td>
		<td>".$buyer['email']."</td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		</tbody>
		</table>
		</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>Thank You,</p>
		<p>".WEB_ADDRESS."</p>
		<p>&nbsp;</p>";
				
		
		$body1="<p>Dear ".USERNAME($buyer['user_id']).",</p>
		<p>You have successfully purchased the listing  ".ADDTITLE($obj['add_id']).". The payment has been transferred to the seller. Please view the details below.</p>
		<p>&nbsp;</p>
		<p>
		<table style='height: 232px;' border='0' cellspacing='3' cellpadding='3' width='433' align='left'>
		<tbody>
		<tr>
		<td>Name</td>
		<td>:</td>
		<td>".USERNAME($seller['user_id'])."</td>
		</tr>
		<tr>
		<td>Street Addrees</td>
		<td>:</td>
		<td>".$seller['st_add']."</td>
		</tr>
		<tr>
		<td>City</td>
		<td>:</td>
		<td>".$seller['city']."</td>
		</tr>
		<tr>
		<td>State</td>
		<td>:</td>
		<td>".STATE($seller['state'])."</td>
		</tr>
		<tr>
		<td>Zip</td>
		<td>:</td>
		<td>".$seller['zip']."</td>
		</tr>
		<tr>
		<td>Country</td>
		<td>:</td>
		<td>".COUNTRY($seller['country'])."</td>
		</tr>
		<tr>
		<td>Email</td>
		<td>:</td>
		<td>".$seller['email']."</td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
		</tbody>
		</table>
		</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>Thank You,</p>
		<p>".WEB_ADDRESS."</p>
		<p>&nbsp;</p>";
		Send_HTML_Mail($buyer['email'], ADMIN_EMAIL, '', $title1, $body1);
		Send_HTML_Mail($seller['email'], ADMIN_EMAIL, '', $title2, $body2);	
		}
				
		#######################FOR USER#####################
		if($obj['trans_purpose']=='Credit Purchase Fee'){
				$mail_To = $obj['email'];
				$mail_From = ADMIN_EMAIL;
				$mail_subject = $obj['trans_purpose']." Transferred Successfully";
				$name = $obj['name'];
				$message="&nbsp;&nbsp;&nbsp;Dear ".$name.",&nbsp;&nbsp;&nbsp;<br><br>"."Thank you for your purchase of credits.."."<br><br>"."&nbsp;&nbsp;&nbsp;"."Your purchased was  $".$obj['credit']."USD.<br><br>&nbsp;&nbsp;&nbsp;Your account at '.WEB_ADDRESS.' has been credited.<br><br>&nbsp;&nbsp;&nbsp;Please <a href='http://".$_SERVER['HTTP_HOST']."/login.php'>login</a> to your account to view the credit details.<br><br>&nbsp;&nbsp;&nbsp;"."Best Regards,"."<br>".WEB_ADDRESS." ";
				
				Send_HTML_Mail($mail_To, $mail_From, '', $mail_subject, $message);
				#######################FOR ADMIN#####################
				
				$mailsubject = $obj['trans_purpose']." Transferred Successfully";
				$message1="&nbsp;&nbsp;&nbsp;"."User ".$obj['name']." has paid an amount of $".$obj['credit']."USD for ".$obj['credit']."credits at ".WEB_ADDRESS.".<br><br>";
				 
				Send_HTML_Mail(ADMIN_EMAIL, $obj['email'], '', $mailsubject, $message1);
			}
			}
			elseif(strcmp ($res, "INVALID") == 0) {
				Delete_Qry(TRANSACTION,"WHERE trans_id='".$item_number."'");
			}
		}
		fclose ($fp);
	}
?>