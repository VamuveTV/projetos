<?php
	session_start();
	
	include("../classes/zarbmysql.php");
	include("../conectar.php");
	$banco	= new ZarbMysql();
	$hoje = date("Y-m-d");
	$campos =  array("usu_destino","autorizado","data_autorizacao","observacao");
	$dados = array($_SERVER['cod_usu'],'S',$hoje,$_POST["obs"]);
	$tabela = "transferencia";
	echo $banco->atualiza($tabela, $campos, $dados, $_POST['cod']);
	
	//buscando todos os dados da transferencia
	$sql = "SELECT * FROM transferencia WHERE codigo='".$_POST['cod']."'";
	$res = mysql_query($sql);
	$linha = mysql_fetch_array($res);
	
	//buscando o preco do produto
	$sql = "SELECT g.preco FROM grupo_produtos AS g INNER JOIN produtos AS p ON g.codigo=p.grupo WHERE p.codigo='".$linha['produto']."'";
	$res = mysql_query($sql);
	list($preco)=mysql_fetch_row($res);
	
	//fazendo a entrada e saida de estoque
	//SAIDA
	$campos_saida = array("unidade","produto","quantidade","tipo","centro","unitario_venda","data");
	$dados_saida = array($linha['destino'],$linha['produto'],$linha['quantidade'],'S','F',$preco,$hoje);
	$banco->insere("estoque", $campos_saida, $dados_saida);	
	//ENTRADA
	$campos_entrada = array("unidade","produto","quantidade","tipo","centro","unitario_venda","data");
	$dados_entrada = array($linha['origem'],$linha['produto'],$linha['quantidade'],'E','F',$preco,$hoje);
	$banco->insere("estoque", $campos_entrada, $dados_entrada);
?>