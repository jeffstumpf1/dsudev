// order.js
	
/******************** Order Information *************************/
var $oi;
var $mp;
var $kit; 
var $fs;
var $rs;
 $(function() {	
 
 	// Initialize
	$.urlParam = function(name){
		var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
		if (!results)
		{ 
			return 0; 
		}
		return results[1] || 0;
	}

	// Init form on load
	var $orderNumber = $.urlParam('order_number');
	var $taxRate = $.urlParam('tax_rate');
	var $status = $.urlParam('status');
	if($status) {
		$('#order_status').val($status);
		UpdateOrderItemsBanner( $orderNumber );
		ShowOrderBanner( $orderNumber, $taxRate, $status );  // off the banner itself
		ShowNotesBanner($orderNumber);
		ShowPrintBanner($orderNumber, $taxRate);
	} 

    $(document).on('click','#order_date', function(event) {
    	$(this).datepicker({dateFormat: "mm-dd-yyyy"}).focus();
    });
    
 	function ShowPrintBanner($orderNumber, $taxRate) {
		$.ajax({
			  type: 'GET',
			  url: 'service/print-invoice-banner.service.php',
			  data: {order_number: $orderNumber, tax_rate: $taxRate },
			  beforeSend:function(){
				// load a temporary image in a div
			  },
			  success:function(data){
				$('#print-banner').html(data);
			  },
			  error:function(){
				$('#print-banner').html('<p class="error"><strong>Oops!</strong></p>');
			  }
			});
 	}

	function ShowOrderBanner($orderNumber, $taxRate, $status) {
	
		$.ajax({
			  type: 'GET',
			  url: 'service/order-banner.service.php',
			  data: {status: $status, order_number: $orderNumber, tax_rate: $taxRate },
			  beforeSend:function(){
				// load a temporary image in a div
			  },
			  success:function(data){
				$('#order-banner').html(data);
/*				if($('#order_status').val()=='') {
					$('#createOrderItem').attr('disabled','disabled');
					$('#updateOrder').attr('disabled','disabled');
				} else {
					$('#createOrderItem').removeAttr('disabled');
					$('#updateOrder').removeAttr('disabled');
				} */
			  },
			  error:function(){
				$('#order-banner').html('<p class="error"><strong>Oops!</strong></p>');
			  }
			});
	}


	function ShowNotesBanner($orderNumber) {
	
		$.ajax({
			  type: 'GET',
			  url: 'service/customer-notes-banner.service.php',
			  data: { order_number: $orderNumber },
			  beforeSend:function(){
				// load a temporary image in a div
			  },
			  success:function(data){
				$('#notes-banner').html(data);
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

	$(document).on('click', '.printTickets', function(event) {
		event.preventDefault();
		$id = $(this).parent().attr('oid');
		$title = "Print Pick Tickets";
		$( "#dialog-print-tickets" ).dialog({
		  resizable: false,
		  height:200,
		  modal: true,
		  title: $title,
		  buttons: {
			"Print Ticket": function() {
			  $( this ).dialog( "close" );
			  PrintPickTickets($id);
			},
			Cancel: function() {
			  $( this ).dialog( "close" );
			}
		  }
		});
		
	});
	
	$(document).on('click', '.printTicket', function(event) {
		event.preventDefault();
		$id = $(this).parent().attr('oid');
		$title = "Print Pick Ticket";
		$( "#dialog-print" ).dialog({
		  resizable: false,
		  height:200,
		  modal: true,
		  title: $title,
		  buttons: {
			"Print Ticket": function() {
			  $( this ).dialog( "close" );
			  PrintPickTicket($id);
			},
			Cancel: function() {
			  $( this ).dialog( "close" );
			}
		  }
		});
		
	});

	function PrintPickTicket($ID) {
	$.ajax({ 
		  type: 'POST',
		  url: 'labelprint/print-ticket.service.php',
		  data: { id: $id },
		  beforeSend:function(){
			// load a temporary image in a div
		  },
		  success:function(data){
		  	//alert( data );
			window.open(data,'Pick Tickets','_BLANK','height=400,location=no,width=350','replace=true');
		  },
		  error:function(){
			alert('Error: Tickets Not Printed');
		  }
		});
	}

	function PrintPickTickets($order_number) {
	$.ajax({ 
		  type: 'POST',
		  url: 'labelprint/print-tickets.service.php',
		  data: { order_number: $order_number },
		  beforeSend:function(){
			// load a temporary image in a div
		  },
		  success:function(data){
		  	//alert( data );
			window.open(data,'Pick Ticket','_BLANK','height=400,location=no,width=350','replace=true');
		  },
		  error:function(){
			alert('Error: Tickets Not Printed');
		  }
		});
	}

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
		$("#h_status").val( "A" );
	});
	
	
	// Called from customer banner
	$(document).on('click', 'input#saveOrder', function(event) {
		$('#order_status').val('NEW');
		$("#customer_number").val( $('#customer-number').val() );
		$("#order_date").val( $('input#orderDate').val() );
		$("#tax_rate").val( $('#customer-taxable').val() );
		$customerNumber = $('#customer-number').val();
		$orderDate = $("#order_date").val();
		$taxRate= $("#tax_rate").val();
		NewOrder($customerNumber, $taxRate, "NEW");

	});
	
	
	// Called from Invoice Banner
	$(document).on('click', 'input#updateOrder', function(event) {
		$("#order_number").val( $('#orderNumber').text() );
		$("#customer_number").val( $('#customer-number').val() );
		$('#order_status').val('OPEN');
		$("#tax_rate").val( $('#customer-taxable').val() );
		//UpdateOrder();
		$orderNumber=$('#orderNumber').text();
		$customerNumber = $('#customer-number').val();
		$customerPO = $("#customer_po").val();
		$orderDate = $("#order_date").val();
		$orderShipping = $("#order_shipping").val();
		$tax_rate= $("#tax_rate").val();
		$paymentTerms=$("#payment_terms").val();
		SaveOrder($orderNumber, $customerNumber, $customerPO, $orderDate, $orderShipping, $tax_rate,"OPEN", $paymentTerms);
	});
	
	
	// save customer notes
	$(document).on('click', 'input#saveNotes', function(event) {
		$notes = $("#specialInstructions").val();
		$order = $("td#orderNumber").text();
		
		$.ajax({ 
		  type: 'POST',
		  url: 'service/save-notes.service.php',
		  data: { order_number: $order, special_instructions: $notes },
		  beforeSend:function(){
			// load a temporary image in a div
		  },
		  success:function(data){
		  	// msg to say updated
		  },
		  error:function(){
			alert('Error: Order notes failed');
		  }
		});

	});
	
	
	function SaveOrder( $orderNumber, $customerNumber, $customerPO, $orderDate, $orderShipping, $tax_rate, $status, $paymentTerms) {
		
		$.ajax({
			  type: 'GET',
			  url: 'service/save-order.service.php',
			  data: { order_number: $orderNumber, cust_number: $customerNumber, po: $customerPO, order_date: $orderDate, freight: $orderShipping, tax_rate: $tax_rate, status: $status, payment_terms: $paymentTerms},
			  beforeSend:function(){
				// load a temporary image in a div
			  },
			  success:function(data){
			  	if($("#order_status").val()=="NEW") {
			  		$("#saveOrder").remove();
					$('#order_number').val($.trim(data));
					$('#orderNumber').text($.trim(data));
					//alert("Order Saved");
					$('#order_status').val('OPEN');
					ShowOrderBanner( $.trim(data), $('#customer-taxable').val(), $status ); // off the banner itself
					ShowNotesBanner( $.trim(data) );
					$("#dialog-orderItem").dialog("open");
			  		//$('#h_status').val( 'A' );

			  	}
				ShowOrderBanner( $orderNumber, $tax_rate, $status ); 
			  	alert('Order Updated');
				//window.location.replace("order-list.php");
			  	
			  },
			  error:function(){
				alert ("Could not save order ");
			  }
			});
	}
	
		function NewOrder( $customerNumber, $tax_rate, $status) {
		
		$.ajax({
			  type: 'GET',
			  url: 'service/save-order.service.php',
			  data: { cust_number: $customerNumber, tax_rate: $tax_rate, status: $status },
			  beforeSend:function(){
				// load a temporary image in a div
			  },
			  success:function(data){
				$("#saveOrder").remove();
				$('#order_number').val($.trim(data));
				$('#orderNumber').text($.trim(data));
				//alert("Order Saved");
				$('#order_status').val('OPEN');
				ShowOrderBanner( $.trim(data), $('#customer-taxable').val(), "OPEN" ); // off the banner itself
				ShowNotesBanner( $.trim(data) );
				$("#dialog-orderItem").dialog("open");
				//$('#h_status').val( 'A' );			  	
			  },
			  error:function(){
				alert ("Could not save order ");
			  }
			});
	}

	
	// Save the Item 
	$(document).on('click', 'input#line-createItem', function(event) {
		// have to enable fields
		$('#discount-price').removeAttr('disabled');
		$('#unit-price').removeAttr('disabled');
		$('#total').removeAttr('disabled');
		$("#h_order").val( $('#orderNumber').text() );

		$.ajax({
			  type: 'POST',
			  url: 'service/save-orderItem.service.php',
			  data: $('#order-form').serialize(), 
			  beforeSend:function(){
				// load a temporary image in a div
			  },
			  success:function(data){
			  	$( "#dialog-orderItem").dialog( "close" );
			  	UpdateOrderItemsBanner( $('#orderNumber').text() );
			  	ShowOrderBanner( $('#orderNumber').text(), $('#customer-taxable').val() ,"OPEN" );  // off the banner itself
			  	//$('#specialInstructions').val( $('#special_instructions').val() );
			  	alert('Item Saved!');
			  },
			  error:function(){
				alert ("Could not save order item ");
			  }
			});

	});



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
			  	ShowOrderBanner( $('#orderNumber').text(), $('#customer-taxable').val(), "OPEN" );  // off the banner itself
		  },
		  error:function(){
			alert('Error: Order item not deleted');
		  }
		});
	}



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
	
	
	
	
	
	
	$(document).on('click', '.actionCalculator', function(event) {
		event.preventDefault();
		$part_number = $(this).parent().attr('pn');
		$ct = $(this).parent().attr('ct');
		$orderItem = $(this).parent().attr('oid');
		$title = 'Deleting Order ('+ $orderNumber + ')';
		//$("#dialog-orderItem").dialog({height:400});
		$("#dialog-orderItem").dialog("open");
		LoadOrderItem($orderItem);
		
	});

	
	


	function handle_OrderItem(json) {
		$oi = new OrderItem(json);
		$('#partNumber').val( $oi.part_number );
		$('#discount').val ( $oi.discount );
		//$('#stockLevel').val( $mp.stock_level );
		$('#description').val( $oi.description );
		$('#application').val( $oi.application );
		//$('#frontSprocket').val( $oi.frontSprocket_part_number );
		//$('#rearSprocket').val( $oi.rearSprocket_part_number );
		//$('#chainLength').val( $oi.chain_length );
		$('#msrp').val( $oi.msrp );
		$('#qty').val( $oi.qty );
		$('#discount-price').val( $oi.discount_price );
		$('#unit-price').val( $oi.unit_price );
		$('#total').val( $oi.total );
		$('#h_status').val('E');
		$('#h_order_item_id').val( $oi.order_item_id );
		$('#h_pitch').val( $oi.pitch_id );
		$('#h_cat').val( $oi.category_id );
		
		if($oi.category_id == 'KT') {
			$('#entryKit').show();
			LoadChainKitInfo($oi.part_number);
		}
	}


	function LoadChainChart($p, $l, $partNumber) {
		$.ajax({
			  type: 'GET',
			  async: false,
			  url: 'service/select-chain-chart.service.php',
			  data: { pitch: $p ,chainLength: $l, part: $partNumber},
			  beforeSend:function(){
				// load a temporary image in a div
			  },
			  success:function(data){
				$('#chainChart').html(data);
				$('#chainChartTable input').iCheck({		// icheck style applied
					checkboxClass: 'icheckbox_square',
					radioClass: 'iradio_square',
				});
				// We need to have a value in chain part item

			  },
			  error:function(){
				$('#chainChart').html('<p class="error"><strong>Oops!</strong></p>');
			  }
		});
    }

	function LoadChainKitInfo($part_number) {
		  $.ajax({
			  	type: 'GET',
			  	async: false,
			  	dataType: "json",
			  	url: 'service/select-chainkit.service.php',
		  		data: { part_number : $part_number },
		  success: handle_LoadChainKitInfo
		});
		
	}

	function handle_LoadChainKitInfo(json) {
		$kit = new ChainKit(json);
		$('#frontSprocket').val( $kit.frontSprocket_part_number );
		$('#rearSprocket').val( $kit.rearSprocket_part_number );
		$('#chainLength').val( $kit.chain_length );
		$('#partNumber').val( $kit.part_number );
		LoadChainChart( $oi.pitch_id, $kit.chain_length, $kit.chain_part_number);
		$('#chainChart').show();			
	}


	function LoadOrderItem($id) {

		$.ajax({
		  url: "service/json-order-items.service.php",
		  dataType: "json",
		  async: false,
		  data: { order_item_id : $id },
		  success: handle_OrderItem
		});
		
	}

	
	function OrderItem(obj) {
		this.order_item_id = obj.order_item_id;
		this.order_number = obj.order_number;
		this.discount = obj.discount;
		this.category_id = obj.category_id;
		this.part_number = obj.part_number;
		this.frontSprocket_part_number = obj.frontSprocket_part_number;
		this.rearSprocket_part_number = obj.rearSprocket_part_number;
		this.description = obj.description;
		this.application = obj.application;
		this.chain_length = obj.chain_length;
		this.msrp = obj.msrp;
		this.qty = obj.qty;
		this.discount_price = obj.discount_price;
		this.unit_price = obj.unit_price;
		this.total = obj.total;
		this.pitch_id = obj.pitch_id;
	}
		
		
	function ChainKit(obj) {
		this.chain_kit_id = obj.chain_kit_id;
		this.part_number = obj.part_number;
		this.product_brand_id = obj.product_brand_id;
		this.rearSprocket_part_number = obj.rearSprocket_part_number;
		this.frontSprocket_part_number = obj.frontSprocket_part_number;
		this.chain_length = obj.chain_length;
		this.chain_part_number = obj.chain_part_number;
		this.ch_price = obj.ch_price;
		this.fs_price = obj.fs_price;
		this.rs_price = obj.rs_price;
		this.clip_id = obj.clip_id;
		
		$('#h_fs').val( GetMSRPFromSTRING(this.fs_price) );
		$('#h_rs').val( GetMSRPFromSTRING(this.rs_price) );
		$('#h_ch').val( GetMSRPFromSTRING(this.ch_price) );
	}


	function GetMSRPFromSTRING($s) {
		var prices = []; 
		var part = $s.split('|');
		if(part[1]!="") {
			var prices = part[1].split(':');	
			return msrp= prices[0];
			var dealer = prices[1];
			var imp = prices[2];
		}
	}
		
		


});

/** End of order.js **/