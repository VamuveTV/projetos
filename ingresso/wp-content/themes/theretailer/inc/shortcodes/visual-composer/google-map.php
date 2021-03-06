<?php

// [google_map]

vc_map(array(
   "name"			=> "Google Map",
   "category"		=> 'Content',
   "description"	=> "Map block",
   "base"			=> "google_map",
   "class"			=> "",
   "icon"			=> "google_map",

   
   "params" 	=> array(
		
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Latitude",
			"param_name" => "lat",
			"value" => "51.51526"
		),
		
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Longitude",
			"param_name" => "long",
			"value" => "-0.13218"
		),
		
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Height",
			"param_name" => "height",
			"value" => "400px"
		),
		
		array(
			"type"			=> "colorpicker",
			"holder"		=> "div",
			"class"			=> "",
			"heading"		=> "Color",
			"param_name"	=> "color",
			"value"			=> "#b39964",
		),
		
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Zoom Level",
			"param_name" => "zoom",
			"value" => "17"
		),
		
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => "Button Text",
			"param_name" => "button_text",
			"value" => "Get Directions"
		),

   )
   
));