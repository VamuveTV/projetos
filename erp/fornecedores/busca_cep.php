<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	$banco = new ZarbMysql();
	
	$query = "SELECT log_logradouro.LOG_NOME, log_localidade.LOC_NO, log_logradouro.UFE_SG, b.BAI_NO 
				FROM log_logradouro INNER JOIN log_localidade 
				ON log_logradouro.LOC_NU_SEQUENCIAL=log_localidade.LOC_NU_SEQUENCIAL
				INNER JOIN log_bairro AS b ON b.BAI_NU_SEQUENCIAL=log_logradouro.BAI_NU_SEQUENCIAL_INI
				WHERE log_logradouro.CEP='".$_POST['cep']."'";
	$result = mysql_query($query);
	list($rua,$cidade,$uf,$bairro)=mysql_fetch_row($result);
	
	echo "$rua#$cidade#$uf#$bairro";
?>