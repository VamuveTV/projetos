<?php

// [product_categories]

vc_map(array(
   "name"			=> __("Product Categories"),
   "category"		=> __('Products'),
   "description"	=> __("Thumbs"),
   "base"			=> "product_categories",
   "class"			=> "",
   "icon"			=> "product_categories",
   
   "params" 	=> array(
      
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class"			=> "",
			"heading"		=> __("Number"),
			"param_name"	=> "number",
			"value"			=> "",
		),
		
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class"			=> "",
			"heading"		=> __("Order By"),
			"param_name"	=> "orderby",
			"value"			=> array(
				"None"			=> "none",
				"ID"			=> "ID",
				"Name"			=> "name",
				"Date"			=> "date",
				"Menu Order"	=> "menu_order",
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
		
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class"			=> "",
			"heading"		=> __("Hide Empty"),
			"param_name"	=> "hide_empty",
			"value"			=> array(
				"Yes"	=> "1",
				"No"	=> "0"
			),
			"std"			=> "1",
		),
		
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class"			=> "",
			"heading"		=> __("Parent"),
			"description"	=> __("Set the parent paramater to 0 to only display top level categories."),
			"param_name"	=> "parent",
			"value"			=> "",
		),
		
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class"			=> "",
			"heading"		=> __("IDs"),
			"description"	=> __("Set ids to a comma separated list of category ids to only show those."),
			"param_name"	=> "ids",
			"value"			=> "",
		),
   )
   
));