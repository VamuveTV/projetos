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
	
$tabela = "parcelas";

$query = "SELECT SUM(valor * quantidade) FROM produtos_vendas WHERE venda='".$_POST['cod']."'";
$result = mysql_query($query);
list($total)=mysql_fetch_row($result);

$query2 = "SELECT SUM(valor) FROM parcelas WHERE venda='".$_POST['cod']."'";
$result2 = mysql_query($query2);
list($sub_total)=mysql_fetch_row($result2);

$dif = $total - $sub_total;

if($dif < $_POST['totalC'])
	echo "ERRO1#";
else{		
	//gravando as parcelas
	$val_parcela = round($_POST['totalC'] / $_POST['parcelasC']);
	
	$_POST['dataC'] = converte_data($_POST['dataC'],'banco');
				
	for($i = 1; $i <= $_POST['parcelasC']; $i++){
		$campos =  array("venda","forma_pagamento","valor","data","operadora");
		$dados = array($_POST["cod"],"CC",$val_parcela,$_POST["dataC"],$_POST["operadoraC"]);				
		$banco->insere($tabela, $campos, $dados);
		$cod_parcela = mysql_insert_id();
		
		//adicionando na parcela o codigo de barras
		$cod_barras = date("Ymd").$cod_parcela;
		$banco->atualiza($tabela, array("codbarras"), array($cod_barras), $cod_parcela);
		
		//alterando a proxima data de vencimento
		$date = new DateTime($_POST["dataC"]);
		$date->modify('+1 month');
		$_POST["dataC"] = $date->format('Y-m-d');
	}
	
	//atualizando o total
	$query = "SELECT SUM(valor * quantidade) FROM produtos_vendas WHERE venda='".$_POST['cod']."'";
	$result = mysql_query($query);
	list($total)=mysql_fetch_row($result);
	$banco->atualiza("vendas", array("total"), array($total), $_POST['cod']);					
}
echo $_POST["cod"];
	
?>