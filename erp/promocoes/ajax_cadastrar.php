<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	
	function converte_data($data,$tipo){
	  if($tipo=="usuario")
	    $data = substr($data,-2)."/".substr($data,5,2)."/".substr($data,0,4);
	  
	  if($tipo=="banco")
	    $data = substr($data,-4)."/".substr($data,3,2)."/".substr($data,0,2);
	  return $data;
	}
	
	$banco = new ZarbMysql();
	$campos =  array("unidade","produto","data_inicio","data_fim","preco");
	$_POST['data_inicio'] = converte_data($_POST['data_inicio'],"banco");
	$_POST['data_fim'] = converte_data($_POST['data_fim'],"banco");
	$_POST['preco'] = str_replace(",", ".", $_POST['preco']);
	$dados = array($_POST["unidade"],$_POST["produto"],$_POST["data_inicio"],$_POST["data_fim"],$_POST["preco"]);
	$tabela = "promocoes";
	
	echo $banco->insere($tabela, $campos, $dados);
	
?>