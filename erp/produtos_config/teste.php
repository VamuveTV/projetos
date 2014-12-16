<?php
/**
 * Connection API v2
 */
$options = array(
    'trace' => true,
    'connection_timeout' => 120,
    'wsdl_cache' => WSDL_CACHE_NONE,
);
$proxy = new SoapClient('http://loja/api/v2_soap/?wsdl=1', $options);
$sessionId = $proxy->login('adminsoap', 'admin123');

// get attribute set
$attributeSets = $proxy->catalogProductAttributeSetList($sessionId);
$attributeSet = current($attributeSets);
 
$temp = date("hmis"); 
 
/**
 * Simple product #1 (sku : SKU-001)
 */
$productData = array(
    'name' => 'Produto simples 1 001',
    'description' => 'Description of product #1',
    'websites' => array(1), // Id or code of website
    'status' => 1, // 1 = Enabled, 2 = Disabled
    'tax_class_id' => 2, // Default VAT
    'weight' => 0,
    'stock_data' => array(
        'use_config_manage_stock' => 0,
        'manage_stock' => 0, // We do not manage stock, for example
    ),
    'price' => 9.90, // Same price than configurable product, no price change
    'additional_attributes' => array(
        'single_data' => array(
            array(
                'key'   => 'color',
                'value' => '6', // Id or label of color, attribute that will be used to configure product
            ),
            array(
                'key'   => 'tamanho',
                'value' => '7', // Id or label of size, attribute that will be used to configure product
            ),
        ),
    ),
);
// Creation of product #1
$sku1 = "SKU1-$temp";
$proxy->catalogProductCreate($sessionId, 'simple', $attributeSet->set_id, $sku1, $productData);
 
/**
 * Simple product #2 (sku : SKU-002)
 */
$productData = array(
    'name' => 'Produto simples 2 002',
    'description' => 'Description of product #2',
    'websites' => array(1), // Id or code of website
    'status' => 1, // 1 = Enabled, 2 = Disabled
    'tax_class_id' => 2, // Default VAT
    'weight' => 0,
    'stock_data' => array(
        'use_config_manage_stock' => 0,
        'manage_stock' => 0, // We do not manage stock, for example
    ),
    'price' => 8.90, // Red product is $1 less than configurable product
    'additional_attributes' => array(
        'single_data' => array(
            array(
                'key'   => 'color',
                'value' => '3', // Id or label of color, attribute that will be used to configure product
            ),
            array(
                'key'   => 'tamanho',
                'value' => '8', // Id or label of size, attribute that will be used to configure product
            ),
        ),
    ),
);
// Creation of product #2
$sku2 = "SKU2-$temp";
$proxy->catalogProductCreate($sessionId, 'simple', $attributeSet->set_id, $sku2, $productData);
 
/**
 * Configurable product
 */
$productData = array(
    'name' => 'Produto configurável 001',
    'description' => 'Description of configurable product',
    'short_description' => 'Short description of configurable product',
    'websites' => array(1), // Id or code of website
    'status' => 1, // 1 = Enabled, 2 = Disabled
    'tax_class_id' => 2, // Default VAT
    'weight' => 0,
    'stock_data' => array(
        'use_config_manage_stock' => 0,
        'manage_stock' => 0, // We do not manage stock, for example
    ),
    'price' => 9.90,
    'associated_skus' => array($sku1, $sku2), // Simple products to associate
    'price_changes' => array(
        array(
            'color' => array(
                '6' => '1',
                '3' => '2',
            ),
            'tamanho' => array(
                '7'  => '1',
                '8'   => '2',
            ),
        ),
    ),
);
// Creation of configurable product

$sku_conf = "SKU-CONFIGURABLE-$temp";
$proxy->catalogProductCreate($sessionId, 'configurable', $attributeSet->set_id, $sku_conf, $productData);
?>