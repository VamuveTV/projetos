<?php
	session_start();
	
	function converte_data($data,$tipo){
	  if($tipo=="usuario")
	    $data = substr($data,-2)."/".substr($data,5,2)."/".substr($data,0,4);
	  
	  if($tipo=="banco")
	    $data = substr($data,-4)."/".substr($data,3,2)."/".substr($data,0,2);
	  return $data;
	}
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	$banco = new ZarbMysql();
	$campos =  array("nome","endereco","numero","bairro","complemento","cidade","estado","cep","telefone","email","renda","limite","cpf","identidade","conjuge","estado_civil","data_nasc","observacao");	
	$_POST['data_nasc'] = converte_data($_POST['data_nasc'],'banco');
	$dados = array($_POST["nome"],$_POST["endereco"],$_POST["numero"],$_POST["bairro"],$_POST["complemento"],$_POST["cidade"],$_POST["estado"],$_POST["cep"],$_POST["telefone"],$_POST["email"],$_POST["renda"],$_POST["limite"],$_POST["cpf"],$_POST["identidade"],$_POST["conjuge"],$_POST["civil"],$_POST["data_nasc"],$_POST["observacao"]);
	$tabela = "clientes";
	//verificando se não existe duplicidade do nome
	$sql = "SELECT * FROM $tabela WHERE nome='".$_POST['nome']."' ";
	$res = mysql_query($sql);
	if(mysql_num_rows($res)>0)
		exit("ERRO: Já existe este cliente cadastrado");
	else
		echo $banco->insere($tabela, $campos, $dados);
	
?>