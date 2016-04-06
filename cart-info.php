<?
	$totalAdd=Select_Qry("COUNT(add_id) AS ADDID",ADVERTISE,"status='1'","","","","");
	
	$total_message=Select_Qry("COUNT(id) as prim",INBOX,"unread='0' AND recipent_id='".$_SESSION['user_id']."'","","","","");
?>
<div class="header_top"><div class="header_menu"><div class="header_menu_line1"><? if($_SESSION['user_id']!=""){?>Welcome <?=USERNAME($_SESSION['user_id'])?> | <a href="logout.php" class="header_menu_line2">Logout</a><? }else{?><br /><br /><? }?><?php /*?>MY BAG : <?=$totalAdd['ADDID']?> items<?php */?> </div>
    <div class="header_menu_line2"><? if($_SESSION['user_id']!=""){?><a href="my-message.php?mode=inbox" class="header_menu_line2">Inbox(<?php echo $total_message['prim']==""?"0":$total_message['prim']?>)</a> | <a href="my-account.php" class="header_menu_line2">Myaccount</a><? }?></div> 
    </div>
   <!--<div class="header_image"><img src="images/fresh-auction_02.jpg" width="49" height="68" alt="" /></div>-->
    </div>