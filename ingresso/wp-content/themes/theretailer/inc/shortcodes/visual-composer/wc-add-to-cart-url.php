<?php

// [add_to_cart_url]

vc_map(array(
   "name" 			=> "Add to Cart URL",
   "category" 		=> 'Shop Shortcodes',
   "description"	=> "Place Add to Cart URL",
   "base" 			=> "add_to_cart_url",
   "class" 			=> "",
   "icon" 			=> "add_to_cart_url",
   
   "params" 	=> array(
      
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class"			=> "",
			"heading"		=> __("ID"),
			"param_name"	=> "id",
			"value"			=> "",
		),
		
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class"			=> "",
			"heading"		=> __("SKU"),
			"param_name"	=> "sku",
			"value"			=> "",
		),

   )
   
));