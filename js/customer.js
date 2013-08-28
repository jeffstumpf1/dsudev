// customer.js
	
/******************** CUSTOMER Information *************************/

 $(function() {	
 
 	// Initialize
	$('#log').show();
	$('#chainChart').hide();
	//$('#lineitem-banner').hide();

	function ShowCustomerBanner($custNumber) {
	
		$.ajax({
			  type: 'GET',
			  url: 'service/customer-banner.service.php',
			  data: { customer_number: $custNumber },
			  beforeSend:function(){
				// load a temporary image in a div
			  },
			  success:function(data){
				$('#customer-banner').html(data);
				$('.fsCustomer').height($('.fsOrderInfo').height());

			  },
			  error:function(){
				$('#customer-banner').html('<p class="error"><strong>Oops!</strong></p>');
			  }
			});
			
	}

    function SaveCustomer($id) {
    	
		$.ajax({
			  type: 'POST',
			  url: 'service/save-customer.service.php',
			  data: $('#formCustomer').serialize(), customer_number: $id,
			  beforeSend:function(){
				// load a temporary image in a div
			  },
			  success:function(data){
			  },
			  error:function(){
				alert ("Could not save customer ". $id);
			  }
			});
			
    }


    function LoadCustomer($CustNumber) {
    
		$.ajax({
			  type: 'GET',
			  url: 'service/select-customer.service.php',
			  data: { customer_number: $CustNumber },
			  beforeSend:function(){
				// load a temporary image in a div
			  },
			  success:function(data){
			  	//alert(data);
				$('#customer').html(data);
				$('#dialog-customer #submit').remove();
			  },
			  error:function(){
				$('#customer').html('<p class="error"><strong>Oops!</strong></p>');
			  }
			});
    }
    
/*** Delegates ****/    

	// Save Customer Handler
	$(document).on('click', '#submitCustomer', function(event) {
		event.preventDefault();
		//alert('*');
		SaveCustomer( $('#cust_id').val());	// hidden field
		$('#dialog-customer').dialog('close');
		ShowCustomerBanner ( $('#cust_number').val() );
	});
    
    /* 
    	Update Customer Dialog
    */
    $(document).on('click','#editCustomer', function(event) {
    
		$('#dialog-customer').dialog( "open","title", "Customer Information" );	
		LoadCustomer($('#cust_number').val());	
		$('#cust_id').val( $('#customerID').val() );
    });
    
    
    
	/*
	  Autocomplete box for customers
	*/
	$(document).on('focus.autocomplete','#customerDBA', function(event) {
		$(this).autocomplete({ 
		  source: function(request, response) {
			$.ajax({
			  url: "service/auto-customer.service.php",
				   dataType: "json",
			  data: {
				term : request.term
			  },
			  success: function(data) {
			  	//alert(data);
				response(data);
			  }
			});
		  },
		minLength: 2,
		select: function( event, ui ) {
			event.preventDefault();
			$('#customerDBA').val(ui.item.label);
			$('#cust_number').val(ui.item.value);
			$('#lineitem-banner').show();
			ShowCustomerBanner(ui.item.value);			// need to build the banner
			$('#createOrderItem').removeAttr('disabled');  // order banner form
			}
		
		});
		
	});
	
	
 /******** Dialog's *********/
	$( "#dialog-customer" ).dialog({
	  autoOpen: false,
	  height: 500,
	  width: 650,
	  modal: true,
		Cancel: function() {
				  $( this ).dialog( "close" );
		  }				
	});
    
});  
/** End of customer.js **/