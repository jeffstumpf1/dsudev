/* ui.js */

    // unblock when ajax activity stops 
    $(document).ajaxStop($.unblockUI); 
 
    function test() { 
        $.ajax({ url: 'wait.php', cache: false }); 
    } 
 
    $(document).ready(function() { 
        $('#pageDemo1').click(function() { 
            $.blockUI(); 
            test(); 
        }); 
        $('#pageDemo2').click(function() { 
            $.blockUI({ message: '<h1><img src="busy.gif" /> Just a moment...</h1>' }); 
            test(); 
        }); 
        $('#pageDemo3').click(function() { 
            $.blockUI({ css: { backgroundColor: '#f00', color: '#fff' } }); 
            test(); 
        }); 
 
        $('#pageDemo4').click(function() { 
            $.blockUI({ message: $('#domMessage') }); 
            test(); 
        }); 
    }); 
