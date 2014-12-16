<?php

// [title_subtitle]

vc_map(array(
   "name"			=> "Title / Subtitle",
   "category"		=> 'Content',
   "description"	=> "Place Title / Subtitle",
   "base"			=> "title_subtitle",
   "class"			=> "",
   "icon"			=> "title_subtitle",

   
   "params" 	=> array(
      
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class"			=> "",
			"heading"		=> "Title",
			"param_name"	=> "title",
			"value"			=> "",
		),
		
		array(
			"type"			=> "colorpicker",
			"holder"		=> "div",
			"class"			=> "",
			"heading"		=> "Title Color",
			"param_name"	=> "title_color",
			"value"			=> "#000000",
		),
		
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class"			=> "",
			"heading"		=> "Title Size (px)",
			"param_name"	=> "title_size",
			"value"			=> "36",
		),
		
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class"			=> "",
			"heading"		=> "Subtitle",
			"param_name"	=> "subtitle",
			"value"			=> "",
		),
		
		array(
			"type"			=> "colorpicker",
			"holder"		=> "div",
			"class"			=> "",
			"heading"		=> "Subtitle Color",
			"param_name"	=> "subtitle_color",
			"value"			=> "#000000",
		),
		
		array(
			"type"			=> "textfield",
			"holder"		=> "div",
			"class"			=> "",
			"heading"		=> "Subtitle Size (px)",
			"param_name"	=> "subtitle_size",
			"value"			=> "17",
		),
		
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class"			=> "",
			"heading"		=> "With Separator",
			"param_name"	=> "with_separator",
			"value"			=> array(
				"Yes"			=> "yes",
				"No"			=> "no"
			),
			"std"			=> "yes",
		),
		
		array(
			"type"			=> "dropdown",
			"holder"		=> "div",
			"class"			=> "",
			"heading"		=> "Align",
			"param_name"	=> "align",
			"value"			=> array(
				"Left"		=> "left",
				"Center"	=> "center",
				"Right"		=> "right"
			),
			"std"			=> "center",
		),

   )
   
));