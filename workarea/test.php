 <?php
 	
    $find = "DA520ZVMXG-8";
    $string="4545DA520ZVMXG-8|1.64:1.05:0.67";
    $pos = strrpos($string, $find);
    if ($pos === false) {
        print "Not found\n";
    } else {
        print "Found!\n";
    }
    
    print "pos:".$pos;
?> 