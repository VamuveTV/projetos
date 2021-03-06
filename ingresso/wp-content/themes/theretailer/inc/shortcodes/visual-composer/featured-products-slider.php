<?php

// [products_slider]

vc_map(array(
   "name"			=> "Featured Products",
   "category"		=> 'Products',
   "description"	=> "Large Slider",
   "base"			=> "products_slider",
   "class"			=> "",
   "icon"			=> "products_slider",

   
   "params" 	=> array(
		
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class"			=> "",
			"heading"		=> "Number of Products",
			"description"	=> "",
			"param_name"	=> "per_page",
			"value"			=> "12",
		),
		
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class"			=> "",
			"heading"		=> "Order By",
			"description"	=> "",
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
			"heading"		=> "Order",
			"description"	=> "",
			"param_name"	=> "order",
			"value"			=> array(
				"Desc"	=> "desc",
				"Asc"	=> "asc"
			),
			"std"			=> "desc",
		)		
		
   )
   
));