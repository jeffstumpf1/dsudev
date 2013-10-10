	$.urlParam = function(name){
    var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (!results)
    { 
        return 0; 
    }
    return results[1] || 0;
	}
	
	var $custNumber = $.urlParam('customer_number');
	var $status = $.urlParam('status');
	if($custNumber) { ShowCustomerBanner($custNumber)}
	if($status) { $('#saveOrder').hide() }
	
	 	var $orderNumber = $.urlParam('order_number');
	if($orderNumber) { 
		ShowOrderBanner($orderNumber);
		UpdateOrderItemsBanner( $orderNumber );
	}
