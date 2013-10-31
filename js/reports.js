// reports.js

$(function() {

	$('.ui-widget').css('font-size','1em');
	$('#report-salesbyCustomerDate').hide();
	$('#customerDBA').val('');
	
	



	$(document).on('click', '#button-salesbyCustomerDate', function(event) {
		$from = $('#from').val();
		$to = $('#to').val();
		$customer_number = $('#customerNumber').val();
		GetSalesByCustomerDate($customer_number, $from, $to)
	
	});

	$(document).on('click', '#button-allSales', function(event) {
		$from = $('#fromAll').val();
		$to = $('#toAll').val();	
		
		if(!$from) $from="01-01-2013";
		if(!$to) $to="12-30-2013";	
		GetAllSales( $from, $to );
	
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
			$(this).val(ui.item.id);
			$('#customerNumber').val(ui.item.value);
			GetSalesByCustomer( $('#customerNumber').val() );
			$('#report-salesbyCustomerDate').show();
		}
		
		});
		
	});
	
	
	function GetSalesByCustomer($customer_number) {

		$.ajax({ 
		  type: 'POST',
		  url: 'service/report-GetSalesByCustomer.service.php',
		  data: { customer_number: $customer_number},
		  beforeSend:function(){
			// load a temporary image in a div
		  },
		  success:function(data){
		  		$('#salesbyCustomer').html(data);
		  		$('#report-salesbyCustomerDate').width( $('#report-salesbyCustomer').width() );

		  },
		  error:function(){
			alert('Error: No Customer Sales, failed');
		  }
		});


	}

	
	function GetSalesByCustomerDate($customer_number, $from, $to) {

		$.ajax({ 
		  type: 'POST',
		  url: 'service/report-GetSalesByCustomer.service.php',
		  data: { customer_number: $customer_number, from: $from, to: $to},
		  beforeSend:function(){
			// load a temporary image in a div
		  },
		  success:function(data){
		  		$('#salesbyCustomerDate').html(data);
		  },
		  error:function(){
			alert('Error: No Customer Sales, failed');
		  }
		});


	}


	function GetAllSales( $from, $to ) {

		$.ajax({ 
		  type: 'POST',
		  url: 'service/report-GetSalesByCustomer.service.php',
		  data: { from: $from, to: $to},
		  beforeSend:function(){
			// load a temporary image in a div
		  },
		  success:function(data){
		  		$('#allSales').html(data);
		  },
		  error:function(){
			alert('Error: No Customer Sales, failed');
		  }
		});


	}


/**************************************************************/
  	$( "#from" ).datepicker({
  		defaultDate: "+1w",
  		changeMonth: true,
  		numberOfMonths: 3,
  		onClose: function( selectedDate ) {
  			$( "#to" ).datepicker( "option", "minDate", selectedDate );
  		}  
  	});
  	$( "#from" ).datepicker("option", "dateFormat", "mm-dd-yy");
  	
	$( "#to" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 3,
		onClose: function( selectedDate ) {
		$( "#from" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
	$( "#to" ).datepicker("option", "dateFormat", "mm-dd-yy");
	
	
	
	$( "#fromAll" ).datepicker({
  		defaultDate: "+1w",
  		changeMonth: true,
  		numberOfMonths: 3,
  		onClose: function( selectedDate ) {
  			$( "#toAll" ).datepicker( "option", "minDate", selectedDate );
  		}  
  	});
  	$( "#fromAll" ).datepicker("option", "dateFormat", "mm-dd-yy");
  	
	$( "#toAll" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 3,
		onClose: function( selectedDate ) {
		$( "#fromAll" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
	$( "#toAll" ).datepicker("option", "dateFormat", "mm-dd-yy");
});

