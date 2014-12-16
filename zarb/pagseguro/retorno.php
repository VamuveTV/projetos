<?php

header('Content-Type: text/html; charset=ISO-8859-1');

define('TOKEN', '332A835C004F413E823DEA1FC8110EF2');

include("../bd.php");

class PagSeguroNpi {
	
	private $timeout = 20; // Timeout em segundos
	
	public function notificationPost() {
		$postdata = 'Comando=validar&Token='.TOKEN;
		foreach ($_POST as $key => $value) {
			$valued    = $this->clearStr($value);
			$postdata .= "&$key=$valued";
		}
		return $this->verify($postdata);
	}
	
	private function clearStr($str) {
		if (!get_magic_quotes_gpc()) {
			$str = addslashes($str);
		}
		return $str;
	}
	
	private function verify($data) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, "https://pagseguro.uol.com.br/pagseguro-ws/checkout/NPI.jhtml");
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$result = trim(curl_exec($curl));
		curl_close($curl);
		return $result;
	}

}

if (count($_POST) > 0) {
	// POST recebido, indica que � a requisi��o do NPI.
	$npi = new PagSeguroNpi();
	$result = $npi->notificationPost();
	
	$transacaoID = isset($_POST['TransacaoID']) ? $_POST['TransacaoID'] : '';
	
	if ($result == "VERIFICADO") {
		//O post foi validado pelo PagSeguro.
		
	} else if ($result == "FALSO") {
		//O post n�o foi validado pelo PagSeguro.
		
		
	} else {
		//Erro na integra��o com o PagSeguro.
		
		
	}

  mysql_query("INSERT INTO testes(entrada) VALUES('$result, transacao: $transacaoID')");	
} else {
	// POST n�o recebido, indica que a requisi��o � o retorno do Checkout PagSeguro.
	// No t�rmino do checkout o usu�rio � redirecionado para este bloco.
	?>
    <h3>Obrigado por efetuar a compra.</h3>
    <?php
}


$hoje = date("d/m/Y h:i:s");
mysql_query("INSERT INTO testes(entrada) VALUES('$hoje')");
?>