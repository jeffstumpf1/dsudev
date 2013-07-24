/*
 * chain-kit.js
 */
 $(function() {	

 	//ResetForm();
 
 	function ResetForm() {
		// Setup the form 
		$( "#pitch" ).val(0);
		$( "#chainLength").attr('disabled','disabled').val(1);
		$('#fsPartNumber').attr('disabled','disabled').val('');
		$('#rsPartNumber').attr('disabled','disabled').val('');
	}
 	


	$('#fsPartNumber').autocomplete({
    // source: function() { return "GetState.php?country=" + $('#Country').val();},
      source: function(request, response) {
        $.ajax({
          url: "service/auto-fs.php",
               dataType: "json",
          data: {
            term : request.term,
            pitch : $('#pitch').val()
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
		}
  	});
	
	$('#rsPartNumber').autocomplete({
    // source: function() { return "GetState.php?country=" + $('#Country').val();},
      source: function(request, response) {
        $.ajax({
          url: "service/auto-rs.php",
               dataType: "json",
          data: {
            term : request.term,
            pitch : $('#pitch').val()
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
		}
  	});
  	
	
	
	function log( message ) {
		$( "<div>" ).text( message ).prependTo( "#log" );
		$( "#log" ).scrollTop( 0 );
	}

		
});		