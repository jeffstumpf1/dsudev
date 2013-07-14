
<?php

// EMAIL CLASS

class Email
{
	
	var $mailMessageStatus;
	
 	// Billing Information
	var $introtext;
	var $logo;
	var $billtoemail;
	var $billto;
	var $phone;

	// Order Information
	var $ordernumber;
	var $reciptdate;
	var $shippingmethod;
	var $payment;
	var $cc_type;
	var $cc_num;
	var $cc_expires;
	var $cc_securitycode;
	var $paypal_email;
	
	// Order Details
	var $orderLineItems;
	
	// Order Summary
	var $subtotal;
	var $tax;
	var $shipping;
	var $total;

	// Receipt Footer
	var $footerText;
	var $supportText;
	
	// Product Recordset
	var $row_rsOrderProduct;
	var $rsOrderProduct;
	
	function Email()
	{
		$this->billto = '';
	}
	
	
	function billedTo()
	{
		$msg='';
		$msg = $this->billto;
		$msg .= '<br/>';
		$msg .= $this->billtoemail.'<br/>';
		$msg .= $this->phone.'<br/>';
		return $msg;
	}
	
	function orderInfo()
	{
		$msg = $this->ordernumber.'<br/>';
		$msg .= $this->receiptdate.'<br/>';
		$msg .= $this->payment.'&nbsp;&nbsp;'.$this->total.'<br/>';
		$msg .= $this->shippingMethod.'<p/>';
		return $msg;
	}
	
	function orderStoreInfo()
	{
		$msg = $this->ordernumber.'<br/>';
		$msg .= 'Date: '.$this->receiptdate.'<br/>';
		$msg .= 'Total: '.$this->total.'<br/>';
		$msg .= 'Type: '.$this->cc_type.'<br/>';
		$msg .= 'Number: '.$this->cc_num.'<br>';
		$msg .= 'Exp: '.$this->cc_expires.'<br/>';
		$msg .= 'Pin: '.$this->cc_securitycode.'<br/>';
		$msg .= 'Ship: '.$this->shippingMethod.'<br/>';
		$msg .= 'Paypal: '.$this->paypal_email.'<p/>';
		return $msg;
	
	}
	
	function orderDetail()
	{
		$hostname_cn_xac = "localhost";
		$database_cn_xac = "xaudiocovers_com_-_xac";
		$username_cn_xac = "jstumpf";
		$password_cn_xac = "magicboat";
		$cn_xac = mysql_pconnect($hostname_cn_xac, $username_cn_xac, $password_cn_xac) or trigger_error(mysql_error(),E_USER_ERROR); 

	
		$colname_rsOrderProduct = "-1";
	if (isset($_SESSION['orderid'])) {
	  $colname_rsOrderProduct = (get_magic_quotes_gpc()) ? $_SESSION['orderid'] : addslashes($_SESSION['orderid']);
	}
	mysql_select_db($database_cn_xac, $cn_xac);
	$query_rsOrderProduct = sprintf("SELECT * FROM orders_products WHERE orders_id = %s", $colname_rsOrderProduct);
	$rsOrderProduct = mysql_query($query_rsOrderProduct, $cn_xac) or die(mysql_error());
	$row_rsOrderProduct = mysql_fetch_assoc($rsOrderProduct);
	$totalRows_rsOrderProduct = mysql_num_rows($rsOrderProduct);
		$tbl = '';
		
		$tbl = '<table width="80%" border="0" cellspacing="1" cellpadding="1" style="border:1px solid #00;">';
        $tbl .= '<tr>';
        $tbl .= '<td style="background-color:#ccc;color:#000;">Cart Items </td>';
        $tbl .= '<td style="background-color:#ccc;color:#000;" align="center" class="orderheader">Quantity</td>';
        $tbl .= '<td style="background-color:#ccc;color:#000;" align="right" class="orderheader">Item Price </td>';
        $tbl .= '<td style="background-color:#ccc;color:#000;" align="right" class="orderheader">Item Total </td>';
        $tbl .= '</tr>';
        $tbl .= '<tr>'; 
						
		do { 
			$Products = new ProductsOrdered($row_rsOrderProduct);
			
			$tbl .= '<td nowrap="nowrap">'.$Products->getCartItem().'</td>';
			$tbl .= '<td align="center">'.$Products->getItemQuantity().'</td>';
			$tbl .= '<td align="right">'.$Products->getItemPrice('$').'</td>';
			$tbl .= '<td align="right">'.$Products->getItemTotal('$').'</td>';
			$tbl .= '</tr>';
			
			$Products->ProductsOrdered($row_rsOrderProduct);
		}while ($row_rsOrderProduct = mysql_fetch_assoc($rsOrderProduct)); 
		
		mysql_free_result($rsOrderProduct);
		
        $tbl .= '<tr>';
        $tbl .= '<td colspan="4" class="borderbottom"></td>';
        $tbl .= '</tr>';
        $tbl .= '<tr>';
        $tbl .= '<td>&nbsp;</td>';
        $tbl .= '<td colspan="2">Order Subtotal: </td>';
        $tbl .= '<td align="right"><strong>'.$this->subtotal.'</strong></td>';
        $tbl .= '</tr>';
        $tbl .= '<tr>';
        $tbl .= '<td>&nbsp;</td>';
        $tbl .= '<td colspan="2">Shipping Cost: </td>';
        $tbl .= '<td align="right"><strong>'.$this->shipping.'</strong></td>';
        $tbl .= '</tr>';
        $tbl .= '<tr>';
        $tbl .= '<td>&nbsp;</td>';
        $tbl .= '<td colspan="2">Estimated Tax: </td>';
        $tbl .= '<td align="right" style="border-bottom:1px solid gray;"><strong>'.$this->tax.'</strong></td>';
        $tbl .= '</tr>';
        $tbl .= '<tr>';
        $tbl .= '<td>&nbsp;</td>';
        $tbl .= '<td colspan="2" nowrap="nowrap"><strong>Estimated Total: </strong></td>';
        $tbl .= '<td align="right"><strong>'.$this->total.'</strong></td>';
        $tbl .= '</tr>';
        $tbl .= '</table>';
		
		return $tbl;
	}
	
	
	function footer()
	{
		$msg = "<br/>";
		$msg .= '<p style="margin-bottom:0"><strong>Please retain for your records</strong></p>';
		$msg .= 'Please See Below For Terms And Conditions Pertaining To This Order.';
		$msg .= '<br/>';
		$msg .= '<p style="margin-bottom:0"><strong>Xtreme Audio Covers</strong></p>';
		$msg .= 'You can find the Xtreme Audio Covers Store Terms of Sale and Sales Policies by</br/>';
		$msg .= 'going to http:\\\wwww.xaudiocovers.com website<br/>';
		$msg .= '<p style="margin-bottom:0">If you have need to make changes to this order or just have a question?</p>';
		$msg .= 'please call 949.233.1450, and someone will assist you.<br/>';
		$msg .= '</br>';
		$msg .= 'Thank you for your order!';
		
		return $msg;
	}
	
	function formatReceipt()
	{
		$SEPCOUNT = 65;
		
		$msg = '<html><body>';
		$msg .= '<img src="http://www.xaudiocovers.com/images_xac/logo.gif" width="170" height="137" />';
		$msg .= '<h3 style="margin-top:0;margin-bottom:0">Xtreme Audio Covers'."</h3>";
		$msg .= "(949) 233-1450";
		$msg .= $this->separator();
		$msg .= '<table width="90%" cellspacing="1" cellpadding="2">';
		$msg .= '<tr><td style="text-align: left; width= 50%;vertical-align:top;" >';
		$msg .= '<p style="margin-bottom:0;"><strong>BILLED TO:</strong></p>';
		$msg .= $this->billedTo();
		$msg .= '</td><td style="text-align:left; vertical-align:top">';
		$msg .= '<p style="margin-bottom:0;"><strong>ORDER INFO:</strong></p>';
		$msg .= $this->orderInfo();
		$msg .= '</td></tr>';
		$msg .- '</table><p/>';
		//$msg .= $this->separator();
		$msg .= $this->orderDetail();
		$msg .= $this->footer();
		$msg .= '</body></html>';
		
		return $msg;
	}
		

	function formatStoreReceipt()
	{
		$SEPCOUNT = 65;
		
		$msg = '<html><body>';
		$msg .= '<img src="http://www.xaudiocovers.com/images_xac/logo.gif" width="170" height="137" />';
		$msg .= '<h3 style="margin-top:0;margin-bottom:0">Xtreme Audio Covers - Store Copy'."</h3>";
		$msg .= "(949) 233-1450";
		$msg .= $this->separator();
		$msg .= '<table width="90%" cellspacing="1" cellpadding="2">';
		$msg .= '<tr><td style="text-align: left; width= 50%;vertical-align:top;" >';
		$msg .= '<p style="margin-bottom:0;"><strong>BILLED TO:</strong></p>';
		$msg .= $this->billedTo();
		$msg .= '</td><td style="text-align:left; vertical-align:top">';
		$msg .= '<p style="margin-bottom:0;"><strong>ORDER INFO:</strong></p>';
		$msg .= $this->orderStoreInfo();
		$msg .= '</td></tr>';
		$msg .- '</table>';
		//$msg .= $this->separator();
		$msg .= $this->orderDetail();
		$msg .= $this->footer();
		$msg .= '</body></html>';
		
		return $msg;
	}

	function sendReceipt($to, $subject)
	{
		$msg = '';
		$parameters='';
		$message = $this->formatReceipt();
		$headers = 'MIME-Version: 1.0'."\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
		
		$success = mail($to.',', $subject, $message, $headers, $parameters);
		$message = $this->formatStoreReceipt();
		$success = mail('holly@xaudiocovers.com', $subject.' - Store Receipt', $message, $headers, $parameters);
		
		
		
		if($success) {
			$msg = 'We have sent you an electronic receipt to your email.';
		} else {
			$msg = 'We were not able to send you a copy of your electronic receipt</br>';
			$msg .= 'Using this email address '.$this->billtoemail;
		}
		$this->mailMessageStatus = $msg;
		//echo $msg;
	}
	
	
	function separator()
	{
		$msg='';
		$msg = '<hr width="100%" hieght="1" style="align-left;"/>';
		return $msg;
	}
	
}


?>