// part.js
var $mp;
var $kit; 
var $fs;
var $rs;
$(function() {
    	
    	$("#category").val(0);
    	$("#createSubmit").attr('disabled','disabled');
    	$('#line-save-price').attr('disabled','disabled');
    	$('#line-total').attr('disabled','disabled');
    	$('#line-price').attr('disabled','disabled');
    	
    	
    	
		$( "#search" ).on('mouseup', function() {
			 $(this).select(); 	
		});
		
		$("#category").change(function() {
		  	$sel = $('#category').val();
		 	if($sel != '*') {
		 		$('#createSubmit').removeAttr('disabled');
		 	} else
		 	  $("#createSubmit").attr('disabled','disabled');  
		});

		
	$('input.calculate').keypress(function(event) {
		
		CalculateLineItem(); 
	});		
		
		
		$('.actionStatus').click(function(e){
			e.preventDefault();
			$part = $(this).parent().attr('pn');
			$ct = $(this).parent().attr('ct');
			$title = 'Deleting Part ('+ $part + ')';
			$( "#dialog-confirm" ).dialog({
			  resizable: false,
			  height:200,
			  modal: true,
			  title: $title,
			  buttons: {
				"Delete": function() {
				  $( this ).dialog( "close" );
				  DeletePartSelected($part, $ct);
				},
				Cancel: function() {
				  $( this ).dialog( "close" );
				}
			  }
			});
			
		});
		
		function DeletePartSelected($part, $cat) {
		$.ajax({ 
			  type: 'GET',
			  url: 'service/delete-part.service.php',
			  data: { part_number: $part, cat: $cat },
			  beforeSend:function(){
				// load a temporary image in a div
			  },
			  success:function(data){
				//alert(data);
				location.reload();
			  },
			  error:function(){
				alert('Error: part not deleted');
			  }
			});
		}



	$(document).on('focus.autocomplete','#frontSprocket', function(event) {
      $(this).autocomplete({ 
      source: function(request, response) {
        $.ajax({
          url: "service/auto-sprocket.service.php",
               dataType: "json",
          data: {
            term : request.term,
            pitch : $('#h_pitch').val(),
            cat: 'FS'
          },
          success: function(data) {
            
            response(data);
          }
        });
      },
    minLength: 2,
    select: function( event, ui ) {
    	event.preventDefault();
		$('#frontSprocket').val(ui.item.value);
		$('#h_fs').val( GetMSRPFromSTRING(ui.item.id) );
		CalculateKitItem();
		}
  		});
	});
		
	$(document).on('focus.autocomplete','#rearSprocket', function(event) {
      $(this).autocomplete({ 
      source: function(request, response) {
        $.ajax({
          url: "service/auto-sprocket.service.php",
               dataType: "json",
          data: {
            term : request.term,
            pitch : $('#h_pitch').val(),
            cat: 'RS'
          },
          success: function(data) {
            
            response(data);
          }
        });
      },
    minLength: 2,
    select: function( event, ui ) {
		event.preventDefault();
		$('#rearSprocket').val(ui.item.value);
		$('#h_rs').val( GetMSRPFromSTRING(ui.item.id) );
		CalculateKitItem();
		}
  		});
	});
	
			
	$(document).on('focus.autocomplete','#partNumber', function(event) {
		$(this).autocomplete({ 
		  source: function(request, response) {
			$.ajax({
			  url: "service/auto-part.service.php",
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
			LoadMasterPart(ui.item.id); 
		} 
		});
		
	});
	
	function handle_MasterPart(json) {
		$mp = new MasterPart(json);
		GetPartInfoThenDisplay($mp);
	}

	function handle_FrontSprocket(json) {
		$fs = new MasterPart(json);
	}

	function handle_RearSprocket(json) {
		$rs = new MasterPart(json);
	}
	
	
	function handle_LoadChainKitInfo(json) {
		$kit = new ChainKit(json);
		$('#frontSprocket').val( $kit.frontSprocket_part_number );
		$('#rearSprocket').val( $kit.rearSprocket_part_number );
		$('#chainLength').val( $kit.chain_length );
		$('#partNumber').val( $kit.part_number );
		LoadChainChart( $mp.pitch_id, $kit.chain_length, $kit.chain_part_number);
		$('#chainChart').show();			
	}
	
	function LoadMasterPart($part_number) {

		$.ajax({
		  url: "service/select-masterPart.service.php",
		  dataType: "json",
		  async: false,
		  data: { part_number : $part_number },
		  success: handle_MasterPart
		});
		
	}
	
	function LoadFrontSprocket($part_number) {
		hyph = $part_number.indexOf('-');
		$part_number = $part_number.substr(0, hyph) 
		$.ajax({
		  url: "service/select-masterPart.service.php",
		  dataType: "json",
		  async: false,
		  data: { part_number : $part_number },
		  success: handle_FrontSprocket
		});
		
	}

	function LoadRearSprocket($part_number) {

		$.ajax({
		  url: "service/select-masterPart.service.php",
		  dataType: "json",
		  async: false,
		  data: { part_number : $part_number },
		  success: handle_RearSprocket
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
	
	
		
	function GetPartInfoThenDisplay($mp) {
		// What service to call
		$json='';
		
		if ($mp.category_id == 'KT') {
			$('#entryKit').show();
			LoadChainKitInfo($mp.part_number);
		} 
					
		if ($mp.category_id == 'CH') {
			GetChainInfo($mp.part_number);
			var $chain = new Chain($mp.part_number);
			$('#entryChain').show();
		} 
				
		if ($mp.category_id == 'FS' || $mp.category_id == 'RS') {
			GetSprocketInfo($mp.part_number);
			var $sprocket = new Sprocket($mp.part_number);
			$('#entrySprocket').show();
		} 
			
		
		// Set master items
		$('#discount').val( $('#customer-discount').val() );
		$('#description').text( $mp.part_description );
		$('#application').text( $mp.part_application );
		$('#msrp').val(parseFloat( $mp.msrp).toFixed(2));
		
				
		total = CalculateLineItem();
		

	}
	
	
	function CalculateLineItem() {
		qty = $('#qty').val();
		disc = $('#discount').val();
		msrp = $('#msrp').val();
		
		if(disc == '') disc=1;

		total = (qty * msrp) - ( qty * msrp * disc) / 100;	
		price = msrp - msrp * disc /100;
		savedPrice = msrp - price;
		$('#unit-price').val( parseFloat(price).toFixed(2) );
		$('#discount-price').val( parseFloat(savedPrice).toFixed(2) );
		$('#total').val( parseFloat(total).toFixed(2) );	
		
		$('#itemCountCost').val( $('#itemCountCost').val() + total );	
		
		return parseFloat(total).toFixed(2);	
	}

			
	function CalculateKitItem() {
		qty = parseInt( $('#qty').val() );
		cl = parseFloat($('#chainLength').val());
		ch_price = parseFloat( $('#h_ch').val() );
		fs_price = parseFloat( $('#h_fs').val() );
		rs_price = parseFloat( $('#h_rs').val() );
		
		if(disc == '') disc=1;
		
		msrp = ch_price  + fs_price + rs_price;
		total = (qty * msrp) - ( qty * msrp * disc) / 100;		
		price = msrp - msrp * disc /100;
		savedPrice = msrp - price;
		
		$('#msrp').val( parseFloat(msrp).toFixed(2) );
		$('#unit-price').val( parseFloat(price).toFixed(2) );
		$('#discount-price').val( parseFloat(savedPrice).toFixed(2) );
		$('#total').val( parseFloat(total).toFixed(2) );	
		
		$('#itemCountCost').val( $('#itemCountCost').val() + total );	
		
		return parseFloat(total).toFixed(2);	
		
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


	$( "#chainLength" ).change(function(event) {
		event.preventDefault();
		if ( $(this).val() == '') { $(this).val(1); }
		LoadChainChart( $mp.pitch_id, $(this).val(), $kit.chain_part_number );	  	// if we had a previous chain selection its stored in #ch
		
		$('#h_ch').val( GetMSRPFromSTRING( $("input[type='radio']:checked").val()) );
		CalculateKitItem();					  	
	});


 	// Attempt at Getting binding to work after 
	// Dynamically generated code from ajax call
	 $('#chainChart').on('ifClicked', '#chainChartTable input', function(event) {
	 	var part = $(this).val();
	 	$('#h_ch').val( GetMSRPFromSTRING(part) );						// saves part in form
		CalculateKitItem();	
			
		$masterPartNumber = $('#partNumber').val();
		if( $masterPartNumber.indexOf('-') != -1) {   // xxxxxxxx-9
			hyph = $masterPartNumber.indexOf('-');
			$masterPartNumber = $masterPartNumber.substr(0, hyph) + '-' + $(this).attr('alt');
		} else {
			$masterPartNumber = $masterPartNumber + "-" + $(this).attr('alt');
		}				
		$('#partNumber').val( $masterPartNumber );  // main part number
		//$('#masterPartNumberSpan').text( $masterPartNumber );  // main part number
	 });	

/*******  Table Objects ***************/

	function MasterPart(obj) {
		//$json = '[{"part_id":"908", "part_number":"JEFFSTESTKIT909:ER-5", "part_description":"the form will no longer submit on enter chain recalculates on leaving the field.  Added a wait screen for the save or submit.", "part_application":"test application", "stock_level":"101", "category_id":"KT", "pitch_id":"520", "msrp":"267.9", "dealer_cost":"171.5", "import_cost":"82.92", "rec_status":"0"}]';
		//var obj = $.parseJSON($json);
		this.part_id = obj.part_id;
		this.part_number = obj.part_number;
		this.part_description = obj.part_description;
		this.part_application = obj.part_application;
		this.stock_level = obj.stock_level;
		this.category_id = obj.category_id;
		this.pitch_id = obj.pitch_id;
		this.msrp = obj.msrp;
		this.dealer_cost = obj.dealer_cost;
		this.import_cost = obj.import_cost;
		
		$('#h_pitch').val( this.pitch_id );
		
	}
	

	function Sprocket(obj) {
		this.sprocket_id = obj.sprocket_id;
		this.category_id = obj.category_id;
		this.part_number = obj.part_number;
		this.product_brand_id = obj.product_brand_id;
		this.sprocket_notes = obj.sprocket_notes;
	}

	function Chain(obj) {
		this.chain_id = obj.chain_id;
		this.part_number = obj.part_number;
		this.category_id = obj.category_id;
		this.product_brand_id = obj.product_brand_id;
		this.clip_id = obj.clip_id;
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