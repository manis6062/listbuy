<?
	require_once('config/config.php');
	include_once("includes/paypal.php");
	if($_REQUEST['mode'] == "buyitnow" || $_REQUEST['mode'] == "credit") {
		if($_REQUEST['mode'] == "buyitnow")
		{
			$purpose='Buy It Now Payment';
		}
		if($_REQUEST['mode'] == "credit")
		{
			$purpose='Credit Purchase Fee';
		}
		
		/*if($_REQUEST['amount']==0){
			echo"<script type='text/javascript'>window.location.href='mylistings.php'</script>";
		}
		else{*/
		if($_REQUEST['credit']!=''){
			$amount = $_REQUEST['credit'];
		}
		if($_REQUEST['amount']!=''){
			$amount = $_REQUEST['amount'];
		}
		$tmp_sess_id = session_id();
		$table = TRANSACTION;
		$value = "user_id='".$_SESSION['user_id']."',
				  add_id='".$_REQUEST['add_id']."',
				  bin_id='".$_REQUEST['bin_id']."',
				  name ='".escapeQuotes(stripslashes($_SESSION['username']))."',
				  email ='".escapeQuotes(stripslashes($_SESSION['email']))."',
				  trans_purpose = '".escapeQuotes(stripslashes($purpose))."',
				  credit='".$_REQUEST['credit']."',
				  trns_amount = '".$_REQUEST['amount']."',
				  sess_id = '".$tmp_sess_id."'";
		Insert_Qry($table,$value);
		$paymentId = mysql_insert_id();
		$record=Select_Qry("*",ADVERTISE,"add_id='".$_REQUEST['add_id']."'","","","","");
		if($_REQUEST['mode']=="buyitnow"){			
			$payemail=$record['paypal_email'];
		}
		else{		
			$payemail=PAYPAL_EMAIL;
		}
		
		$class_paypal = new paypal();			
		$class_paypal->_SHIPPING_FLAG = '0';
		$class_paypal->_ITEM_NAME = $purpose;
		$class_paypal->_AMOUNT = $amount;
		$class_paypal->_CURRENCY_CODE = 'USD';
		$class_paypal->_LANGUAGE = 'US';
		$class_paypal->_ORDER_ID = $paymentId;
		$class_paypal->_NOTIFY_URL = "http://".WEB_ADDRESS.'/payment_notify.php';
		$class_paypal->_PAYMENT_RETURN_PAGE = "http://".WEB_ADDRESS.'/payment_success.php';
		$class_paypal->_PAYMENT_CANCEL_PAGE = "http://".WEB_ADDRESS.'/payment_failed.php';
		$class_paypal->_PAYPAL_EM = $payemail;
		$class_paypal->_PAYPAL_URL = PAYPAL_URL;
		
		$class_paypal->paypal_gateway();
		//}
	}
	else
	{
			echo("<script language='javascript'> window.location.href='mylistings.php'</script>");
	}
?>