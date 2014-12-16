<?php

// [best_selling_products_mixed]

vc_map(array(
   "name" 			=> __("Best Selling Products"),
   "category" 		=> __('Products'),
   "description"	=> __("Slider or Listing"),
   "base" 			=> "best_selling_products_mixed",
   "class" 			=> "",
   "icon" 			=> "best_selling_products_mixed",
   
   "params" 	=> array(
      
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class"			=> "",
			"heading"		=> __("Title"),
			"param_name"	=> "title",
			"value" => "Best Sellers"
		),
		
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class"			=> "",
			"heading"		=> __("Number of Products"),
			"param_name"	=> "per_page",
			"value"			=> "12",
		),
		
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class"			=> "",
			"heading"		=> __("Layout Style"),
			"param_name"	=> "layout",
			"value"			=> array(
				"Listing"	=> "listing",
				"Slider"	=> "slider"
			),
			"std"			=> "slider",
		),
   )
   
));