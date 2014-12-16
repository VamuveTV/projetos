<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	$banco = new ZarbMysql();
	$campos =  array("nome","sigla","magento","url","usuario_soap","senha_soap","servidor_bd","usuario_bd","senha_bd","bd");
	$dados = array($_POST["nome"],$_POST["sigla"],$_POST["magento"],$_POST["url"],$_POST["usuario_soap"],$_POST["senha_soap"],$_POST["servidor_bd"],$_POST["usuario_bd"],$_POST["senha_bd"],$_POST["bd"]);	
	$tabela = "unidades";
	echo $banco->atualiza($tabela, $campos, $dados, $_POST['cod']);	
	
?>