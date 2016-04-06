<?
	$randNumber=rand(9999999,95959599999);
		$f			=	" * ";
		$t			=	CONFIG;
		$where 	= "id='1'";
		
		$SAS=Select_Qry($f,$t,$where,'','','','');
		
		define(ADMIN_TITLE,$SAS['admin_header_title']);
		
		define(TITLE,$SAS['frontend_header_title']);
		  
		
		
		define(WEB_ADDRESS,$SAS['website_address']);
		
		define(ADMIN_EMAIL,$SAS['admin_email']); 
		
		define(REPLY_EMAIL,$SAS['reply_email']);
		
		define(PAYPAL_EMAIL,$SAS['paypal_email']);
		
		define(PAYPAL_URL,$SAS['paypal_url']);
		
		define(VALLID_DAYS,$SAS['listing_valid_days']);
		
		define(BASIC_FEE,$SAS['fee_posting']);
		
		define(FEE_BOLD,$SAS['fee_bold']);
		
		define(FEE_HIGHLIGHTED,$SAS['fee_highlighted']);
		
		define(FEE_FEATURED,$SAS['fee_featured']);
		
		define(FEE_ROWBORDER,$SAS['fee_rowborder']);
		
		
		define(IMAGE_PATH,"http://".WEB_ADDRESS."/images");
		
		define(CSS_PATH,"http://".WEB_ADDRESS."/css");
		
		define(EMAIL_FOOTER,"This email and any attachments transmitted contain confidential and privileged information. It is intended for the exclusive use of the person whom it is addressed and may not otherwise be read, distributed, copied or disclosed. If you have received this email in error, please notify our office immediately and return the original transmission to us. Thank you for your co-operation.");
		
?>