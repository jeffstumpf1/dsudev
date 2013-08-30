// order.js
	
/******************** Order Information *************************/

 $(function() {	
 
 	// Initialize
 	$orderNumber=$('#order_number').val();
 	
 	ShowOrderBanner($orderNumber);

	function ShowOrderBanner($orderNumber, $taxRate) {
	
		$.ajax({
			  type: 'GET',
			  url: 'service/order-banner.service.php',
			  data: { order_number: $orderNumber, tax_rate: $taxRate },
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


	$(document).on('click', '.actionOrder', function(event) {
		event.preventDefault();
		$part = $(this).parent().attr('pn');
		$ct = $(this).parent().attr('ct');
		$orderNumber = $(this).parent().attr('oid');
		$title = 'Deleting Order ('+ $orderNumber + ')';
		
		$( "#dialog-confirm" ).dialog({
		  resizable: false,
		  height:200,
		  modal: true,
		  title: $title,
		  buttons: {
			"Delete": function() {
			  $( this ).dialog( "close" );
			  DeleteOrderSelected($orderNumber);
			},
			Cancel: function() {
			  $( this ).dialog( "close" );
			}
		  }
		});
		
	});


	$(document).on('click', '.actionStatus', function(event) {
		event.preventDefault();
		$part = $(this).parent().attr('pn');
		$ct = $(this).parent().attr('ct');
		$title = 'Deleting Part ('+ $part + ')';
		$id = $(this).parent().attr('oid');
		$( "#dialog-confirm" ).dialog({
		  resizable: false,
		  height:200,
		  modal: true,
		  title: $title,
		  buttons: {
			"Delete": function() {
			  $( this ).dialog( "close" );
			  DeleteOrderItemSelected($id);
			},
			Cancel: function() {
			  $( this ).dialog( "close" );
			}
		  }
		});
		
	});


	function DeleteOrderSelected($orderNumber) {
	$.ajax({ 
		  type: 'GET',
		  url: 'service/delete-order.service.php',
		  data: { order_number: $orderNumber },
		  beforeSend:function(){
			// load a temporary image in a div
		  },
		  success:function(data){
			location.reload();
		  },
		  error:function(){
			alert('Error: Order item not deleted');
		  }
		});
	}


	function DeleteOrderItemSelected($id) {
	$.ajax({ 
		  type: 'GET',
		  url: 'service/delete-order-item.service.php',
		  data: { order_id: $id },
		  beforeSend:function(){
			// load a temporary image in a div
		  },
		  success:function(data){
			  	UpdateOrderItemsBanner( $('#orderNumber').text() );
			  	ShowOrderBanner( $('#orderNumber').text(), $('#customer-taxable').val() );  // off the banner itself
		  },
		  error:function(){
			alert('Error: Order item not deleted');
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
		  },
		open: function(event, ui) {
			$("#h_order").val( $('#orderNumber').text() );   // pulled from order banner
			$('#partNumber').val('');
			$('#discount').val('');
			$('#h_cat').val('');
			$('#frontSprocket').val('');
			$('#rearSprocket').val('');
			$('#description').val('');
			$('#application').val('');
			$('#chainLength').val('');
			$('#msrp').val('0.00');
			$('#qty').val('1');
			$('#discount-price').val('0.00');
			$('#unit-price').val('0.00');
			$('total').val('0.00');
			$('#entryKit').hide();
			$('#entryChain').hide();
			$('#entrySprocket').hide();
			$('#chainChart').hide();
	  }	
				
	});

	// Delegates
	$(document).on('click', 'input#createOrderItem', function(event) {
		$("#dialog-orderItem").dialog("open");
	});
	
	
	// Called from customer banner
	$(document).on('click', 'input#saveOrder', function(event) {
		$('#order_status').val('NEW');
		$("#customer_number").val( $('#customer-number').val() );
		$("#order_date").val( $('input#orderDate').val() );
		UpdateOrder(true);
	});
	
	// Called from Invoice Banner
	$(document).on('click', 'input#updateOrder', function(event) {
		$("#order_number").val( $('#orderNumber').text() );
		$("#customer_number").val( $('#customer-number').val() );
		$("#customer_po").val( $('input#orderPO').val() );
		$("#order_date").val( $('input#orderDate').val() );
		$("#order_tax").val( parseFloat($('#tax').text()) );
		$("#order_shipping").val( parseFloat($('#freightCost').val()) );
		$("#order_total").val( parseFloat($('#totalCost').text()) );

		UpdateOrder();
	});
	
	
	function UpdateOrder( $showScreen) {
		
		$.ajax({
			  type: 'POST',
			  url: 'service/save-order.service.php',
			  data: $('#order').serialize(), 
			  beforeSend:function(){
				// load a temporary image in a div
			  },
			  success:function(data){
			  	$('form#order #order_number').val($.trim(data));
			  	$('#orderNumber').text($.trim(data));
			  	//alert("Order Saved");
			  	$('input#saveOrder').remove();
			  	$('input#createOrderItem').removeAttr('disabled');
			  	$('input#updateOrder').removeAttr('disabled');
			  	$('#order_status').val('OPEN');
			  	if($showScreen) {
			  		$("#dialog-orderItem").dialog("open");
			  	} else {
			  		ShowOrderBanner( $('#orderNumber').text(), $('#customer-taxable').val() );  // off the banner itself
			  		alert('Order Updated');
			  	}
			  },
			  error:function(){
				alert ("Could not save order ". $id);
			  }
			});
	}
	
	
	// Save the Item 
	$(document).on('click', 'input#line-createItem', function(event) {
		// have to enable fields
		$('#discount-price').removeAttr('disabled');
		$('#unit-price').removeAttr('disabled');
		$('#total').removeAttr('disabled');

		$.ajax({
			  type: 'POST',
			  url: 'service/save-orderItem.service.php',
			  data: $('#order-form').serialize(), 
			  beforeSend:function(){
				// load a temporary image in a div
			  },
			  success:function(data){
			  	alert('Item Saved!');
			  	$( "#dialog-orderItem").dialog( "close" );
			  	UpdateOrderItemsBanner( $('#orderNumber').text() );
			  	ShowOrderBanner( $('#orderNumber').text(), $('#customer-taxable').val() );  // off the banner itself
			  },
			  error:function(){
				alert ("Could not save order item ");
			  }
			});

	});



	function UpdateOrderItemsBanner($order_number) {

		$.ajax({
			  type: 'GET',
			  url: 'service/select-order-items.service.php', 
			  data: {order_number : $order_number},
			  beforeSend:function(){
				// load a temporary image in a div
			  },
			  success:function(data){
				$('#orderItemsBanner').html(data);
			  },
			  error:function(){
				alert ("Could not get Order Items ");
			  }
		});

	}

});

/** End of order.js **/