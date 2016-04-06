<?php
ob_start();
require_once('../config/config.php');
validation_check($_SESSION['logged'], 'index.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=ADMIN_TITLE?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/side_scripts.js"></script>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><? include_once('header.php'); ?></td>
      </tr> 
      <tr>
        <td class="bodyarea">	
	<?php 
	  if($_REQUEST['page']=='change-password') 
		{ 
		include_once('change-password.php'); 
		}
		elseif($_REQUEST['page']=='web-settings') 
		{ 
		include_once('web-setting.php'); 
		}
		elseif($_REQUEST['page']=='email-setting') 
		{ 
		include_once('email-setting.php'); 
		}
		elseif($_REQUEST['page']=='account-setting') 
		{ 
		include_once('account-setting.php'); 
		}
		
		
		elseif($_REQUEST['page']=='static-cmslist') 
		{ 
		include_once('static-cmslist.php'); 
		}
		else if($_REQUEST['page']=='all-newsletter') 
		{ 
			include_once('all-newsletter.php'); 
		}
		else if($_REQUEST['page']=='add-newsletter') 
		{ 
			include_once('add-newsletter.php'); 
		}
		else if($_REQUEST['page']=='newslettermail') 
		{ 
			include_once('newslettermail.php'); 
		}
		else if($_REQUEST['page']=='user-newsletterlist') 
		{ 
			include_once('user-newsletterlist.php'); 
		}
		
		elseif($_REQUEST['page']=='user-list') 
		{ 
		include_once('user-list.php'); 
		}
		elseif($_REQUEST['page']=='add-user') 
		{ 
		include_once('add-user.php'); 
		}
		elseif($_REQUEST['page']=='my-message') 
		{ 
		include_once('my-message.php'); 
		}
		elseif($_REQUEST['page']=='proposal') 
		{ 
		include_once('proposal.php'); 
		}
		elseif($_REQUEST['page']=='all-proposal') 
		{ 
		include_once('all-proposal.php'); 
		}
		elseif($_REQUEST['page']=='bin-history') 
		{ 
		include_once('bin-history.php'); 
		}
		
		elseif($_REQUEST['page']=='question-list') 
		{ 
		include_once('question-list.php'); 
		}
		elseif($_REQUEST['page']=='feedback-list') 
		{ 
		include_once('feedback-list.php'); 
		}
		
		
		
		elseif($_REQUEST['page']=='category-list') 
		{ 
		include_once('category-list.php'); 
		}
		elseif($_REQUEST['page']=='attachment') 
		{ 
		include_once('attachment.php'); 
		}
		
		
		elseif($_REQUEST['page']=='post-advertise') 
		{ 
		include_once('post-auction.php'); 
		}
		elseif($_REQUEST['page']=='auction-list') 
		{ 
		include_once('auction-list.php'); 
		}
		elseif($_REQUEST['page']=='cancel-list') 
		{ 
		include_once('cancelled-list.php'); 
		}
		elseif($_REQUEST['page']=='newsletter-user') 
		{ 
		include_once('newsletter-user.php'); 
		}
		elseif($_REQUEST['page']=='report-list') 
		{ 
		include_once('report-list.php'); 
		}
		elseif($_REQUEST['page']=='sitestatus') 
		{ 
		include_once('sitestatus-list.php'); 
		}
		elseif($_REQUEST['page']=='update-logo') 
		{ 
		include_once('update-logo.php'); 
		}
		else 
		{
		echo("<script language=javascript>window.location='homepage.php';</script>");	
		}			
	?>
		</td>
      </tr>
        <tr>
        <td><? include_once('footer.php'); ?></td>
      </tr>
    </table>
	</td>
  </tr>
</table>
</body>
</html>
