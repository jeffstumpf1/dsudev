<?php
class ProductsOrdered{

	/* Record set Object */
	var $productRow;
	
	/* Orders Product Record */
	var $orders_product_id;
	var $orders_id;
	var $product_id;
	var $product_model;
	var $product_name;
	var $product_price;
	var $product_tax;
	var $product_qty;
	
	var $final_price;
	
	// Get Item Description
	function getCartItem(){
		$desc = $this->product_model."&nbsp;". 
			    $this->product_name. "&nbsp;";
				
		return $desc;
	}	

	// Get Item Quantity
	function getItemQuantity(){
		return $this->product_qty;
	}
		

	// Get Item Price
	function getItemPrice($format){
		return $this->util_formatNumber($this->product_price,$format);
	}
			
	// Calculates Item Total Price
	function getItemTotal($format){
//		$priceCalc =0;
//		$itemprice = number_format($this->product_price,2);
//		$qty = number_format($this->product_qty);
//	    $priceCalc = number_format($itemprice * $qty, 2);
//		
//		$this->itemTotal = $this->itemTotal + $priceCalc;
		
		return $this->util_formatNumber($this->final_price, $format);
	}
	
	
	
	// Utility 
	function util_formatNumber($num, $format){
		$retVal = 0;
		if($format == '$') {
			$retVal = '$'.number_format($num,2);//$this->
		}else 
			$retVal =  number_format($num,2);	
		
		return $retVal;
	}
	
	
	
	/********* INITIALIZE *************/
	function ProductsOrdered($productRow){
		$this->productRow = $productRow;
		
		$this->orders_products_id 	= $this->productRow['orders_products_id'];
		$this->orders_orders_id 	= $this->productRow['orders_id'];
		$this->prodduct_model		= trim($this->productRow['product_model']);
		$this->product_name 		= trim($this->productRow['product_name']);
		$this->product_price 		= $this->productRow['product_price'];
		$this->product_qty			= $this->productRow['product_quantity'];
		$this->final_price          = $this->productRow['final_price'];
		 
	}
}
?>