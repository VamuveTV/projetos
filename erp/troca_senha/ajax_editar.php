<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	$banco = new ZarbMysql();
	$campos =  array("senha");
	$dados = array($_POST["novasenha"]);
	$tabela = "usuarios";
	echo $banco->atualiza($tabela, $campos, $dados, $_POST['cod']);	
	
?>