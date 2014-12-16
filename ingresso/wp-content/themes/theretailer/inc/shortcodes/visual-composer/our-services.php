<?php

// [our_services]

vc_map(array(
   "name"			=> __("Features List"),
   "category"		=> __('Content'),
   "description"	=> __("Description"),
   "base"			=> "our_services",
   "class"			=> "",
   "icon"			=> "our_services",

   
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
			"heading" => __("Link Text"),
			"param_name" => "link_name",
			"value" => "Link Text"
		),
		
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Link URL"),
			"param_name" => "link_url",
			"value" => ""
		),
   )
   
));