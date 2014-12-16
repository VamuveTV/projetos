<?php

// [featured_1]

vc_map(array(
   "name"			=> __("Services List"),
   "category"		=> __('Content'),
   "description"	=> __("Description"),
   "base"			=> "featured_1",
   "class"			=> "",
   "icon"			=> "featured_1",

   
   "params" 	=> array(
		
		array(
			"type" => "attach_image",
			"holder" => "div",
			"class" => "",
			"heading" => __("Image"),
			"param_name" => "image_url",
			"value" => ""
		),
		
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Title"),
			"param_name" => "title",
			"value" => "Title"
		),
		
		array(
            "type" => "textarea_html",
            "holder" => "div",
            "class" => "",
            "heading" => __("Content"),
            "param_name" => "content",
            "value" => __("<p>I am test text block. Click edit button to change this text.</p>"),
            "description" => __("Enter your content.")
         ),
		
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Button Text"),
			"param_name" => "button_text",
			"value" => "Button Text"
		),
		
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Button URL"),
			"param_name" => "button_url",
			"value" => ""
		),
   )
   
));