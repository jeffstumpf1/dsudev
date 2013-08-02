// order.js
	
/******************** Order Information *************************/

 $(function() {	
 
 	// Initialize
 	$orderNumber='';
 	
 	ShowOrderBanner($orderNumber);

	function ShowOrderBanner($orderNumber) {
	
		$.ajax({
			  type: 'GET',
			  url: 'service/order-banner.php',
			  data: { order_number: $orderNumber },
			  beforeSend:function(){
				// load a temporary image in a div
			  },
			  success:function(data){
				$('#order-banner').html(data);
				//alert(data);
			  },
			  error:function(){
				$('#order-banner').html('<p class="error"><strong>Oops!</strong></p>');
			  }
			});
	}

});


/** End of order.js **/