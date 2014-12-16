<?php
$proxy = new SoapClient('http://loja/api/v2_soap/?wsdl=1');
$sessionId = $proxy->login('adminsoap', 'admin123');
$result = $proxy->catalogProductLinkAssign($sessionId, 'related', '93', '94');
/*
$client = new SoapClient('http://loja/api/v2_soap/?wsdl');
$session = $client->login('adminsoap', 'admin123');

$data = array(
   "position" => 15
  );

$identifierType = "product_id";
$type = "related";
$product = "91";
$linkedProduct = "92";

$orders = $client->catalogProductLinkUpdate($session, $type, $product, $linkedProduct, $data, $identifierType);

echo 'Number of results: ' . count($orders) . '<br/>';
var_dump ($orders);
*/
?>