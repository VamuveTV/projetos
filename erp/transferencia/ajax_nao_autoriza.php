<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	$banco	= new ZarbMysql();
	$hoje = date("Y-m-d");
	$campos =  array("usu_destino","autorizado","data_autorizacao","observacao");
	$dados = array($_SERVER['cod_usu'],'N',$hoje,$_POST["obs"]);
	$tabela = "transferencia";
	echo $banco->atualiza($tabela, $campos, $dados, $_POST['cod']);	
?>