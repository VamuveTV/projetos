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

$hoje = date("Y-m-d");
	
$campos =  array("venda","forma_pagamento","valor","data");
$_POST["dataP"] = converte_data($_POST["dataP"],'banco');
$_POST['valor'] = str_replace(".", "", $_POST['valor']);
$_POST['valor'] = str_replace(",", ".", $_POST['valor']);

$dados = array($_POST["cod"],$_POST["forma"],$_POST["valor"],$_POST["dataP"]);
$tabela = "parcelas";

//verificando se a forma de pagamento tem baixa imediata para ja lançar como recebido
$sql = "SELECT imediato FROM formas_pagamento WHERE codigo='".$_POST['forma']."'";
$res = mysql_query($sql);
list($imediato)=mysql_fetch_row($res);
if($imediato == 'S'){
	$campos[] = 'recebido';
	$campos[] = 'recebimento';
	$dados[] = 'S';
	$dados[] = $hoje;
}

$query = "SELECT SUM(valor * quantidade) FROM produtos_vendas WHERE venda='".$_POST['cod']."'";
$result = mysql_query($query);
list($total)=mysql_fetch_row($result);

$query2 = "SELECT SUM(valor) FROM parcelas WHERE venda='".$_POST['cod']."'";
$result2 = mysql_query($query2);
list($sub_total)=mysql_fetch_row($result2);


$dif = $total - $sub_total;

if($dif < $_POST['valor'])
	echo "ERRO1#".$_POST['valor']."#$dif";
else{
	
	//CASO SEJA CREDIARIO VERIFICA SE O CLIENTE AINDA TEM LIMITE PARA A COMPRA
	if($_POST['forma']=='C'){
		//buscando o limite disponivel para crediario do cliente
		$query3 = "SELECT c.limite FROM clientes AS c INNER JOIN vendas AS v 
					ON c.codigo=v.cliente WHERE v.codigo='".$_POST['cod']."'";
		$result3 = mysql_query($query3);
		list($limite)=mysql_fetch_row($result3);
		
		//buscando o valor de compras por crediario em aberto pelo cliente
		$query4 = "SELECT SUM(p.valor) FROM parcelas AS p INNER JOIN vendas AS v ON p.venda=v.codigo 
					INNER JOIN clientes AS c ON c.codigo=v.cliente 
					WHERE v.codigo='".$_POST['cod']."' AND p.forma_pagamento='C' AND p.recebido='N'";
		$result4 = mysql_query($query4);
		list($em_aberto)=mysql_fetch_row($result4); 
		
		if(($em_aberto + $_POST['valor']) > $limite){
			$disponivel = $limite - $em_aberto;
			echo "ERRO2#$disponivel#";				
		}
		else{
			$banco->insere($tabela, $campos, $dados);
			$cod_parcela = mysql_insert_id();
			$cod_barras = date("Ymd").$cod_parcela;
			$banco->atualiza($tabela, array("codbarras"), array($cod_barras), $cod_parcela);
			
			//atualizando o total
			$query = "SELECT SUM(valor * quantidade) FROM produtos_vendas WHERE venda='".$_POST['cod']."'";
			$result = mysql_query($query);
			list($total)=mysql_fetch_row($result);
			$banco->atualiza("vendas", array("total"), array($total), $_POST['cod']);
		}
	}
	else{		
		$banco->insere($tabela, $campos, $dados);
		$cod_parcela = mysql_insert_id();
		$cod_barras = date("Ymd").$cod_parcela;
		$banco->atualiza($tabela, array("codbarras"), array($cod_barras), $cod_parcela);
		
		//atualizando o total
		$query = "SELECT SUM(valor * quantidade) FROM produtos_vendas WHERE venda='".$_POST['cod']."'";
		$result = mysql_query($query);
		list($total)=mysql_fetch_row($result);
		$banco->atualiza("vendas", array("total"), array($total), $_POST['cod']);
	}
}
echo $_POST["cod"];
	
?>