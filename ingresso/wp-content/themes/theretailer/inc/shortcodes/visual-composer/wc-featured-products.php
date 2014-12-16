<?php

// [featured_products_mixed]

vc_map(array(
   "name" 			=> __("Featured Products"),
   "category" 		=> __('Products'),
   "description"	=> __("Slider or Listing"),
   "base" 			=> "featured_products_mixed",
   "class" 			=> "",
   "icon" 			=> "featured_products_mixed",
   
   "params" 	=> array(
      
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class"			=> "",
			"heading"		=> __("Title"),
			"param_name"	=> "title",
			"value"			=> "Featured Products"
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
		
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class"			=> "",
			"heading"		=> __("Order By"),
			"param_name"	=> "orderby",
			"value"			=> array(
				"None"	=> "none",
				"ID"	=> "ID",
				"Title"	=> "title",
				"Date"	=> "date",
				"Rand"	=> "rand"
			),
			"std"			=> "date",
		),
		
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class"			=> "",
			"heading"		=> __("Order"),
			"param_name"	=> "order",
			"value"			=> array(
				"Desc"	=> "desc",
				"Asc"	=> "asc"
			),
			"std"			=> "desc",
		),
   )
   
));