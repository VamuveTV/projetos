<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	$banco	= new ZarbMysql();
	$hoje	= date("Y-m-d");
	$campos	= array("origem","usu_origem","destino","produto","quantidade","observacao","data");
	$dados	= array($_SESSION['unidade_usu'],$_SESSION['cod_usu'],$_POST["destino"],$_POST["produto"],$_POST["quantidade"],$_POST["observacao"],$hoje);
	$tabela = "transferencia";
		
	echo $banco->insere($tabela, $campos, $dados);
	
?>