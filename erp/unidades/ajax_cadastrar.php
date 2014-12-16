<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	$banco = new ZarbMysql();
	$campos =  array("nome","sigla","magento","url","usuario_soap","senha_soap","servidor_bd","usuario_bd","senha_bd","bd");
	$dados = array($_POST["nome"],$_POST["sigla"],$_POST["magento"],$_POST["url"],$_POST["usuario_soap"],$_POST["senha_soap"],$_POST["servidor_bd"],$_POST["usuario_bd"],$_POST["senha_bd"],$_POST["bd"]);	
	$tabela = "unidades";
	//verificando se não existe duplicidade da sigla e nome
	$sql = "SELECT * FROM $tabela WHERE nome='".$_POST['nome']."' OR sigla='".$_POST['sigla']."' ";
	$res = mysql_query($sql);
	if(mysql_num_rows($res)>0)
		echo "ERRO: Já existe esta unidade cadastrada";
	else
		echo $banco->insere($tabela, $campos, $dados);
	
?>