<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	$banco = new ZarbMysql();
	$campos =  array("unidade","nome","login","senha","perfil");
	$dados = array($_POST["unidade"],$_POST["nome"],$_POST["login"],$_POST["senha"],$_POST["perfil"]);
	$tabela = "usuarios";
	echo $banco->atualiza($tabela, $campos, $dados, $_POST['cod']);	
	
?>