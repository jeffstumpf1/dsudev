  <!doctype html> 
<html lang=en> 
<head>
<meta charset=utf-8>
<title>PHP Label Print</title>
<meta name="viewport" content="width=device-width; initial-scale=1.0">
<link href="foneFrame.css" rel="stylesheet" type="text/css">
<meta name="HandheldFriendly" content="true"/>
<meta name="MobileOptimized" content="320"/>
</head>

<body>

	<nav id=navBtn>
		<ul>
	
			<li><a href="index.php">Home</a></li>
		</ul>
	</nav>
<!--  end of nav  -->

	<header>
	<br>
	
		<center><p class=pTtl>LabelPrint Tool - Brother labels</p></center>
	</header>


    <style type="text/css">
         label
        {
            text-align: left;
            width: 100px;
            padding-right: 10px;
        }
        
        label,input
        {
            display: table;
            float: center;
            margin-bottom: 0px;
        }
       
        
       
        </style>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">   
<center>Part  :  <input type="text" name="part_number" size="20" value="20206K-15"/></center> <br><br>
<center>Order :<input type="text" name="order" size = "20" value="130705815"/></center><br><br>
<center>Date :  <input type="text" name="order_date" size="20" value="09-27-2013"/></center> <br><br>
<center>Desc :  <input type="text" name="desc" size="60" value="SUPERLITE 428 PITCH CHROMOLY STEEL DRILLED FRONT KART SPROCKET - HONDA CR 125 '87-03"/></center> <br><br>
<center>Pitch :  <input type="text" name="pitch" size="20" value="428"/></center> <br><br>
<center>Category :  <input type="text" name="category" size="20" value="FS"/></center> <br><br>
<center>State :  <input type="text" name="address_state" size="20" /></center> <br><br>
<center>Country :  <input type="text" name="address_country" size="20" /></center> <br><br>
<center><input type="submit" value="Print Label" name="submitBtn" /></center>
</form> 
    
   <?php  
 include'config/common.inc.php';  
 if (isset($_POST['submitBtn'])){	
 require ('fpdf.php');
$part=$_POST['part_number'];
$order=$_POST['order'];
$orderDate=$_POST['order_date'];
$desc=$_POST['desc'];
$pitch=$_POST['pitch'];
$cat=$_POST['categeory'];

$state=$_POST['address_state'];
$country=$_POST['address_country'];
$pdf = new FPDF('L','mm',array($labelsize_x,$labelsize_y));
$pdf->AddPage();
$pdf->SetMargins(2,2,2);
$pdf->SetAutoPageBreak(3);
$pdf->SetY(5) ;
$pdf->SetFont('Arial','B',$paper_fonts_Name);
$pdf->Write(4, $part." : ".$pitch." ".$cat."    ( ".$order." / ".$orderDate. " )\n");
//$pdf->Write(4, $firstname." ".$lastname); 
$pdf->Line(3, 10, 95, 10);
$pdf->SetFont('Arial','B',$paper_fonts_Address);
//$pdf->Text(5, 15, $address) ;
$pdf->Write($spacing, "\n".$desc);

$pdf->Write($spacing, "\n".$country); 
$data= date("dmy");  
$fileD = $data."_".$lastname."_".$part.".pdf";

mkdir("./labels/".$data, 0700);
$pdf -> Output("./labels/$data/".$fileD,"F");

 



}
?> 








</body>
</html>
	










