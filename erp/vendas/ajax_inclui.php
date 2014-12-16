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
		
	$campos =  array("produto","venda","valor","quantidade");
	//verificando se existe promocao para o produto
	$hoje = date("Y-m-d");
	$sql = "SELECT preco FROM promocoes WHERE produto='".$_POST['produto']."' AND data_inicio <= '$hoje' AND data_fim >= '$hoje' AND unidade='".$_SESSION['unidade_usu']."'";
	$res = mysql_query($sql);	
	if(mysql_num_rows($res) > 0)//existe promocao
		list($_POST['preco'])=mysql_fetch_row($res);
	else{
		$sql2 = "SELECT AVG(unitario_venda) FROM estoque WHERE produto='".$_POST['produto']."'";
		$result2 = mysql_query($sql2);
		list($_POST['preco'])=mysql_fetch_row($result2);
	}
		
	$_POST['preco'] = str_replace(",",".",$_POST['preco']);
	$dados = array($_POST["produto"],$_POST["venda"],$_POST["preco"],$_POST['quantidade']);
	$tabela = "produtos_vendas";
	
	echo $banco->insere($tabela, $campos, $dados);
?>