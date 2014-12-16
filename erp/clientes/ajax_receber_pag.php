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
		
	$campos =  array("recebido","recebimento");
	$_POST['data'] = converte_data($_POST['data'],'banco');
	$dados = array("S",$_POST["data"]);
	$tabela = "parcelas";
	
	$banco->atualiza($tabela, $campos, $dados, $_POST['cod']);		
?>