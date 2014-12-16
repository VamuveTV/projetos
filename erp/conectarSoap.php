<?php
/* 
$client = new SoapClient('http://calcadospassonobre.com.br/api/v2_soap?wsdl=1');
$session = $client->login('erp', '123@erp'); 
*/
$client = new SoapClient('http://loja/api/v2_soap?wsdl=1');
$session = $client->login('adminsoap', 'admin123');

?>