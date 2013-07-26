  	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  	
<script>
 $(function() {	
 
	// Attempt at Getting binding to work after 
	// Dynamically generated code from ajax call
	 $('#dialog-form' ).on('click', 'a.chainSelected', function(event) {
		ChainSelected($(this));
	 });
	 
	  $( "#dialog-form" ).dialog({
		  autoOpen: false,
		  height: 400,
		  width: 750,
		  modal: true,
			Cancel: function() {
					  $( this ).dialog( "close" );
			  }				
		});
		
		$( "#selectChain" )
		  .click(function(event) {
			if($('#pitch').val() == '*' ) {
			   event.preventDefault();
			   alert ('You have to pick a chain pitch first.');
			   $('#pitch').focus();
			} else {
				
				$.ajax({
					  type: 'GET',
					  url: 'includes/select-chain.php',
					  data: { pitch: +  $('#pitch').val() },
					  beforeSend:function(){
						// load a temporary image in a div
					  },
					  success:function(data){
						$('#dialog-form').html(data);
					  },
					  error:function(){
						$('#dialog-form').html('<p class="error"><strong>Oops!</strong></p>');
					  }
					});
				
				 $( "#dialog-form" ).dialog( "open" );	
				 
		  }
			
		      });
		
	/* Once a chain is selected update the contents to the form field for storing */	      
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
});		   
</script>
