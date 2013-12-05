 $(function() {	
 
 	// Initialize!
 	$('#formChainKit').show();
 	$('#KitContent').show();
		
 	// Setup the form 

		if ( $('#recMode').val() != "E" ) {
			$( "#pitch" ).val(0);
			$( "#chainLength").attr('disabled','disabled').val(1);
			$('#fsPartNumber').attr('disabled','disabled').val('');
			$('#rsPartNumber').attr('disabled','disabled').val('');
			$('#crPartNumber').attr('disabled','disabled').val('');
			$('#masterPartNumber').attr('style','width:35em;')
			$('#stockLevel').val(0);
			ResetForm();
		} else {
			if( $('#fs').val() != '') {UpdatePriceInChart( $('#fs').val(), 'FS');}
			if( $('#rs').val() != '') {UpdatePriceInChart( $('#rs').val(), 'RS');}
			if( $('#ch').val() != '') {UpdatePriceInChart( $('#ch').val(), 'CH');}
			if( $('#cr').val() != '0') {
				UpdatePriceInChart( $('#cr').val(), 'CR');
			} else {
				$('#crMSRP').text(0);
				$('#crDealer').text(0);
				$('#crImport').text(0);
			}
			LoadChainChart( $('#pitch').val(), $('#chainLength').val(), $('#chainPartNumber').val() );    
		}

	
	$('#log').show();
	// Validations
	$("#formChainKit").validationEngine('attach');
	$("#formChainKit").validationEngine('init', {promptPosition : "centerRight", scroll: false});

 	// stops enter key submit the form
 	$('input').keypress(function(event){
        var enterOkClass =  $(this).attr('class');
        if (event.which == 13 && enterOkClass != 'enterSubmit') {
            event.preventDefault();
            return false;   
        } 
    });
 
 	// Process Form stuff here
 	$('#submit').click(function(event){
 		// validation code goes here
		if( $("#formChainKit").validationEngine('validate') ) {
			// validates
			$("#formChainKit").submit(function(){
  				$.blockUI({ message: '<h2><img src="images/16x16-cc.gif" /> Just a moment...</h2>' });
			}); 		
		}
 		
 	});
 	
	$('#fsPartNumber').keypress(function(event){
	  	if($(this).val()==0 && event.which == 13) {
		 	RemovePartTotal('FS');
		 	$('#fs').val('');
		}
	  });
	$('#rsPartNumber').keypress(function(event){
	  	if($(this).val()==0 && event.which == 13) {
		 	RemovePartTotal('RS');
		 	$('#rs').val('');
		}
	  }); 	
	$('#chPartNumber').keypress(function(event){
	  	if($(this).val()==0 && event.which == 13) {
		 	RemovePartTotal('CH');
		 	$('#ch').val('');
		}
	  });
	$('#crPartNumber').keypress(function(event){
	  	if($(this).val()==0 && event.which == 13) {
		 	RemovePartTotal('CR');
		 	$('#cr').val('');
		}
	  });

	function RemovePartTotal(partType) {
		switch (partType) {
			case 'FS':	
				$('#fsMSRP').text(0);
				$('#fsDealer').text(0);
				$('#fsImport').text(0);	
				break;
			case 'RS':
				$('#rsMSRP').text(0);
				$('#rsDealer').text(0);
				$('#rsImport').text(0);	
				break;
			case 'CH':
				$('#clMSRP').text(0);
				$('#clDealer').text(0);
				$('#clImport').text(0);	
				break;
			case 'CR':
				$('#crMSRP').text(0);
				$('#crDealer').text(0);
				$('#crImport').text(0);	
				break;
		}
		UpdateTotalLines();
	}


 	function ResetForm(){
		$('#fs').val('');
		$('#rs').val('');
		$('#ch').val('');
		$('#cr').val('');
		$('#fsMSRP').text('0');
		$('#fsDealer').text('0');
		$('#fsImport').text('0');
		$('#rsMSRP').text('0');
		$('#rsDealer').text('0');
		$('#rsImport').text('0');
		$('#clMSRP').text('0');
		$('#clDealer').text('0');
		$('#clImport').text('0');		
		$('#totalMSRP').text('0');
		$('#totalDealer').text('0');
		$('#totalImport').text('0');
		UpdateTotalLines();
 	}
 
 	// Attempt at Getting binding to work after 
	// Dynamically generated code from ajax call
	 $('#chainChart').on('ifClicked', '#chainChartTable input', function(event) {
	 	var part = $(this).val();
	 	var desc = $(this).attr('di');
	 	var oldDesc = $('#notes').text();
	 	var idx = oldDesc.indexOf('W/') +2 ;
	 	$('#notes').text( oldDesc.substr(0,idx) + desc );
	 	
	 	$('#ch').val( part );						// saves part in form
		partNumber = UpdatePriceInChart($(this).val(), 'CH');	
		$('#chainPartNumber').val( partNumber+'-'+ $(this).attr('alt'));
			
		$masterPartNumber = $('#masterPartNumber').val();
		if( $masterPartNumber.indexOf('-') != -1) {   // xxxxxxxx-9
			hyph = $masterPartNumber.indexOf('-');
			$nbr = $(this).attr('alt');
			$masterPartNumber = $masterPartNumber.substr(0, hyph)  +'-'+ $nbr;
		} else {
			$chainSelected = partNumber;
			hyph = $chainSelected.indexOf('-');
			$nbr = $(this).attr('alt');
			//$nbr = $chainSelected.substr(hyph, $chainSelected.length - hyph);
			$masterPartNumber = $masterPartNumber + '-'+ $nbr;
			//$masterPartNumber = $masterPartNumber.substr(0, hyph)  +'-'+ $nbr;
		}				
		$('#masterPartNumber').val( $masterPartNumber );  // main part number
		$('#masterPartNumberSpan').text( $masterPartNumber );  // main part number
	 });
	 
	 
	 
	$('#fsPartNumber').autocomplete({
    // source: function() { return "GetState.php?country=" + $('#Country').val();},
      source: function(request, response) {
        $.ajax({
          url: "service/auto-sprocket.service.php",
               dataType: "json",
          data: {
            term : request.term,
            pitch : $('#pitch').val(),
            cat: 'FS'
          },
          success: function(data) {
            
            response(data);
          }
        });
      },
    minLength: 2,
    select: function( event, ui ) {
		log( ui.item ?
		"Selected: " + ui.item.value + " aka " + ui.item.id :
		"Nothing selected, input was " + this.value );
		$('#fs').val(ui.item.id);
		// Update the price chart
		part=UpdatePriceInChart(ui.item.id, 'FS');  		// brings back part number in string
		}
  	});
	
	$('#rsPartNumber').autocomplete({
    // source: function() { return "GetState.php?country=" + $('#Country').val();},
      source: function(request, response) {
        $.ajax({
          url: "service/auto-sprocket.service.php",
               dataType: "json",
          data: {
            term : request.term,
            pitch : $('#pitch').val(),
            cat: 'RS'
          },
          success: function(data) {
          	
            response(data);
          }
        });
      },
    minLength: 2,
    select: function( event, ui ) {
		log( ui.item ?
		"Selected: " + ui.item.value + " aka " + ui.item.id :
		"Nothing selected, input was " + this.value );
		$('#rs').val(ui.item.id);
		part=UpdatePriceInChart(ui.item.id, 'RS');			// brings back part number in string
		}
  	});
  	

	$('#crPartNumber').autocomplete({
    // source: function() { return "GetState.php?country=" + $('#Country').val();},
      source: function(request, response) {
        $.ajax({
          url: "service/auto-cr.service.php",
               dataType: "json",
          data: {
            term : request.term,
          },
          success: function(data) {
          	
            response(data);
          }
        });
      },
    minLength: 2,
    select: function( event, ui ) {
		log( ui.item ?
		"Selected: " + ui.item.value + " aka " + ui.item.id :
		"Nothing selected, input was " + this.value );
		$('#cr').val(ui.item.id);
		part=UpdatePriceInChart(ui.item.id, 'CR');			// brings back part number in string
		}
  	});
	 
	 

	  
	// Need a Chain Pitch before anyother event 
	$( "#pitch" ).change(function(event) {
		if($('#pitch').val() == '*' ) {
		   event.preventDefault();
		   alert ('You have to pick a chain pitch first.');
		   $('#pitch').focus();
		} else {
		    
			$( '#chainLength' ).removeAttr('disabled'); 
			$('#fsPartNumber').removeAttr('disabled');
 			$('#rsPartNumber').removeAttr('disabled');
 			$('#crPartNumber').removeAttr('disabled');
			if( $('#chainLength').val()=='') { $('#chainLength').val(1); }
			ResetForm();
			LoadChainChart( $(this).val(), $('#chainLength').val() );
			//$.unblockUI();
		}

	});
	  	
	$( "#chainLength" ).keypress(function(event) {
		if($('#pitch').val() == '*' ) {
		   event.preventDefault();
		   alert ('You have to pick a chain pitch first.');
		   $('#pitch').focus();
		} else if (event.which==13) {
			if ( $(this).val() == '') { $(this).val(1); }
			LoadChainChart( $('#pitch').val(), $(this).val(), $('#ch').val() );	  	// if we had a previous chain selection its stored in #ch
		}			  	
	});
 
    function LoadChainChart($p, $l, $partNumber) {
    
		$.ajax({
			  type: 'GET',
			  url: 'service/select-chain-chart.service.php',
			  data: { pitch: $p ,chainLength: $l, part: $partNumber},
			  beforeSend:function(){
				// load a temporary image in a div
			  },
			  success:function(data){
				$('#chainChart').html(data);
				$('#chainChartTable input').iCheck({		// icheck style applied
					checkboxClass: 'icheckbox_flat-red',
					radioClass: 'iradio_square',
				});
				// We need to have a value in chain part item
				if( $('#ch').val() != '') {
					$('#ch').val( $("input:radio[name='iCheck']:checked").val() );			// Save the newly calculated values to refresh the save
					part=UpdatePriceInChart( $('#ch').val(), 'CH') ;			// brings back part number in string
				}
			  },
			  error:function(){
				$('#chainChart').html('<p class="error"><strong>Oops!</strong></p>');
			  }
			});
    }
		
	/* Once a chain is selected update the contents to the form field for storing */
	// DEPRECATED	      
	function ChainSelected(obj) {
		$partNumber = obj.attr('href');
		$partNumber = $partNumber.substring(1);
		$partDesc = obj.text();
		$( "#chainSelectedPartNumber").val( $partNumber );
		$( "#chainSelectedDesc" ).text( $partNumber + '-' + $partDesc );
		$( "#linkedChainPartDescription").val( $( "#chainSelectedDesc" ).text() );
		// Reformat the part number per Brian's Request
		$masterPartNumber = $('#masterPartNumber').val();
		if( $masterPartNumber.indexOf('-') != -1) {   // xxxxxxxx-9
			hyph = $masterPartNumber.indexOf('-');
			$masterPartNumber = $masterPartNumber.substr(0, hyph) + '-' + obj.attr('alt');
		} else {
			$masterPartNumber = $masterPartNumber + "-" + obj.attr('alt');
		}				
		$('#masterPartNumber').val( $masterPartNumber );  // main part number
		$('#masterPartNumberSpan').text( $masterPartNumber );  // main part number
		$( "#dialog-form" ).dialog( "close" );
	}
	
	function log( message ) {
		$( "<div>" ).text( message ).prependTo( "#log" );
		$( "#log" ).scrollTop( 0 );
	}

	
	// We use this to update the chart for all parts since we 
	// store part number|msrp:dealer:import
	function UpdatePriceInChart(search, partType) {
		if(!search || search=='0') return;
		var prices = []; 
		var part = search.split('|');
		if(part[1]!="") {
			var prices = part[1].split(':');	
			var msrp= prices[0];
			var dealer = prices[1];
			var imp = prices[2];
			switch (partType) {
				case 'FS':	
					$('#fsMSRP').text(msrp);
					$('#fsDealer').text(dealer);
					$('#fsImport').text(imp);	
					break;
				case 'RS':
					$('#rsMSRP').text(msrp);
					$('#rsDealer').text(dealer);
					$('#rsImport').text(imp);	
					break;
				case 'CH':
					$('#clMSRP').text(msrp);
					$('#clDealer').text(dealer);
					$('#clImport').text(imp);	
					break;
				case 'CR':
					$('#crMSRP').text(msrp);
					$('#crDealer').text(dealer);
					$('#crImport').text(imp);	
					break;

			}
			UpdateTotalLines();
		}
		
		return part[0];		// actual part number
	}	


	function UpdateTotalLines(){
		// Update Total line
		t1 = parseFloat($('#fsMSRP').text()) + parseFloat($('#rsMSRP').text()) + parseFloat($('#clMSRP').text()) + parseFloat($('#crMSRP').text());
		t2 = parseFloat($('#fsDealer').text()) + parseFloat($('#rsDealer').text()) + parseFloat($('#clDealer').text()) + parseFloat($('#crDealer').text());
		t3 = parseFloat($('#fsImport').text()) + parseFloat($('#rsImport').text()) + parseFloat($('#clImport').text()) + parseFloat($('#crImport').text());
		t1 = parseFloat(t1).toFixed(2);
		t2 = parseFloat(t2).toFixed(2);
		t3 = parseFloat(t3).toFixed(2);
		$('#totalMSRP').text(t1);
		$('#totalDealer').text(t2);
		$('#totalImport').text(t3);
		
		// update costs
		$('#msrp').val(t1);
		$('#dealerCost').val(t2);
		$('#importCost').val(t3);
	}
	


});		