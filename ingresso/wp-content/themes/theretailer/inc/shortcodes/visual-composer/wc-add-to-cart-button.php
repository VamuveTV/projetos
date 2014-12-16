<?php

// [add_to_cart]

vc_map(array(
   "name"			=> "Add to Cart Button",
   "category"		=> 'Products',
   "description"	=> "Place Add to Cart Button",
   "base"			=> "add_to_cart",
   "class"			=> "",
   "icon"			=> "add_to_cart",
   
   "params" 	=> array(
      
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class"			=> "",
			"heading"		=> "ID",
			"param_name"	=> "id",
			"value"			=> "",
		),
		
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class"			=> "",
			"heading"		=> "SKU",
			"param_name"	=> "sku",
			"value"			=> "",
		),

   )
   
));