<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	$banco = new ZarbMysql();
	$campos =  array("nome");
	$dados = array($_POST["nome"]);
	$tabela = "marca";
	echo $banco->atualiza($tabela, $campos, $dados, $_POST['cod']);	
	
?>