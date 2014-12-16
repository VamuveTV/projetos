<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	$banco = new ZarbMysql();
	$campos =  array("unidade","nome","login","senha","perfil");
	$dados = array($_POST["unidade"],$_POST["nome"],$_POST["login"],$_POST["senha"],$_POST["perfil"]);
	$tabela = "usuarios";
	
	//verificando se não existe duplicidade do nome
	$sql = "SELECT * FROM $tabela WHERE nome='".$_POST['nome']."' OR login='".$_POST['login']."' ";
	$res = mysql_query($sql);
	if(mysql_num_rows($res)>0)
		exit("ERRO: Já existe este usuário cadastrado");
	else
		echo $banco->insere($tabela, $campos, $dados);
	
?>