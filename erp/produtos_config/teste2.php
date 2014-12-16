<?php
//define('MAGENTO', realpath('/var/www/magento'));
define('MAGENTO', realpath('C:\www\loja'));

ini_set('memory_limit', '128M');
 
require_once MAGENTO . '/app/Mage.php';
 
// get attribute set
$attributeSets = $client->catalogProductAttributeSetList($session);
$attributeSet = current($attributeSets);

$sku_base = date("Hmis");
$nome_produto = "Produto $sku_base";
 
Mage::app();
        //create dvd english product
	    $product = Mage::getModel('catalog/product');
	    $product->setTypeId('configurable');
	    $product->setTaxClassId(0); //none
	    $product->setWebsiteIds(array(1));  // store id
	    $product->setAttributeSetId($attributeSet); //Videos Attribute Set
	    $product->setSku($sku_base);
	    $product->setName($nome_produto);
	    $product->setDescription("Descrição $nome_produto");
	    $product->setInDepth("video test");    
	    $product->setPrice("129.95");
	    $product->setShortDescription("Descrição curta $nome_produto");
	    $product->setWeight(0);
	    $product->setStatus(1); //enabled
	    $product->setVisibility(4); //catalog and search
	    //$product->setMetaDescription(ereg_replace("\n","","videoTest2.2"));
	    //$product->setMetaTitle(ereg_replace("\n","","videotest2.2"));
	    //$product->setMetaKeywords("video test");
           $data = array('5791'=>
               array('0'=>
                        array('attribute_id'=>'491','label'=>'vhs','value_index'=>'5','is_percent'=>0,'pricing_value'=>''),
                      '1'=>
                        array('attribute_id'=>'500','label'=>'English','value_index'=>'9','is_percent'=>0,'pricing_value'=>'')
                ),
               '5792'=>array('0'=>
                        array('attribute_id'=>'491','label'=>'dvd','value_index'=>'6','is_percent'=>0,'pricing_value'=>''),
                       '1'=>
                         array('attribute_id'=>'500','label'=>'English','value_index'=>'9','is_percent'=>0,'pricing_value'=>'')
                ),
               '5807'=>array('0'=>
                        array('attribute_id'=>'491','label'=>'dvd','value_index'=>'6','is_percent'=>0,'pricing_value'=>''),
                       '1'=>
                         array('attribute_id'=>'500','label'=>'Spanish','value_index'=>'8','is_percent'=>0,'pricing_value'=>'')
                ),
               '5808'=>array('0'=>
                        array('attribute_id'=>'491','label'=>'vhs','value_index'=>'6','is_percent'=>0,'pricing_value'=>''),
                       '1'=>
                         array('attribute_id'=>'500','label'=>'Spanish','value_index'=>'8','is_percent'=>0,'pricing_value'=>'')
                )
            );
	    $product->setConfigurableProductsData($data);
            $data = array('0'=>array('id'=>NULL,'label'=>'Media Format','position'=> NULL,
                   'values'=>array('0'=>
                                            array('value_index'=>5,'label'=>'vhs','is_percent'=>0,
                                                    'pricing_value'=>'0','attribute_id'=>'491'),
                                        '1'=>
                                            array('value_index'=>6,'label'=>'dvd',
			                            'is_percent'=>0,'pricing_value'=>'0','attribute_id'=>'491')
		    ),
                    'attribute_id'=>491,'attribute_code'=>'media_format','frontend_label'=>'Media Format',
		    'html_id'=>'config_super_product__attribute_0'),
                   '1'=>array('id'=>NULL,'label'=>'Language','position'=> NULL,
                   'values'=>array('0'=>
                                            array('value_index'=>8,'label'=>'Spanish','is_percent'=>0,
                                                    'pricing_value'=>'0','attribute_id'=>'500'),
                                        '1'=>
                                            array('value_index'=>9,'label'=>'English',
			                            'is_percent'=>0,'pricing_value'=>'0','attribute_id'=>'500')
		    ),
                    'attribute_id'=>500,'attribute_code'=>'media_format','frontend_label'=>'Language',
		    'html_id'=>'config_super_product__attribute_1')
           );
	    $product->setConfigurableAttributesData($data);
	    $product->setCanSaveConfigurableAttributes(1);
 
	    try{
	    	$product->save();
                $productId = $product->getId();
	    	echo $product->getId() . ", $price, $itemNum added\n";
	    }
	    catch (Exception $e){ 		
	    	echo "$price, $itemNum not added\n";
		echo "exception:$e";
	    } 
?>