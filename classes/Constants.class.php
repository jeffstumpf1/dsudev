<?php
// constants.class.php

class Constants {
	// Table Names for list lookups
	const TABLE_CATEGORY_LIST 	= "CategoryList";		
	const TABLE_CLIP_LIST		= "ClipList";	
	const TABLE_MFG_LIST		= "MFGList";	
	const TABLE_PITCH_LIST		= "PitchList";	
	const TABLE_BRAND_LIST		= "ProductBrandList";	
	const TABLE_STATE_LIST		= "StateList";	
	const TABLE_PAYMENT_LIST	= "PaymentList";	

	// Master Table Names
	const TABLE_CHAIN			= "Chain";	
	const TABLE_CHAIN_KIT		= "ChainKit";	
	const TABLE_SPROCKET		= "Sprocket";
	const TABLE_CUSTOMER		= "Customer";	
	const TABLE_ORDER			= "Orders";	
	const TABLE_ORDER_ITEMS		= "OrderItems";	
	const TABLE_PART			= "PartMaster";	
	const TABLE_INVOICE			= "Invoice";	
	const TABLE_INVOICE_ITEMS	= "InvoiceItems";	
	
	// Utility Tables
	const TABLE_PROPERTIES		= "Properties";
	
	// General 
	const LIMIT_ROWS			= 25;

}
?>