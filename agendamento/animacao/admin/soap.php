<?php

$user = 'tiny';
$pwd = '!@#$q1w2e3r4';
$url = 'http://acdigital.com.br/index.php/api/soap/?wsdl';

try {
	$client = new SoapClient( $url );
} catch( Exception $e ) {
	$retorno['erros'][] = array(
		'codigo' => '4',
		'mensagem' => 'Falha no webservice: ' . $e->getMessage()
	);
}       

try {
	$session = $client->login( $user, $pwd );
} catch( Exception $e ) {
	$retorno['erros'][] = array(
		'codigo' => '3',
		'mensagem' => 'Falha na autenticacao: ' . $e->getMessage()
	);
}

?>