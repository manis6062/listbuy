<?
	class paypal
	{
		var $_SHIPPING_FLAG;
		var $_ITEM_NAME;
		var $_ORDER_ID;
		var $_AMOUNT;
		var $_CURRENCY_CODE;
		var $_LANGUAGE;
		var $_PAYMENT_RETURN_PAGE;
		var $_PAYMENT_CANCEL_PAGE;
		var $_PAYPAL_EM;
		var $_PAYPAL_URL;		
		
		function paypal_gateway()
		{
			$str_gateway_form = '<html><head></head><body>';
			$str_gateway_form .= '<form name="frmPayment" action="https://www.'.$this->_PAYPAL_URL.'.com/cgi-bin/webscr" method="post">';
			$str_gateway_form .= '<input TYPE="hidden" name="rm" value="2">';
			$str_gateway_form .= '<input TYPE="hidden" name="cmd" value="_xclick">';
			$str_gateway_form .= '<input type="hidden" name="business" value="'.$this->_PAYPAL_EM.'">';
			$str_gateway_form .= '<input type="hidden" name="no_shipping" value="'.$this->_SHIPPING_FLAG.'">';
			$str_gateway_form .= '<input TYPE="hidden" name="item_name" value="'.$this->_ITEM_NAME.'">';
			$str_gateway_form .= '<input TYPE="hidden" name="item_number" value="'.$this->_ORDER_ID.'">';
			$str_gateway_form .= '<input type="hidden" name="amount" value="'.$this->_AMOUNT.'">';
			$str_gateway_form .= '<input type="hidden" name="currency_code" value="'.$this->_CURRENCY_CODE.'">';
			$str_gateway_form .= '<input TYPE="hidden" name="lc" value="'.$this->_LANGUAGE.'">';
			$str_gateway_form .= '<input type="hidden" name="return" value="'.$this->_PAYMENT_RETURN_PAGE.'">';
			$str_gateway_form .= '<input type="hidden" name="cancel_return" value="'.$this->_PAYMENT_CANCEL_PAGE.'">';
			$str_gateway_form .= '<input type="hidden" name="notify_url" value="'.$this->_NOTIFY_URL.'">';
			$str_gateway_form .= '</form>';
			$str_gateway_form .= '<script language="javascript">';
			$str_gateway_form .= 'document.frmPayment.submit();';
			$str_gateway_form .= '</script></body></html>';
			
			echo $str_gateway_form;
		}
	}
?>