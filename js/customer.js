// customer.js
	
/******************** CUSTOMER Information *************************/

 $(function() {	
 
 	// Initialize
 	$('#createOrderItem').attr('disabled');  // order banner form
	$('#saveOrder').attr('disabled');  // order banner form

	// Get Values passed in on edits
	$.urlParam = function(name){
		var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
		if (!results)
		{ 
			return 0; 
		}
		return results[1] || 0;
	}

	// Init form on load
	var $custNumber = $.urlParam('customer_number');
	var $status = $.urlParam('status');
	if($custNumber) {
		$('#cust_number').val($custNumber);
	}

	$(document).on('click', '#copyAddress', function(event) {
		$("#billingAddress").val( $("#address").val() );
		$("#billingCity").val( $("#city").val() );
		$("#billingState").val( $("#state").val() );
		$("#billingZip").val( $("#zip").val() );
	});
		
	
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
				if($status) { $('#saveOrder').hide() }
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
		if( !$("#formCustomer").validationEngine('validate') ) {
			//errors
			
		} else {
			// validates
			SaveCustomer( $('#cust_id').val());	// hidden field
			$('#dialog-customer').dialog('close');
			ShowCustomerBanner ( $('#cust_number').val() );
		}
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
			ShowCustomerBanner(ui.item.value);			// need to build the banner
			}
		
		});
		
	});


	$(document).on('click', '.actionDeleteCustomer', function(event) {
		event.preventDefault();
		$ct = $(this).parent().attr('ct');
		$title = 'Deleting Customer ('+ $ct + ')';
		$id = $(this).parent().attr('oid');
		$( "#dialog-confirm" ).dialog({
		  resizable: false,
		  height:200,
		  modal: true,
		  title: $title,
		  buttons: {
			"Delete": function() {
			  $( this ).dialog( "close" );
			  DeleteCustomerSelected($id);
			},
			Cancel: function() {
			  $( this ).dialog( "close" );
			}
		  }
		});
		
	});

	$(document).on('click', '.actionEditCustomer', function(event) {
		event.preventDefault();
		$ct = $(this).parent().attr('ct');
		$title = 'Editing Customer ('+$ct + ')';
		$id = $(this).parent().attr('oid');
		$('#dialog-customer').dialog( "open","title", "Customer Information" );	
		LoadCustomer($ct);	
		$('#cust_id').val( $id );
	});

	function DeleteCustomerSelected($id) {
	$.ajax({ 
		  type: 'GET',
		  url: 'service/delete-customer.service.php',
		  data: { customer_id: $id },
		  beforeSend:function(){
			// load a temporary image in a div
		  },
		  success:function(data){
		  	alert("Customer Deleted");
			location.reload();
		  },
		  error:function(){
			alert('Error: Customer not deleted');
		  }
		});
	}
	
	
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
	
	
	

var $custNumber = $.urlParam('customer_number');
var $status = $.urlParam('status');
if($custNumber) { ShowCustomerBanner($custNumber)}
if($status) { $('#saveOrder').hide() }
    
});  


	

/** End of customer.js **/