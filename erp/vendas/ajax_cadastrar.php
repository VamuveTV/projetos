<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	$banco = new ZarbMysql();
	
	function converte_data($data,$tipo){
	  if($tipo=="usuario")
	    $data = substr($data,-2)."/".substr($data,5,2)."/".substr($data,0,4);
	  
	  if($tipo=="banco")
	    $data = substr($data,-4)."/".substr($data,3,2)."/".substr($data,0,2);
	  return $data;
	}
		
	$campos =  array("unidade","cliente","data","observacao");
	$_POST['data'] = converte_data($_POST['data'],'banco');
	$dados = array($_SESSION['unidade_usu'],$_POST["cliente"],$_POST["data"],$_POST["observacao"]);
	$tabela = "vendas";
	
	$banco->insere($tabela, $campos, $dados);
    $cod_venda = mysql_insert_id();
	
	$campos =  array("produto","venda","valor","quantidade");
	$dados = array($_POST["produto"],$cod_venda,$_POST["preco"],$_POST['quantidade']);
	$tabela = "produtos_vendas";
	$banco->insere($tabela, $campos, $dados);
	
	echo $cod_venda;
	
?>