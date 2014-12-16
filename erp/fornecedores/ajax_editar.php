<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	$banco = new ZarbMysql();
    $campos =  array("nome","email","cep","endereco","complemento","cidade","estado","ie","cnpj","contato","telefone","bairro","numero");
    $dados = array($_POST["nome"],$_POST["email"],$_POST["cep"],$_POST["endereco"],$_POST["complemento"],$_POST["cidade"],$_POST["estado"],$_POST["ie"],$_POST["cnpj"],$_POST["contato"],$_POST["telefone"],$_POST["bairro"],$_POST["numero"]);
	$tabela = "fornecedores";
	echo $banco->atualiza($tabela, $campos, $dados, $_POST['cod']);	
	
?>