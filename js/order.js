// order.js
	
/******************** Order Information *************************/

 $(function() {	
 
 	// Initialize
 	$orderNumber='';
 	
 	ShowOrderBanner($orderNumber);

	function ShowOrderBanner($orderNumber) {
	
		$.ajax({
			  type: 'GET',
			  url: 'service/order-banner.service.php',
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


	$( "#dialog-orderItem" ).dialog({
	  autoOpen: false,
	  height: 750,
	  width: 950,
	  modal: true,
		Cancel: function() {
				  $( this ).dialog( "close" );
		  }				
	});

	// Delegates
	$(document).on('click', 'input#createOrderItem', function(event) {
		$( "#dialog-orderItem").dialog( "open" );
	});

});


/** End of order.js **/