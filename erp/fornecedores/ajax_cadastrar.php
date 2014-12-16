<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	$banco = new ZarbMysql();
    $campos =  array("nome","email","cep","endereco","complemento","cidade","estado","ie","cnpj","contato","telefone","bairro","numero");
	$dados = array($_POST["nome"],$_POST["email"],$_POST["cep"],$_POST["endereco"],$_POST["complemento"],$_POST["cidade"],$_POST["estado"],$_POST["ie"],$_POST["cnpj"],$_POST["contato"],$_POST["telefone"],$_POST["bairro"],$_POST["numero"]);
	$tabela = "fornecedores";
	//verificando se não existe duplicidade do nome
	$sql = "SELECT * FROM $tabela WHERE nome='".$_POST['nome']."' ";
	$res = mysql_query($sql);
	if(mysql_num_rows($res)>0)
		exit("ERRO: Já existe este fornecedor cadastrado");
	else
		echo $banco->insere($tabela, $campos, $dados);
	
?>