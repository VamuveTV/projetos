<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	$banco = new ZarbMysql();
	$campos =  array("nome");
	$dados = array($_POST["nome"]);
	$tabela = "marca";
	
	//verificando se não existe duplicidade do nome
	$sql = "SELECT * FROM $tabela WHERE nome='".$_POST['nome']."' ";
	$res = mysql_query($sql);
	if(mysql_num_rows($res)>0)
		exit("ERRO: Já existe esta marca cadastrada");
	else
		echo $banco->insere($tabela, $campos, $dados);
	
?>