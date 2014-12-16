<?php

function conectarSoap($url,$usuario_soap,$senha_soap){
	global $client, $session;
	
	$client = new SoapClient($url.'/api/v2_soap?wsdl=1');
	$session = $client->login($usuario_soap, $senha_soap);
}

?>