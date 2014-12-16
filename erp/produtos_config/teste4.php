<?php
$proxy = new SoapClient('http://loja/api/v2_soap/?wsdl'); // TODO : change url
$sessionId = $proxy->login('adminsoap', 'admin123'); // TODO : change login and pwd if necessary

//$result = $proxy->catalogProductInfo($sessionId, '522013080817','','','sku');


$result = $proxy->catalogProductAttributeInfo($sessionId, 'color');

echo "<h1>";
echo $result->attribute_id;
echo "</h1>";

echo '<pre>';
print_r($result);
?>